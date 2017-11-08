<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>告警历史状态</title>
	 <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src=" ../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
	<style type="text/css">
		#toolbar button{
			border: 1px solid #1c66dc;
			height: 25px;
			line-height: 2px;
			width: 100px;
			background-color: white;
			border-radius: 20px;
			vertical-align: middle;
			color: #1c66dc;
		}
		#toolbar button:active,#toolbar button:hover{
			color:#ffffff;
			background-color:#1c66dc;
		}
		#dlg_tb button{
			border: 1px solid #1c66dc;
			height: 25px;
			line-height: 2px;
			width: 100px;
			background-color: white;
			border-radius: 20px;
			vertical-align: middle;
			color: #1c66dc;
		}
		#dlg_tb button:active,#dlg_tb button:hover{
			color:#ffffff;
			background-color:#1c66dc;
		}
			#updata_save{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #updata_save:visited,#updata_save:link{
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #updata_save button:active,#updata_save button:hover{
            background: url("../css/img/ok_seleected.png") no-repeat;

        }
        #updata_close{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #updata_close:visited,#updata_close:link{
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #updata_close button:active,#updata_close button:hover{
            background: url("../css/img/cancel_selected.png") no-repeat;

        }
	</style>
	<script type="text/javascript">
		$(function(){
			//搜索操作	
		$('#dlg_search').on('click',function(){
			var plate_no=$('#dlg_input').textbox('getText');
				$.ajax({
					url:"../ajaction/v1/?menuid=121010&cmd=qry",
					dataType:'json',
					data:{'plate_no':plate_no},
					success:function(data){
						console.log('data',data);
				if(data.Rows){
					
					$('#sss').datagrid('loadData',data.Rows);
				}else{
					$.messager.alert('提示','没有该车辆!','info');
				}
				}
				})
		})
			$('#tireCount').combobox({
				url:'../css/homepagecss/tireweizhi.json',
				valueField:'id',
				textField:'text'
			});
			
			$('#tt').bind('click',function () {
			$('#tireDlg').dialog('open').dialog('setTitle','选择数据');
			$.ajax({
				url:'../ajaction/v1/?menuid=121010&cmd=qry&t=1',
				type:'get',
				dataType:'json',
				success:function(data){
					console.log('dd',data.Rows);
				$('#sss').datagrid('loadData',data.Rows);				
				$('#sss').datagrid('reload');				  
				}
			});
			 
			});
			$('#updata_save').bind('click',function(){
				var row = $('#sss').datagrid('getSelected');
				if(row){
				$('#carplate').textbox('setValue',row.plate_no);
				var plateNumber=row.plate_no;
				var busid=row.bus_id;
				search(busid);
				$('#tireDlg').dialog('close');
				$.ajax({
					url:'../ajaction/v1/?menuid=0&cmd=get_all_place&plate_no='+plateNumber,
						type:'POST',
						dataType:'json',
						success:function(data){
							console.log('88888',data);
							//var res =data.items;
							$('#tireCount').combobox("loadData", data.items);
						}
					});
				}else{
					$.messager.show({
						title:'提示',
						msg:'没有选中数据',
						timeout:3000,
						showType:'slide'
					});
				}
			});
			$('#tireCount').combobox({
					valueField:'id',
					textField:'name'
				})
				
			$('#updata_close').bind('click',function(){
				$('#tireDlg').dialog('close');
			});
			
			
		})
		function search(busid){
			$('#search').on('click',function(){
			var starDate=$('#start').datebox('getText');
			var stopDate=$('#stop').datebox('getText');	
			var carplate=busid;
			var tireCount=$('#tireCount').combobox('getValue');
			$.ajax({
				url:'../ajaction/v1/?menuid=131210&cmd=qry',
				type:'post',
				dataType:'json',
				data:{'begin_date':starDate,'end_date':stopDate,'plate_no_val':carplate,'place_no':tireCount},
				success:function(data){
				console.log('hhh',data);
				$('#datatable').datagrid('loadData',data.Rows);
				}
			});
			});
		}
		
	</script>
</head>
<body class="easyui-layout" style="height: 100%; width: 100%">
<table id="datatable" class="easyui-datagrid" pagination="true"
       striped="true"
       style="width: 100%; height: 100%;margin-top:20px;" toolbar="#toolbar" singleSelect="true"
       fitColumns="true">
    <thead>
    <tr>
        <th data-options="field:'Time',width:'15%'" >时间</th>
        <th data-options="field:'Plate_No',width:'10%'" >车牌号码</th>
        <th data-options="field:'place_no',width:'10%'" >轮胎号位</th>
        <th data-options="field:'sensor_no',width:'10%'">车载控制器编号</th>
        <th data-options="field:'tire_no',width:'10%'">轮胎胎号</th>
        <th data-options="field:'pressure_val',width:'10%'">轮胎压力（Kg）</th>
        <th data-options="field:'pressure',width:'10%'">压力阀值（Kg）</th>
        <th data-options="field:'temp_val',width:'10%'">温度值（℃）</th>
        <th data-options="field:'temp_ul',width:'10%'">温度上限（℃）</th>
    </tr>

    </thead>
</table>
<div id="toolbar" style="height:50px; background-color: white;padding-left: 19px;padding-right:39px;padding-top:24px">
    <div style="margin-left: 10px;">
        起始日期: <input id="start" class="easyui-datebox" style="width: 100px">
        终止日期: <input id="stop" class="easyui-datebox" style="width: 100px">
        车辆号码: <input id="carplate" class="easyui-textbox" style="width: 100px" />
		 <a id="tt" class="easyui-linkbutton"  style="text-decoration: none" href="#"  >搜索车牌号码</a> 
		轮胎号位: <input id="tireCount" class="easyui-combobox" style="width: 100px"/>
				<button id="search"  style="display: inline-block; margin-right: 10px;">搜索</button>
				<button style="float:right;"><a href="#" style="text-decoration: none;" iconCls="icon-save"
           plain="true">导出</a></button>
    </div>
</div>
<div id="tireDlg" class="easyui-dialog" data-options="closed:true" style="width:800px;height:480px;">
    <div id="cc" class="easyui-panel" style="background-color: #bdc4d4;padding: 10px;height: 440px;">
        <div style="background-color: #ffffff;height: 420px;">
            <table id="sss"  class="easyui-datagrid" pagination="true" style="background-color: #ffffff;height: 370px;"
                    striped="true" 
                    toolbar="#dlg_tb" singleSelect="true"
                    fitColumns="true">
            <thead>
            <tr>
                <th field="plate_no" width="350"  >车牌号码</th>
                <th field="v_term_no" width="350" >车载编号</th>
                
            </tr>
            </thead>
            </table>
	<div style="text-align:center"> 
					<button id='updata_save' style="margin-top:10px;"><a style="text-decoration: none;" onclick="selectValue()" href="#"></a></button>
				
					<button id='updata_close' style="margin-top:10px;"><a style="text-decoration: none" href="#"></a></button>
	</div>
        <div id="dlg_tb" style="">
            <input id="dlg_input" type="text" class="easyui-textbox" placeholder="车牌号码"/> <button id="dlg_search">搜索</button>
        </div>
        <div>

        </div>

        </div>

    </div>
</div>
</body>
</html>