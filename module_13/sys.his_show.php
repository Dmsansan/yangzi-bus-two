<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车辆轮胎历史状态</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
	<script src="../js/XHD.js" type="text/javascript"> </script>

	
	<script type="text/javascript">
	$(function(){
		$('#tirePosition').combobox({
			valueField:'id',
			textField:'name',
		})
		$('#tt').bind('click',function () {
			$('#tireDlg').dialog('open').dialog('setTitle','选择数据');
			//数据
			$.ajax({
				url:'../ajaction/v1/?menuid=121010&cmd=qry&t=1',
				type:'get',
				dataType:'json',
				success:function(data){
					console.log('dd',data.rows);
				$('#sss').datagrid('loadData',data.rows);
				$('#sss').datagrid('reload');	  
				}
			});	 
			});
		//搜索操作	
		$('#dlg_search').on('click',function(){
			var plate_no=$('#dlg_input').textbox('getText');
				$.ajax({
					url:"../ajaction/v1/?menuid=121010&cmd=qry",
					dataType:'json',
					data:{'plate_no':plate_no},
					success:function(data){
						console.log('data',data);
					if(data.rows){
						$('#sss').datagrid('loadData',data.rows);
					}else{
						$.messager.alert('提示','没有该车辆!','info');
					}
				}
				})
		})
		//创建表格
		$('#datatable').datagrid({
			width:'100%',
			toolbar:'#toolbar',
			pagination:'true',
			striped:'true',
			singleSelect:'true',
			fitColumns:'true',
			columns: [[{title: '时间', field: 'Time',width:'15%',rowspan:'2'},
				{title: '车牌号码', field: 'Plate_No',width:'15%',rowspan:'2'},
				/*{title: '速度', field: 'speed',width:'10%',rowspan:'2'},*/
				{title: '累计里程(Km)', field: 'mile_count',width:'10%',rowspan:'2'},
				{title: '左前轮',width:'20%', colspan:2},
				{title: '右前轮',width:'20%',colspan:2},
				{title: '左后内侧',width:'20%',colspan:2},
				{title: '左后外侧',width:'20%',colspan:2},
				{title: '右后内侧',width:'20%',colspan:2},
				{title: '右后外侧',width:'20%',colspan:2},
				],
				[
				{title:'压力',width:'5%',field:'pressure1', formatter:function(value,row,index){
					if(typeof(row.overflow_pressure1)=="undefined"){
								return "<div style='text-align: left'>-</div>";
							}
							var html = row.overflow_pressure1 <=0 ? row.pressure1: "<span style='color:red'>"+row.pressure1+"</span>";  
							return html;
				}},
				{title:'温度',width:'5%',field:'temp1', formatter:function(value,row,index){
					if(typeof(row.overflow_temp1)=="undefined"){
								return "<div style='text-align: left'>-</div>";
							}
							var html = row.overflow_temp1 <=0 ? row.temp1: "<span style='color:red'>"+row.temp1+"</span>";  
							return html;
				}},
				{title:'压力',width:'5%',field:'pressure2',formatter:function(value,row,index){
					if(typeof(row.overflow_pressure2)=="undefined"){
								return "<div style='text-align: left'>-</div>";
							}
							var html = row.overflow_pressure2 <=0 ? row.pressure2: "<span style='color:red'>"+row.pressure2+"</span>";  
							return html;
				}},
				{title:'温度',width:'5%',field:'temp2',formatter:function(value,row,index){
					if(typeof(row.overflow_temp2)=="undefined"){
								return "<div style='text-align: left'>-</div>";
							}
							var html = row.overflow_temp2 <=0 ? row.temp2: "<span style='color:red'>"+row.temp2+"</span>";  
							return html;
				}},
				{title:'压力',width:'5%',field:'pressure3',formatter:function(value,row,index){
					if(typeof(row.overflow_pressure3)=="undefined"){
								return "<div style='text-align: left'>-</div>";
							}
							var html = row.overflow_pressure3<=0 ? row.pressure3: "<span style='color:red'>"+row.pressure3+"</span>";  
							return html;
				}},
				{title:'温度',width:'5%',field:'temp3',formatter:function(value,row,index){
					if(typeof(row.overflow_temp3)=="undefined"){
								return "<div style='text-align: left'>-</div>";
							}
							var html = row.overflow_temp3<=0 ? row.temp3: "<span style='color:red'>"+row.temp3+"</span>";  
							return html;
				}},
				{title:'压力',width:'5%',field:'pressure4',formatter:function(value,row,index){
					if(typeof(row.overflow_pressure4)=="undefined"){
								return "<div style='text-align: left'>-</div>";
							}
							var html = row.overflow_pressure4<=0 ? row.pressure4: "<span style='color:red'>"+row.pressure4+"</span>";  
							return html;
				}},
				{title:'温度',width:'5%',field:'temp4',formatter:function(value,row,index){
					if(typeof(row.overflow_temp4)=="undefined"){
								return "<div style='text-align: left'>-</div>";
							}
							var html = row.overflow_temp4<=0 ? row.temp4: "<span style='color:red'>"+row.temp4+"</span>";  
							return html;
				}},
				{title:'压力',width:'5%',field:'pressure5',formatter:function(value,row,index){
					if(typeof(row.overflow_pressure5)=="undefined"){
								return "<div style='text-align: left'>-</div>";
							}
							var html = row.overflow_pressure5<=0 ? row.pressure5: "<span style='color:red'>"+row.pressure5+"</span>";  
							return html;
				}},
				{title:'温度',width:'5%',field:'temp5',formatter:function(value,row,index){
					if(typeof(row.overflow_temp5)=="undefined"){
								return "<div style='text-align: left'>-</div>";
							}
							var html = row.overflow_temp5<=0 ? row.temp5: "<span style='color:red'>"+row.temp5+"</span>";  
							return html;
				}},
				{title:'压力',width:'5%',field:'pressure6',formatter:function(value,row,index){
					if(typeof(row.overflow_pressure6)=="undefined"){
								return "<div style='text-align: left'>-</div>";
							}
							var html = row.overflow_pressure6<=0 ? row.pressure6: "<span style='color:red'>"+row.pressure6+"</span>";  
							return html;
				}},
				{title:'温度',width:'5%',field:'temp6',formatter:function(value,row,index){
					if(typeof(row.overflow_temp6)=="undefined"){
								return "<div style='text-align: left'>-</div>";
							}
							var html = row.overflow_temp6<=0 ? row.temp6: "<span style='color:red'>"+row.temp6+"</span>";  
							return html;
				}},
               ]],
		})	
		$('#updata_save').bind('click',function(){
				var row = $('#sss').datagrid('getSelected');
				if(row){
				$('#tireNumber').textbox('setValue',row.plate_no);
				var nn=row.bus_id;
				$('#tireDlg').dialog('close');
				searchHistory(nn);
				var plateNumber=row.plate_no;
				$.ajax({
					url:'../ajaction/v1/?menuid=0&cmd=get_all_place&plate_no='+plateNumber,
						type:'POST',
						dataType:'json',
						success:function(data){
							console.log('88888',data);
							//var res =data.items;
							$('#tirePosition').combobox("loadData", data.items);
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
		$('#updata_close').bind('click',function(){
				$('#tireDlg').dialog('close');
		});
		
		//导出数据
		$('#do_export').bind('click',function(){
			//alert(12);
			var row = $('#sss').datagrid('getSelected');
			var plate_no_val = row.bus_id;
			var begin_date = $('#begibdate').val();
			var end_date = $('#stopdate').val();
			var place_no = $('#tirePosition').combobox('getValue');
			window.open('../ajaction/v1/?menuid=131110&cmd=exp&begin_date='+begin_date+"&end_date="+end_date+"&place_no="+place_no+"&plate_no_val="+plate_no_val);
		});
		
				//	ajaction/v1/?menuid=131110&cmd=qry
	})
	function searchHistory(busId){
		var bus_id=busId;
		console.log('busId',bus_id);
		$('#search').on('click',function(){
			var starDate=$('#begibdate').datebox('getText');
			var stopDate=$('#stopdate').datebox('getText');	
			var carplate=bus_id;
			var tireCount=$('#tirePosition').combobox('getValue');	
			console.log('ssssssss',starDate+stopDate+carplate+tireCount);
			$.ajax({
				url:'../ajaction/v1/?menuid=131110&cmd=qry',
				dataType:'json',
				type:'post',
				data:{'begin_date':starDate,'end_date':stopDate,'plate_no_val':carplate,'place_no':tireCount},
				success:function(data){
					console.log('haole',data);
					
					$('#datatable').datagrid('loadData',data.Rows);
				}
			})
		})    
		
	}
	
	
	</script>
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
</head>
<body class="easyui-layout" style="height: 100%; width: 100%">
<table id="datatable"></table>
<div id="toolbar">
    <div style="margin-bottom: 5px">
       
    </div>
    <div style="margin-left: 10px;">
    	 <a href="#" id="do_export" class="easyui-linkbutton" iconCls="icon-save"
           plain="true">导出</a>
        起始日期: <input id="begibdate" class="easyui-datebox" style="width: 100px">
        终止日期: <input id="stopdate" class="easyui-datebox" style="width: 100px">
        车辆号码:  <input id="tireNumber" class="easyui-textbox" style="width: 100px" />
		<a id="tt" class="easyui-linkbutton"  style="text-decoration: none" href="#"  >搜索车牌号码</a> 
		轮胎号位: <input id="tirePosition" style="width: 100px">
       <button id="search" style="display: inline-block; margin-right: 10px;">搜索</button>
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
                <th field="plate_no" width="200"  >车牌号码</th>
                <th field="v_term_no" width="200" >车载编号</th>         
                <th field="remark" width="250" >备注</th> 
            </tr>
            </thead>
            </table>
	<div style="text-align:center"> 
					<button id='updata_save' style="margin-top:10px;"><a style="text-decoration: none;" onclick="selectValue()" href="#"></a></button>
				
					<button id='updata_close' style="margin-top:10px;"><a style="text-decoration: none" href="#"></a></button>
	</div>
        <div id="dlg_tb" style="">
            <input id="dlg_input" type="text" class="easyui-textbox" placeholder="角色名称"/> <button id="dlg_search">搜索</button>
        </div>
        <div>

        </div>

        </div>

    </div>
</div>
</body>
</html>