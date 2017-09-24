<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>轮胎历史曲线</title>
<script src="../lib/jquery/jquery-1.9.0.min.js" type="text/javascript"></script> 
<script src="../js/echarts/echarts.min.js"></script>
</head>

 <script type="text/javascript">
 
	/*require.config({
        paths: {
            echarts: '../js/echarts'
        }
    });*/
	var manager;
	var menu;
	var com_type;
	var com_place;
	var tirecount=6;
	function LoadCharts(oc,type,place,index,ec){
	
	
	/*option = {
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [				
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[]					
				}
					
		},
		{
            name:'限值',
            type:'line',            
			itemStyle:{normal:{color:'#4D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[]					
				}
					
		}		
		]     
	};*/
	
		//if(option)
		/*if(type==0){
			option.title.text=place+"号位压力曲线";
			option.series[0].name="压力值";
		}else{
			option.title.text=place+"号位温度曲线";
			option.series[0].name="温度值";
		}
		
		option.xAxis[0].data=oc.xdata;   //5月6号
		option.series[0].data=[];
		option.series[0].data=oc.ydata;
		
		
		
		if(type==0){
			//给出压力区间
			var xm=oc.xdata[oc.xdata.length-1];	
			var xb=oc.xdata[0];	
			//option.series[0].markLine.data.push([{name:'压力下限',value:oc.min, xAxis: xb, yAxis:oc.min},{xAxis:xm,yAxis:oc.min}]);
			//option.series[0].markLine.data.push([{name:'压力上限',value:oc.max, xAxis: xb, yAxis:oc.max},{xAxis:xm,yAxis:oc.max}]);
		}else
		{
			var xm=oc.xdata[oc.xdata.length-1];			
			option.series[0].markLine.data.push([{name:'温度上限',value:oc.max, xAxis: -1, yAxis:oc.max},{xAxis:xm,yAxis:oc.max}]);
		}
		*/
		/*for(var i=0;i<oc.ydata.length;i++){
			option.series.push({name:oc.ydata[i].name,
								type:'bar',
								stack:'品牌',
								data:oc.ydata[i].data});
		
		}
	*/
	
	option = {
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:["2015-01-01 10:00:00","2015-01-02 10:00:00","2015-01-02 10:00:05","2015-01-02 10:00:10","2015-01-02 10:00:20","2015-01-02 10:00:30","2015-01-02 10:00:40","2015-01-02 10:00:50"]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [				
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[30.1,40.5,33,22,10,8,16,18],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[]					
				}
					
		},
		{
            name:'限值',
            type:'line',            
			itemStyle:{normal:{color:'#4D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[]					
				}
					
		}		
		]     
	};
	
	
	
		    var chartid="chart"+index;
			$("#chart"+index).css("display","inline");
            var myChart = ec.init(document.getElementById(chartid));
			myChart.setOption(option);
			
		/*require(
			[
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line',
            'echarts/chart/map'
			],
        function (ec) {
            //--- 折柱 ---
			//alert("bbbb");
			//alert(index);
			var chartid="chart"+index;
			$("#chart"+index).css("display","inline");
            var myChart = ec.init(document.getElementById(chartid));
			myChart.setOption(option);
		
			
		}
	
		);*/
	}
	
	 function trim(str){ //删除左右两端的空格
　　     return str.replace(/(^\s*)|(\s*$)/g, "");
　　 }
　　 function ltrim(str){ //删除左边的空格
　　     return str.replace(/(^\s*)/g,"");
　　 }
　　 function rtrim(str){ //删除右边的空格
　　     return str.replace(/(\s*$)/g,"");
　　 }

 		      //工具条事件
		function itemclick(item) {
			switch (item.id) {
				case "searchbtn":
					serchpanel();
                  break;
 
          }
      }
	  		
		function Search(surl,type,place,index){
				//
				
			/*require(
			[
            'echarts',           
            'echarts/chart/line',            
			],*/
			//function (ec) {
				//--- 折柱 ---
				//alert("bbbb");
				//alert(index);
				//var chartid="chart"+index;
				//$("#chart"+index).css("display","inline");
				//var myChart = ec.init(document.getElementById(chartid));
				//myChart.setOption(option);
		
			
			
				var ec=echarts;
				
				$.ajax({                             
				url:surl,
				type: "POST",
				async:false,
				success:function (result) {					
					var obj = eval("("+result+")");
					if(obj.status!="OK"){
						//top.$.ligerDialog.error(obj.reason);						
						return;
					}					
					LoadCharts(obj,type,place,index,ec);
					
				},
				error:function(){
					//alert("获取列表失败");
					//top.$.ligerDialog.error("获取数据失败");
				}
			});
			//});
				
		}		
		
		function clearallcharts()
		{
			//
			for(var i=1;i<=20;i++){
				$("#chart"+i).css("height","300px");
				$("#chart"+i).css("width","475px");
				
				$("#chart"+i).css("display","none");
			}
		}
		
		function doserch() {
			
			//if (! $(serchform).valid()){
				//return;
			//}
			
			
            var sendtxt = "&rnd=" + Math.random();
            //var serchtxt = $("#serchform :input").fieldSerialize()+sendtxt;
			//var surl="../ajaction/v1/?menuid=131610&cmdx=qry&"+serchtxt;
			//测试用
			surl="../test_ltyl.php?t=1";
			
			
			//var type=com_type.getValue();
			//var svalue=com_place.getValue().toString();
			//surl=surl+"&type=0";
			var svalue;
			var type=0;
			svalue="1";
			var targetdata = svalue.split(";");
			clearallcharts();
			if(targetdata.length>=1 && targetdata[0]==0){
				//选中了所有
				//alert("获取所有,轮胎数");
				//alert(tirecount);
				var ji=0;
				for(var i=1;i<=tirecount;i++){
					//加载轮胎数据
					ji++;
					Search(surl+"&place_no_v="+i,type,i,ji);
					//Search(surl,function(data){CallBack(data,0,(i),(ji));});
					
				}
			}else{
				//
				//alert("获取部分");
				var targetdata = svalue.split(";");
				var ji=0;
				for (var i = 0; i < targetdata.length; i++) {
					//这里加载对应轮胎数据
					//targetdata[i]
					ji++;
					Search(surl+"&place_no_v="+targetdata[i],type,targetdata[i],ji);
					//Search(surl+"&index="+ji+"&place="+targetdata[i]);
				}
			}
			/*$.ajax({                             
				url:surl,
				type: "POST",				
				success:function (result) {					
					var obj = eval("("+result+")");
					if(obj.status!="OK"){
						top.$.ligerDialog.error(obj.reason);						
						return;
					}
					
					LoadCharts(obj);
					
				},
				error:function(){
					//alert("获取列表失败");
					top.$.ligerDialog.error("获取数据失败");
				}
			});*/
			
			//Search('../ajaction/v1/?menuid=131510&cmd=qry&'+serchtxt);
			//manager.set({url:'../ajaction/v1/?menuid=131510&cmd=qry&'+serchtxt});
			//131110
			//manager.loadData(true);
        }
		
       		
    </script>

