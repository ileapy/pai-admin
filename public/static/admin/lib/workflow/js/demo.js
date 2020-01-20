jsPlumb.ready(function () {

    var instance = window.jsp = jsPlumb.getInstance({
        // default drag options
        DragOptions: { cursor: 'pointer', zIndex: 2000 },
        // the overlays to decorate each connection with.  note that the label overlay uses a function to generate the label text; in this
        // case it returns the 'labelText' member that we set on each connection in the 'init' method below.
        ConnectionOverlays: [
            [ "Arrow", {
                location: 1,
                visible:true,
                width:11,
                length:11,
                id:"ARROW",
                events:{
                    click:function() {console.log("you clicked on the arrow overlay")}
                }
            } ],
            [ "Label", {
                location: 0.1,
                id: "label",
                cssClass: "aLabel",
                events:{
                    tap:function() { 
                    	console.log($(this).attr("label")); 
                    	}
                }
            }]
        ],
        Container: "canvas"
    });

    var basicType = {
        connector: "StateMachine",
        paintStyle: { stroke: "red", strokeWidth: 6 },
        hoverPaintStyle: { stroke: "blue" },
        overlays: [
            "Arrow"
        ]
    };
    instance.registerConnectionType("basic", basicType);

    // this is the paint style for the connecting lines..
    var connectorPaintStyle = {
            strokeWidth: 4,
            stroke: "#61B7CF",
            joinstyle: "round",
            outlineStroke: "white",
            outlineWidth: 4
        },
    // .. and this is the hover style.
        connectorHoverStyle = {
            strokeWidth: 3,
            stroke: "#216477",
            outlineWidth: 5,
            outlineStroke: "white"
        },
        endpointHoverStyle = {
            fill: "#216477",
            stroke: "#216477"
        },
    // the definition of source endpoints (the small blue ones)
        sourceEndpoint = {
            endpoint: "Dot",
            paintStyle: {
                stroke: "#7AB02C",
                fill: "transparent",
                radius: 7,
                strokeWidth: 1
            },
            isSource: true,
            connector: [ "Flowchart", { stub: [40, 60], gap: 10, cornerRadius: 5, alwaysRespectStubs: true } ],
            connectorStyle: connectorPaintStyle,
            hoverPaintStyle: endpointHoverStyle,
            connectorHoverStyle: connectorHoverStyle,
            dragOptions: {},
            overlays: [
                [ "Label", {
                    location: [0.5, 1.5],
                    label: "Drag",
                    cssClass: "endpointSourceLabel",
                    visible:false
                } ]
            ]
        },
    // the definition of target endpoints (will appear when the user drags a connection)
        targetEndpoint = {
            endpoint: "Dot",
            paintStyle: { fill: "#7AB02C", radius: 7 },
            hoverPaintStyle: endpointHoverStyle,
            maxConnections: -1,
            dropOptions: { hoverClass: "hover", activeClass: "active" },
            isTarget: true,
            overlays: [
                [ "Label", { location: [0.5, -0.5], label: "Drop", cssClass: "endpointTargetLabel", visible:false } ]
            ]
        },
        init = function (connection) {
            connection.getOverlay("label").setLabel(connection.sourceId.substring(15) + "-" + connection.targetId.substring(15));
        };

    var _addEndpoints = function (toId, sourceAnchors, targetAnchors) {
        for (var i = 0; i < sourceAnchors.length; i++) {
            var sourceUUID = toId + sourceAnchors[i];
            instance.addEndpoint("flowchart" + toId, sourceEndpoint, {
                anchor: sourceAnchors[i], uuid: sourceUUID
            });
        }
        for (var j = 0; j < targetAnchors.length; j++) {
            var targetUUID = toId + targetAnchors[j];
            instance.addEndpoint("flowchart" + toId, targetEndpoint, { 
            	anchor: targetAnchors[j], uuid: targetUUID 
            });
        }
    };
  
    var processId=$("#processId").val();

    // suspend drawing and initialise.
    instance.batch(function () {
		var nodes=[{"nodeId":"3","name":"开始","cssLeft":"180px","cssTop":"60px"},{"nodeId":"4","name":"准备","cssLeft":"180px","cssTop":"240px"}];
		var directions=[{"sourceId":"flowchartWindow3","targetId":"flowchartWindow4","nodeFrom":"3","nodeTo":"4","condName":"3-4","uuid0":"Window3BottomCenter","uuid1":"Window4TopCenter"}];
		//添加点
		for (var i = 0; i < nodes.length; i++) {
			addNode(nodes[i].nodeId,nodes[i].name,nodes[i].cssTop,nodes[i].cssLeft)
			
		}
		//添加连线
		for (var j = 0; j < directions.length; j++) {
			instance.connect({uuids: [directions[j].uuid0, directions[j].uuid1], editable: true});
		}
     	
        // listen for new connections; initialise them the same way we initialise the connections at startup.
        instance.bind("connection", function (connInfo, originalEvent) {
            init(connInfo.connection);
        });

        // make all the window divs draggable
        instance.draggable(jsPlumb.getSelector(".flowchart-demo .window"), { grid: [20, 20] });
        // THIS DEMO ONLY USES getSelector FOR CONVENIENCE. Use your library's appropriate selector
        // method, or document.querySelectorAll:
        //jsPlumb.draggable(document.querySelectorAll(".window"), { grid: [20, 20] });
        //
        // listen for clicks on connections, and offer to delete connections on click.
        //给连线添加点击事件
        instance.bind("click", function (conn, originalEvent) {
            //if (confirm("Delete connection from " + conn.sourceId + " to " + conn.targetId + "?"))
            	//conn.getOverlay("label").setLabel(conn.sourceId.substring(15) + "-" + conn.targetId.substring(15)+"修改了Label内容");
            	var labelVal=conn.getOverlay("label").getLabel();
            	$("#nodeEdit").css('display','none');
            	$("#linkEdit").css('display','block');
            	$("input[name=nodeFrom]").val(conn.sourceId.substring(15));
            	$("input[name=nodeTo]").val(conn.targetId.substring(15));
            	$("input[name=windowFrom]").val(conn.sourceId);
            	$("input[name=windowTo]").val(conn.targetId);      	 
        });

        instance.bind("connectionDrag", function (connection) {
            console.log("connection " + connection.id + " is being dragged. suspendedElement is ", connection.suspendedElement, " of type ", connection.suspendedElementType);
        });

        instance.bind("connectionDragStop", function (connection) {
            console.log("connection " + connection.id + " was dragged");
        });

        instance.bind("connectionMoved", function (params) {
            console.log("connection " + params.connection.id + " was moved");
        });
        
        $(".window").click(function(){
        	nodeclick(this);
        });
    });

    jsPlumb.fire("jsPlumbDemoLoaded", instance);
    $("#addnode").click(function(){
		 var maxSeq=0;
		 $("#canvas").children(".window").each(function(){
			 var id=$(this).attr("id");
			 var index=id.substring(15);
			 if(parseInt(index)>parseInt(maxSeq)){
				 maxSeq=index;
			 }
		 });
		 var newIndex=maxSeq;
		 newIndex++;
		 addNode(newIndex,newIndex,'80px','60px');
		 $(".window").prop("onclick",null).off("click");
		 $(".window").click(function(){
		 	nodeclick(this);
		 });
		
	 });
    function addNode(index,name,top,left){
		var div="<div class='window jtk-node' id='flowchartWindow"+index+"' style='top:"+top+";left:"+left+";'><strong>"+name+"</strong><br/><br/></div>";
		 $("#canvas").append(div);
		 _addEndpoints("Window"+index+"", ["LeftMiddle", "RightMiddle", "BottomCenter"],["TopCenter"]);
			//设置可以拖动
		 instance.draggable(jsPlumb.getSelector(".flowchart-demo .window"), { grid: [20, 20] });
	}
    function nodeclick(e){
    	var nodeId=$(e).attr("id").substring(15);
    	$("#windowId").val($(e).attr("id"));
    	var nodeName=$(e).children("strong").text();
    	$("input[name=name]").val(nodeName);
    	$("#linkEdit").css('display','none');
    	$("#nodeEdit").css('display','block');
    	
    }
    
     /**
     * 节点编辑保存
     */
    $(".node-edit-save").click(function(){
    	var windowId=$("#windowId").val();
    	var nodeName=$("input[name=name]").val();
    	var page=$("input[name=page]").val();
    	var startFlag=$("select[name=startFlag]").val();
		$("#"+windowId+"").children("strong").html(nodeName);
    	
    });
    /**
     * 节点删除
     */
    $(".node-edit-delete").click(function(){
		var windowId=$("#windowId").val();
		instance.remove(windowId);
		$("#nodeEdit").css('display','none');
    });
    /**
     * 连线编辑保存
     */
    $(".link-edit-save").click(function(){
    	var nodeFrom= $("input[name=nodeFrom]").val();
    	var nodeTo= $("input[name=nodeTo]").val();
    	var sourceId=$("input[name=windowFrom]").val();
    	var targetId=$("input[name=windowTo]").val();
    	var hasCondition=$("select[name=hasCondition]").val();
    	var condType=$("select[name=condType]").val();
    	var condName=$("input[name=condName]").val();
    	var condValue=$("input[name=condValue]").val();   	
 		var conns=instance.getConnections({
			  source:sourceId,
			  target:targetId
			});
 		var uuid0=conns[0].endpoints[0].getUuid();
		var uuid1=conns[0].endpoints[1].getUuid();
		conns[0].getOverlay("label").setLabel(condName);
    	var data={};
    	data.nodeFrom=nodeFrom;
    	data.nodeTo=nodeTo;
    	data.sourceId=sourceId;
    	data.targetId=targetId;
    	data.hasCondition=hasCondition;
    	data.condType=condType;
    	data.condName=condName;
    	data.condValue=condValue;
    	data.uuid0=uuid0;
    	data.uuid1=uuid1;
    	data.processId=processId;
    	console.log(data);
    });
    /**
     * 连线删除
     */
    $(".link-edit-delete").click(function(){
		var sourceId=$("input[name=windowFrom]").val();
		var targetId=$("input[name=windowTo]").val();
		var nodeFrom= $("input[name=nodeFrom]").val();
		var nodeTo= $("input[name=nodeTo]").val();
		var conns=instance.getConnections({
			source:sourceId,
			target:targetId
		});
		instance.deleteConnection(conns[0]);
		$("#linkEdit").css('display','none');
		var data={};
		data.nodeFrom=nodeFrom;
		data.nodeTo=nodeTo;
		data.processId=processId;
		console.log(data);
  
    });
    
    $(".process-edit-save").click(function(){
    	var directions=[];
    	var nodes=[];
    	var conns=instance.getConnections();
    	for (var i = 0; i < conns.length; i++) {
    		var sourceId=conns[i].sourceId;
    		var targetId=conns[i].targetId;
    		var nodeFrom=conns[i].sourceId.substring(15);
    		var nodeTo=conns[i].targetId.substring(15);
    		var condName=conns[i].getOverlay("label").getLabel();
    		var uuid0=conns[i].endpoints[0].getUuid();
    		var uuid1=conns[i].endpoints[1].getUuid();
    		var direction={};
    		direction.processId=processId;
    		direction.sourceId=sourceId;
    		direction.targetId=targetId;
    		direction.nodeFrom=nodeFrom;
    		direction.nodeTo=nodeTo;
    		direction.condName=condName;
    		direction.uuid0=uuid0;
    		direction.uuid1=uuid1;
    		directions.push(direction);
		}
    	var winds=$("#canvas").children(".window");
    	winds.each(function(){
    		var cssLeft= $(this).css("left");
    		var cssTop= $(this).css("top");
    		var name= $(this).children("strong").text();
    		var nodeId= $(this).attr("id").substring(15);
    		
    		var node={};
    		node.nodeId=nodeId;
    		node.name=name;
    		node.cssLeft=cssLeft;
    		node.cssTop=cssTop;
    		node.processId=processId;
    		nodes.push(node);
    	});
    	 var directionsStr=JSON.stringify(directions);
    	 var nodesStr=JSON.stringify(nodes);
    	console.log(directionsStr);
		console.log(nodesStr);
    });
});