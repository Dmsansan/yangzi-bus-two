<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>轮胎库存查询</title>
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
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    legend: {
        //data:['规格1','规格2','规格3','规格4']  //这里为规格名
		data:oc.legdata
    },
    toolbox: {
        show : true,
        orient: 'vertical',
        x: 'right',
        y: 'center',
        feature : {
            mark : {show: false},
            dataView : {show: true, readOnly: true},
            magicType : {show: false, type: ['line', 'bar', 'stack']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            data : oc.xdata //这里为X轴数据
		   //data:['佳通','韩泰']
        }
    ],
    yAxis : [
        {
            type : 'value'
        }
    ],
    series : []
};
		for(var i=0;i<oc.ydata.length;i++){
			option.series.push({name:oc.ydata[i].name,
								type:'bar',
								stack:'品牌',
								data:oc.ydata[i].data});
		
		}
	
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
			var surl="../ajaction/v1/?menuid=131510&cmdx=qry&"+serchtxt;
			//surl="../test_zxt.php";
			
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
                 { display: '品牌编号', name:'brand_id', align: 'left', width: 60 },
                { display: '品牌代码', name:'brand_no', width:150,isSort:false },
				{ display: '品牌名称', name:'brand_name', width: 150,align:'left' },
				{ display: '备注',name:'remark',width: 300,align:'left'}								 
                 ], switchPageSizeApplyComboBox: false,
				 checkbox:true,
                 /*data: $.extend({}, CustomersData),*/
				 url:'../ajaction/v1/?menuid=101112&cmd=qry&t=1',
                 pageSize: 50,
				 dataAction:'server',
				 allowUnSelectRow:true
				
             };
             return options;
         }

		
		//表单搜索
		 function initSerchForm() {
            //$('#title').ligerComboBox({ width: 97, emptyText: '（空）'});         
 			 $("#brand_no").ligerPopupEdit({
             condition: {
                 prefixID:'brand_name',
                 fields: [{name:'brand_name',type:'text',label:'品牌名称'}
						 ],
				 labelWidth:100
				 
             },
             grid: getGridOptions(true),
				valueField: 'brand_id',
				textField: 'brand_name',
				width: 150,
				searchClick:function(obj){
					/*
						obj 
						grid: grid,
                        rules: rules   {"op":"like","field":"plate_no","value":"苏1","type":"text"}
					*/
					var s="";
					for(var i=0;i<obj.rules.length;i++){
						s=s+obj.rules[i].field+"="+encodeURI(obj.rules[i].value);
					}
					if(s!="") s="&"+s;
					$('.pcontrol input', obj.grid.toolbar).val(1);
					obj.grid.changePage('input');
					obj.grid.set({url:'../ajaction/v1/?menuid=101112&cmd=qry&t=1'+s});
					obj.grid.loadData(true);
					
				},
				dlgWidth:800,
				dlgHeight:300,
				onSelect:function(x){
					
				}
			});
			
			$("#norms_id").ligerPopupEdit({
             condition: {
                 prefixID:'norms_name',
                 fields: [{name:'norms_name',type:'text',label:'规格名称'}
						 ],
				 labelWidth:100
				 
             },
             grid:{
                 columns: [
                 { display: '规格编号', name:'norms_id', align: 'left', width: 60 },
                { display: '规格代码', name:'norms_no', width:150,isSort:false },
				{ display: '规格名称', name:'norms_name', width: 150,align:'left' },
				{ display: '备注',name:'remark',width: 300,align:'left'}								 
                 ], switchPageSizeApplyComboBox: false,
				 checkbox:true,
                 /*data: $.extend({}, CustomersData),*/
				 url:'../ajaction/v1/?menuid=101113&cmd=qry&t=1',
                 pageSize: 50,
				 dataAction:'server'
				
             },
				valueField: 'norms_id',
				textField: 'norms_name',
				width: 150,
				searchClick:function(obj){
					/*
						obj 
						grid: grid,
                        rules: rules   {"op":"like","field":"plate_no","value":"苏1","type":"text"}
					*/
					var s="";
					for(var i=0;i<obj.rules.length;i++){
						s=s+obj.rules[i].field+"="+encodeURI(obj.rules[i].value);
					}
					if(s!="") s="&"+s;
					$('.pcontrol input', obj.grid.toolbar).val(1);
					obj.grid.changePage('input');
					obj.grid.set({url:'../ajaction/v1/?menuid=101113&cmd=qry&t=1'+s});
					//obj.grid.loadData(true);
					
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
	<style type="text/css">
	#style1 input{
	border: 1px solid #1c66dc;
    height: 25px;
    line-height: 2px;
    width: 100px;
    background-color: white;
    border-radius: 20px;
    vertical-align: middle;
    color: #1c66dc;
	}
	
	</style>

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
                    <td style="width:70px">
                        <div style='float: left; text-align: right;margin-top: 10px;'>品牌：</div>
					</td>
					<td style="width:200px">
						<div style='float: left;'>
						<!--<input type='text' id='plate_no' name='plate_no'  ligerui='{width:120}' />-->
						<input id="brand_no"  type="text" readonly="" style="width: 120px;"   />
						</div>
                    </td>
					<td style="width:70px">
                        <div style='float: left; text-align: right;margin-top: 10px;'>规格：</div>
					</td>
					<td style="width:200px">
						<div style='float: left;'>
						<!--<input type='text' id='plate_no' name='plate_no'  ligerui='{width:120}' />-->
						<input id="norms_id"  type="text" readonly="" style="width: 120px;"   />
						</div>
                    </td>
					<td id="style1" style='align:left'>
					
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
