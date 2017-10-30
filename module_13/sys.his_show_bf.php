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
		$('#datatable').datagrid({
			width:'100%',
			toolbar:'#toolbar',
			pagination:'true',
			striped:'true',
			columns: [[{title: '时间', field: 'Time',width:'10%',rowspan:'2'},
				{title: '车牌号码', field: 'Plate_No',width:'10%',rowspan:'2'},
				{title: '速度', field: 'speed',width:'10%',rowspan:'2'},
				{title: '累计里程(Km)', field: 'mile_count',width:'10%',rowspan:'2'},
				{title: '左前轮',width:'20%', colspan:2},
				{title: '右前轮',width:'20%',colspan:2},
				{title: '左后内侧',width:'20%',colspan:2},
				{title: '左后外侧',width:'20%',colspan:2},
				{title: '右后内侧',width:'20%',colspan:2},
				{title: '右后外侧',width:'20%',colspan:2},
				],
				[
				{title:'压力',width:'5%',field:'pressure1'},
				{title:'温度',width:'5%',field:'temp1'},
				{title:'压力',width:'5%',field:'pressure2'},
				{title:'温度',width:'5%',field:'temp2'},
				{title:'压力',width:'5%',field:'pressure3'},
				{title:'温度',width:'5%',field:'temp3'},
				{title:'压力',width:'5%',field:'pressure4'},
				{title:'温度',width:'5%',field:'temp4'},
				{title:'压力',width:'5%',field:'pressure5'},
				{title:'温度',width:'5%',field:'temp5'},
				{title:'压力',width:'5%',field:'pressure6'},
				{title:'温度',width:'5%',field:'temp6'},
               ]],
		})
		$('#updata_save').bind('click',function(){
				var row = $('#sss').datagrid('getSelected');
				if(row){
				$('#carplate').textbox('setValue',row.plate_no);
				$('#tireDlg').dialog('close');
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
		
					
	})
	
	
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
        <a href="#" class="easyui-linkbutton" iconCls="icon-save"
           plain="true">导出</a>
    </div>
    <div style="margin-left: 10px;">
        起始日期: <input class="easyui-datebox" style="width: 100px">
        终止日期: <input class="easyui-datebox" style="width: 100px">
        车辆号码:  <input id="carplate" class="easyui-textbox" style="width: 100px" />
		<a id="tt" class="easyui-linkbutton"  style="text-decoration: none" href="#"  >搜索车牌号码</a> 
		轮胎号位: <input id="tirePosition" style="width: 100px">
       <button  style="display: inline-block; margin-right: 10px;"><a style="text-decoration: none;" onclick="seach()" href="#">搜索</a></button>
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
            <input type="text" class="easyui-textbox" placeholder="角色名称"/> <button>搜索</button>
        </div>
        <div>

        </div>

        </div>

    </div>
</div>
</body>
</html>