<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>车速曲线查询</title>
<link href="../lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />
<!--<link href="../lib/ligerUI/skins/ext/css/ligerui-fix.css" rel="stylesheet" type="text/css" />-->
<link href="../css/inputcharts.css" rel="stylesheet" />
<script src="../lib/jquery/jquery-1.9.0.min.js" type="text/javascript"></script> 
<script src="../lib/json2.js" type="text/javascript"></script>
<script src="../lib/ligerUI/js/core/base.js" type="text/javascript"></script>   
<script src="../lib/ligerUI/js/core/inject.js" type="text/javascript"></script>   
<script src="../lib/ligerUI/js/ligerui.all.js" type="text/javascript"></script>        
<script src="../lib/ligerUI/js/plugins/ligerGrid.js" type="text/javascript"></script> 
<script src="../lib/ligerUI/js/plugins/ligerLayout.js" type="text/javascript"> </script> 
<script src="../lib/ligerUI/js/plugins/ligerDateEditor.js" type="text/javascript"></script>
<script src="../lib/ligerUI/js/plugins/ligerPopupEdit.js" type="text/javascript"></script>
<script src="../lib/ligerUI/js/plugins/ligerComboBox.js" type="text/javascript"></script>

<script src="../js/XHD.js" type="text/javascript"> </script>
<script src="../lib/jquery.form.js" type="text/javascript"> </script>

<script src="../js/echarts.js"></script>
<style>
#shezhi input{
	border: 1px solid #1c66dc;
			height: 25px;
			line-height: 2px;
			width: 100px;
			background-color: white;
			border-radius: 20px;
			vertical-align: middle;
			color: #1c66dc;
}
#shezhi input:active,#shezhi input:hover{
	background-color:#1c66dc;
	color:#ffffff;
}


</style>

</head>

 <script type="text/javascript">
 
	require.config({
        paths: {
            echarts: '../js'
        }
    });
	var manager;
	var menu;
	
	
	function LoadCharts(oc){
	
	
	option = {
    title : {
        text: '车速曲线',
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
            name:'速度值',
            type:'line',            
			itemStyle:{normal:{color:'#0099CC'}},
			data:[],
			markPoint : {
                data : [
                    {type : 'max', name: '最高速度'},
                    {type : 'min', name: '最低速度'}
                ]
            },
            markLine : {
                data : [
                    {type : 'average', name: '平均速度'}
                ]
            }
					
		}
		]
	
     
	};
		option.xAxis[0].data=oc.xdata;
		option.series[0].data=oc.ydata;
	
		require(
			[
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line',
            'echarts/chart/map'
			],
        function (ec) {
            //--- 折柱 ---
            var myChart = ec.init(document.getElementById('main'));            
			myChart.setOption(option);
            
			//alert("xxx");
			
			$(window).resize(function () {
                //initLayout();
				myChart.resize();
            });
			
			
		}
	
		);
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
	  function f_reload() {
            //var manager = $("#maingrid4").ligerGetGridManager();
            //manager.loadData(true);
        };
		
		function doclear() {
            $("input:hidden", "#serchform").val("");
            $("input:text", "#serchform").val("");
            $(".l-selected").removeClass("l-selected");
        }
		
		function Search(surl){
			
		}		
		function doserch() {
            var sendtxt = "&rnd=" + Math.random();
            var serchtxt = $("#serchform :input").fieldSerialize()+sendtxt;
			var surl="../ajaction/v1/?menuid=131614&cmdx=qry&"+serchtxt;
			//surl="../test_carspeed.php";
			
			$.ajax({                             
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
			});
			
			//Search('../ajaction/v1/?menuid=131510&cmd=qry&'+serchtxt);
			//manager.set({url:'../ajaction/v1/?menuid=131510&cmd=qry&'+serchtxt});
			//131110
			//manager.loadData(true);
        }
		
        $(function () {
				
				  
                //$("#grid").height(document.documentElement.clientHeight - $(".toolbar").height());
				$('form').ligerForm();
				//toolbar();
				//
				serchpanel();
				//var oc={"legdata":[],"xdata":[],"ydata":[]}; 
				//LoadCharts(oc);
				
        });		
		function getGridOptions(checkbox) {
             var options = {
                 columns: [
                 { display: '车牌号码', name: 'plate_no', align: 'left', width: 400, minWidth: 60 },
                 { display: '车载编码', name: 'v_term_no', minWidth: 120, width: 400 },								 
                 ], switchPageSizeApplyComboBox: false,
                 /*data: $.extend({}, CustomersData),*/
				 url:'../ajaction/v1/?menuid=121010&cmd=qry&t=1',
                 pageSize: 10,
				 dataAction:'server'
				
             };
             return options;
         }

		
		//表单搜索
		 function initSerchForm() {
            //$('#title').ligerComboBox({ width: 97, emptyText: '（空）'});         
 			 $("#begin_date").ligerDateEditor({ showTime: false, labelWidth: 100, labelAlign: 'left' });
			$("#end_date").ligerDateEditor({ showTime: false, labelWidth: 100, labelAlign: 'left' });
			$("#plate_no").ligerPopupEdit({
             condition: {
                 prefixID:'plate_no',
                 fields: [{name:'plate_no',type:'text',label:'车牌号'}],
				 
             },
             grid: getGridOptions(true),
				valueField: 'bus_id',
				textField: 'plate_no',
				width: 100,
				searchClick:function(obj){					
					var s="";
					for(var i=0;i<obj.rules.length;i++){
						s=s+obj.rules[i].field+"="+encodeURI(obj.rules[i].value);
					}
					if(s!="") s="&"+s;
					$('.pcontrol input', obj.grid.toolbar).val(1);
					obj.grid.changePage('input');
					obj.grid.set({url:'../ajaction/v1/?menuid=121010&cmd=qry&t=1'+s});
					obj.grid.loadData(true);
					
				},
				dlgWidth:800,
				dlgHeight:300,
				onSelect:function(x){
					
				}
			});
		}
		
		
		
		
		function serchpanel() {
            initSerchForm();
            if ($(".az").css("display") == "none") {
                $("#grid").css("margin-top", $(".az").height() + "px");
                //$("#maingrid4").ligerGetGridManager().onResize();
                //$("#maingrid5").ligerGetGridManager().onResize();
				$(".az").css("display","inline");
				$(".az").css("position","absolute");
				$(".az").css("left","5px");
				$(".az").css("top","0px");
				
				//alert("1");
            } else {
                $("#grid").css("margin-top", "0px");
				$(".az").css("display","none");
				
                //$("#maingrid4").ligerGetGridManager().onResize();
                //$("#maingrid5").ligerGetGridManager().onResize();
				//alert("2");
            }
            //$("#company").focus();
        }		
		//serchpanel();
    </script>

