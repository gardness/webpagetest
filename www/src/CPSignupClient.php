<?php

declare(strict_types=1);

namespace WebPageTest;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use WebPageTest\SignupToken;
use GraphQL\Client as GraphQLClient;
use Exception as BaseException;
use GraphQL\Exception\QueryError;
use GraphQL\Query;
use GraphQL\Mutation;
use GraphQL\Variable;
use WebPageTest\Plan;
use WebPageTest\CPGraphQlTypes\CPSignupInput;
use WebPageTest\CPGraphQlTypes\ChargifyAddressInput as ShippingAddress;
use WebPageTest\CPGraphQlTypes\ChargifySubscriptionPreviewResponse as SubscriptionPreview;

class CPSignupClient
{
    private GraphQLClient $graphql_client;
    private string $base_uri;
    private string $client_id;
    private string $client_secret;
    private string $grant_type;
    private string $gql_uri;

    public function __construct(array $options = [])
    {
        $base_uri = $options['base_uri'] ?? null;
        $client_id = $options['client_id'] ?? null;
        $client_secret = $options['client_secret'] ?? null;
        $grant_type = $options['grant_type'] ?? null;

        $gql_uri = $options['gql_uri'] ?? null;

        if (
            is_null($base_uri) ||
            is_null($gql_uri) ||
            is_null($client_id) ||
            is_null($client_secret) ||
            is_null($grant_type)
        ) {
            throw new BaseException('base_uri, client_id, client_secret, and grant_type are all required');
        }

        $this->access_token = null;
        $this->graphql_client = new GraphQLClient($gql_uri);
        $this->base_uri = $base_uri;
        $this->gql_uri = $gql_uri;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->grant_type = $grant_type;
    }

    public function authenticate(string $access_token): void
    {
        $this->graphql_client = new GraphQLClient(
            $this->gql_uri,
            ['Authorization' => "Bearer {$access_token}"]
        );
    }

    public function getAuthUrl(string $login_verification_id): string
    {
        return "{$this->base_uri}/auth/WptAccount/Signup?token={$login_verification_id}";
    }

    public function getAuthToken(): SignupToken
    {
        $uri = "/auth/connect/token";
        $basic_token = base64_encode(urlencode($this->client_id) . ":" . urlencode($this->client_secret));
        $body = array(
        'grant_type' => $this->grant_type
        );
        $headers = array(
        'Authorization' => "Basic {$basic_token}"
        );
        $data = $this->makeRequest('POST', $uri, $headers, $body);
        return new SignupToken($data);
    }

    public function signup(array $options): array
    {
        $first_name = $options['first_name'] ?? null;
        $last_name = $options['last_name'] ?? null;
        $company = $options['company'] ?? null;
        $email = $options['email'] ?? null;
        $password = $options['password'] ?? null;

        if (is_null($first_name) || is_null($last_name) || is_null($email) || is_null($password)) {
            throw new BaseException('first_name, last_name, email, and password are all required');
        }

        $gql = (new Mutation('wptAccountCreate'))
        ->setVariables([
        new Variable('wptAccount', 'WptSignupInputType', true)
        ])
        ->setArguments([
        'wptAccount' => '$wptAccount'
        ])
        ->setSelectionSet([
        'firstName',
        'lastName',
        'company',
        'email',
        'loginVerificationId'
        ]);

        $wpt_account = [
        'email' => $email,
        'firstName' => $first_name,
        'lastName' => $last_name,
        'company' => $company,
        'password' => $password
        ];

        $variables_array = array('wptAccount' => $wpt_account);

        try {
            $results = $this->graphql_client->runQuery($gql, true, $variables_array);
            return $results->getData()['wptAccountCreate'];
        } catch (QueryError $e) {
            throw new \WebPageTest\Exception\ClientException($e->getMessage());
        }
    }

    public function signupWithChargify(CPSignupInput $wpt_account): array
    {
        $gql = (new Mutation('wptAccountCreate'))
        ->setVariables([
            new Variable('wptAccount', 'WptSignupInputType', true)
        ])
        ->setArguments([
            'wptAccount' => '$wptAccount'
        ])
        ->setSelectionSet([
            'firstName',
            'lastName',
            'company',
            'email',
            'loginVerificationId'
        ]);

        $variables_array = array('wptAccount' => $wpt_account->toArray());

        try {
            $results = $this->graphql_client->runQuery($gql, true, $variables_array);
            return $results->getData()['wptAccountCreate'];
        } catch (QueryError $e) {
            throw new \WebPageTest\Exception\ClientException($e->getMessage());
        }
    }

    public function getWptPlans(): PlanList
    {
        $gql = (new Query('wptPlan'))
            ->setSelectionSet([
                'name',
                'priceInCents',
                'description',
                'interval',
                'monthlyTestRuns'
            ]);

        $results = $this->graphql_client->runQuery($gql, true);
        $plans = array_map(function ($data): Plan {
            $options = [
                'id' => $data['name'],
                'name' => $data['description'],
                'priceInCents' => $data['priceInCents'],
                'billingFrequency' => $data['interval'],
                'runs' => $data['monthlyTestRuns']
            ];

            return new Plan($options);
        }, $results->getData()['wptPlan'] ?? []);

        $plans = array_filter($plans, function (Plan $plan) {
          /** This is a bit of a hack for now. These are our approved plans for new
           * customers to be able to use. We will better handle this from the backend
           * */
            return strtolower($plan->getId()) == 'ap5' ||
                 strtolower($plan->getId()) == 'ap6' ||
                 strtolower($plan->getId()) == 'ap7' ||
                 strtolower($plan->getId()) == 'ap8' ||
                 strtolower($plan->getId()) == 'mp5' ||
                 strtolower($plan->getId()) == 'mp6' ||
                 strtolower($plan->getId()) == 'mp7' ||
                 strtolower($plan->getId()) == 'mp8';
        });

        return new PlanList(...$plans);
    }

    public function getChargifySubscriptionPreview(string $plan, ShippingAddress $shipping_address): SubscriptionPreview
    {
        $gql = (new Query('wptSubscriptionPreview'))
            ->setVariables([
                new Variable('wptPlanHandle', 'String', true),
                new Variable('shippingAddress', 'ChargifyAddressInputType', true)
            ])
            ->setArguments([
                'wptPlanHandle' => '$wptPlanHandle',
                'shippingAddress' => '$shippingAddress'
            ])
            ->setSelectionSet([
                'totalInCents',
                'subTotalInCents',
                'taxInCents'
            ]);

        $variables = [
            'wptPlanHandle' => $plan,
            'shippingAddress' => $shipping_address->toArray()
        ];

        $response = $this->graphql_client->runQuery($gql, true, $variables);
        $data = $response->getData()['wptSubscriptionPreview'];

        return new SubscriptionPreview([
          "total_in_cents" => $data['totalInCents'],
          "sub_total_in_cents" => $data['subTotalInCents'],
          "tax_in_cents" => $data['taxInCents']
        ]);
    }

    private function makeRequest(string $method, string $url, array $headers, array $body): array
    {
        $client = new Client(array(
        'base_uri' => $this->base_uri
        ));
        $options = [
        'form_params' => $body,
        'headers' => $headers
        ];
        try {
            $response = $client->request($method, $url, $options);
            $body = (string) $response->getBody();
            return json_decode($body, true);
        } catch (ClientException $e) {
            throw $e;
        }
    }
}
