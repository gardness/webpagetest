import{CPUProfileDataModel as e,CPUProfilerModel as o,CSSMetadata as r,CSSModel as a,CSSProperty as t,CSSStyleDeclaration as n,Connections as S,ConsoleModel as D,Cookie as s,CookieParser as M,DOMDebuggerModel as g,DOMModel as l,DebuggerModel as K,HARLog as i,HeapProfilerModel as c,IsolateManager as d,Issue as u,NetworkLog as v,NetworkManager as C,NetworkRequest as T,OverlayModel as E,PerformanceMetricsModel as k,ProfileTreeModel as p,RemoteObject as y,Resource as P,ResourceTreeModel as f,RuntimeModel as O,Script as R,SecurityOriginManager as N,ServiceWorkerCacheModel as m,ServiceWorkerManager as b,SourceMap as w,SourceMapManager as L,SDKModel as x,TracingManager as F,TracingModel as I}from"./sdk.js";self.SDK=self.SDK||{},SDK=SDK||{},SDK.CPUProfileDataModel=e.CPUProfileDataModel,SDK.CPUProfilerModel=o.CPUProfilerModel,SDK.cssMetadata=r.cssMetadata,SDK.CSSModel=a.CSSModel,SDK.CSSModel.Events=a.Events,SDK.CSSLocation=a.CSSLocation,SDK.CSSProperty=t.CSSProperty,SDK.CSSStyleDeclaration=n.CSSStyleDeclaration,SDK.CSSStyleDeclaration.Type=n.Type,SDK.MainConnection=S.MainConnection,SDK.ConsoleModel=D.ConsoleModel,SDK.ConsoleMessage=D.ConsoleMessage,SDK.ConsoleModel.Events=D.Events,SDK.ConsoleMessage.MessageSource=D.MessageSource,SDK.ConsoleMessage.MessageType=D.MessageType,SDK.ConsoleMessage.MessageLevel=D.MessageLevel,SDK.Cookie=s.Cookie,SDK.CookieReference=s.CookieReference,SDK.CookieParser=M.CookieParser,SDK.DOMDebuggerModel=g.DOMDebuggerModel,SDK.DOMModel=l.DOMModel,SDK.DOMModel.Events=l.Events,SDK.DeferredDOMNode=l.DeferredDOMNode,SDK.DOMDocument=l.DOMDocument,SDK.DOMNode=l.DOMNode,SDK.DebuggerModel=K.DebuggerModel,SDK.DebuggerModel.PauseOnExceptionsState=K.PauseOnExceptionsState,SDK.DebuggerModel.Events=K.Events,SDK.DebuggerModel.BreakReason=Protocol.Debugger.PausedEventReason,SDK.DebuggerModel.Location=K.Location,SDK.DebuggerModel.CallFrame=K.CallFrame,SDK.DebuggerPausedDetails=K.DebuggerPausedDetails,SDK.HARLog=i.HARLog,SDK.HARLog.Entry=i.Entry,SDK.HeapProfilerModel=c.HeapProfilerModel,SDK.IsolateManager=d.IsolateManager,SDK.IsolateManager.MemoryTrend=d.MemoryTrend,SDK.Issue=u.Issue,SDK.NetworkLog=v.NetworkLog,SDK.NetworkLog.Events=v.Events,SDK.NetworkManager=C.NetworkManager,SDK.NetworkManager.Events=C.Events,SDK.NetworkManager.OfflineConditions=C.OfflineConditions,SDK.NetworkManager.Fast3GConditions=C.Fast3GConditions,SDK.NetworkDispatcher=C.NetworkDispatcher,SDK.MultitargetNetworkManager=C.MultitargetNetworkManager,SDK.MultitargetNetworkManager.InterceptedRequest=C.InterceptedRequest,SDK.NetworkRequest=T.NetworkRequest,SDK.NetworkRequest.Events=T.Events,SDK.NetworkRequest.WebSocketFrameType=T.WebSocketFrameType,SDK.OverlayModel=E.OverlayModel,SDK.PerformanceMetricsModel=k.PerformanceMetricsModel,SDK.ProfileTreeModel=p.ProfileTreeModel,SDK.RemoteObject=y.RemoteObject,SDK.Resource=P.Resource,SDK.ResourceTreeModel=f.ResourceTreeModel,SDK.ResourceTreeModel.Events=f.Events,SDK.ResourceTreeFrame=f.ResourceTreeFrame,SDK.RuntimeModel=O.RuntimeModel,SDK.RuntimeModel.Events=O.Events,SDK.ExecutionContext=O.ExecutionContext,SDK.Script=R.Script,SDK.SecurityOriginManager=N.SecurityOriginManager,SDK.SecurityOriginManager.Events=N.Events,SDK.ServiceWorkerCacheModel=m.ServiceWorkerCacheModel,SDK.ServiceWorkerManager=b.ServiceWorkerManager,SDK.SourceMap=w.SourceMap,SDK.TextSourceMap=w.TextSourceMap,SDK.SourceMapManager=L.SourceMapManager,SDK.SourceMapManager.Events=L.Events,SDK.Target=x.Target,SDK.Target.Type=x.Type,SDK.TargetManager=x.TargetManager,SDK.TargetManager.Events=x.Events,SDK.TargetManager.Observer=x.Observer,SDK.TracingManager=F.TracingManager,SDK.TracingModel=I.TracingModel,SDK.TracingModel.Phase=I.Phase,SDK.TracingModel.LegacyTopLevelEventCategory=I.LegacyTopLevelEventCategory,SDK.TracingModel.DevToolsMetadataEventCategory=I.DevToolsMetadataEventCategory,SDK.TracingModel.Event=I.Event,self.SDK.targetManager=x.TargetManager.instance(),self.SDK.isolateManager=d.IsolateManager.instance({forceNew:!0}),self.SDK.domModelUndoStack=l.DOMModelUndoStack.instance();