<body style="margin-top:0px">
 <div id="message" style="width:800px"></div>
<div class="l-loading" style="display:none" id="pageloading"></div> 
  <form id="form1" onsubmit=" return false ">
    <div id="toolbar" ></div>	
	<div id="grid">
		<div id="main" style="height:400px;margin:0px;width:90%"></div>
		<!--<div id="toolbar1"></div>-->		
	</div>
  </form>
  <div class="az" style="display:none;">
        <form id='serchform'>
            <table style='width: 960px' class="bodytable1">
                <tr>
                    <td>
                        <div style='float: left; text-align: left; width: 60px;margin-top: 10px;'>起始日期：</div>
					</td>
					<td>
						<div style='float: left;'>
						<input type='text' id='begin_date' name='begin_date'  ligerui='{width:120}' validate="{required:true}" />
						</div>
                    </td>
					<td>
                        <div style='float: left; text-align: left; width: 60px;margin-top: 10px;'>终止日期：</div>
					</td>
					<td>
						<div style='float: left;'>
						<input type='text' id='end_date' name='end_date'  ligerui='{width:120}' validate="{required:true}" />
						</div>
                    </td>
					<td>
                        <div style='float: left; text-align: left; width: 60px;margin-top: 10px;'>车辆号码：</div>
					</td>
					<td>
						<div style='float: left;'>
						<!--<input type='text' id='plate_no' name='plate_no'  ligerui='{width:120}' />-->
						<input id="plate_no"  name='plate_no' type="text" readonly="" style="width: 120px;" validate="{required:true}"  />
						</div>
                    </td>
					<td id="shezhi" style='align:left'>
                        <input  id='Button2' type='button' value='重置' style='height: 24px; width: 80px;margin-top: 10px;'
                            onclick=" doclear() " />						
                        <input  id='Button1' type='button' value='搜索' style='height: 24px; width: 80px;margin-top: 10px;' onclick=" doserch() " />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