<body style="margin-top:0px">

  <form id="form1" onsubmit=" return false ">
    
		<div id="main" style="margin:0px;width:960px">
			<div id="chart1" style="width:450px;height:300px;float:left;display:inline"></div>
			<div id="chart2" style="width:450px;height:300px;float:left;display:inline"></div>
			<div id="chart3" style="width:450px;height:300px;float:left;"></div>
			<div id="chart4" style="width:450px;height:300px;float:left;"></div>
			<div id="chart5" style="width:450px;height:300px;float:left;"></div>
			<div id="chart6" style="width:450px;height:300px;float:left;"></div>
			<div id="chart7" style="width:450px;height:300px;float:left;"></div>
			<div id="chart8" style="width:450px;height:300px;float:left;"></div>
			<div id="chart9" style="width:450px;height:400px;float:left;"></div>
			<div id="chart10" style="width:450px;height:400px;float:left;"></div>
			<div id="chart11" style="width:450px;height:400px;float:left;"></div>
			<div id="chart12" style="width:450px;height:400px;float:left;"></div>
			<div id="chart13" style="width:450px;height:400px;float:left;"></div>
			<div id="chart14" style="width:450px;height:400px;float:left;"></div>
			<div id="chart15" style="width:450px;height:400px;float:left;"></div>
			<div id="chart16" style="width:450px;height:400px;float:left;"></div>
			<div id="chart17" style="width:450px;height:400px;float:left;"></div>
			<div id="chart18" style="width:450px;height:400px;float:left;"></div>
			<div id="chart19" style="width:450px;height:400px;float:left;"></div>
			<div id="chart20" style="width:450px;height:400px;float:left;"></div>
		</div>
		<!--<div id="toolbar1"></div>-->		
	</div>
  </form>
  <div class="az" style="">
        <form id='serchform'>
            <table style='width: 960px' class="bodytable1">
                
                    
				<tr style='height:50px;'>
				<td colspan="10" style='align:center'>
				 <div style='float: left; text-align: center; width: 100%;'>
                        <input  id='Button2' type='button' value='重置' style='height: 24px; width: 80px;'
                            onclick=" doclear() " />						
                        <input  id='Button1' type='button' value='搜索' style='height: 24px; width: 80px;' onclick=" doserch() " />
				</div>
				</td>
				
				</tr>
            </table>
        </form>
    </div>
</body>
</html>
