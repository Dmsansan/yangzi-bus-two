<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车辆轮胎历史状态</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
	 <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(function(){
		$.ajax({
			url:'../ajaction/v1/?menuid=131110&cmd=qry',
			success:function(data){
				console.log('aa',data);
			}
		});
		
		$('#ct').bind('click',function () {
			$('#tireDlg').dialog('open').dialog('setTitle','选择数据');
			
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
<body class="easyui-layout" style="height: 100%; width: 100%;">
<table id="datatable" class="easyui-datagrid" pagination="true"
      striped="true", style="width: 100%; height:100%;"
       toolbar="#toolbar" singleSelect="true" fitColumns="true">
    <thead>
    <tr>
        <th field="name1" width="15%" rowspan="2">时间</th>
        <th field="name3" width="10%" rowspan="2">车牌号码</th>
        <th field="name4" width="10%" rowspan="2">累计里程</th>
        <th colspan=2 width="10%">左前轮</th>
        <th colspan=2 width="10%">右前轮</th>
        <th colspan=2 width="10%">左后外侧</th>
        <th colspan=2 width="10%">左后内侧</th>
        <th colspan=2 width="10%">右后内侧</th>
        <th colspan=2 width="10%">右后外侧</th>
    </tr>
    <tr>
        <th field="name5" width="5%">温度</th>
        <th field="name6" width="5%">压力</th>
        <th field="name7" width="5%">温度</th>
        <th field="name8" width="5%">压力</th>
        <th field="name9" width="5%">温度</th>
        <th field="name10" width="5%">压力</th>
        <th field="name11" width="5%">温度</th>
        <th field="name12" width="5%">压力</th>
        <th field="name13" width="5%">温度</th>
        <th field="name14" width="5%">压力</th>
        <th field="name15" width="5%">温度</th>
        <th field="name16" width="5%">压力</th>
    </tr>
    </thead>
</table>
<div id="toolbar" style="height:50px; background-color: white;padding-left: 19px;padding-right:39px;padding-top:10px">
        起始日期: <input class="easyui-datebox" style="width: 100px">
        终止日期: <input class="easyui-datebox" style="width: 100px">
        车辆号码: <input id="carplate" class="easyui-textbox" style="width: 100px"/>
		 <a id="ct" class="easyui-linkbutton"  style="text-decoration: none" href="#"  >搜索轮胎胎号</a> 
		轮胎号位: <input class="easyui-combobox" style="width: 100px" valueField="id" textField="text">
		<button id="search">搜索</button>
   
</div>
<div id="tireDlg" class="easyui-dialog" data-options="closed:true" style="width:800px;height:400px;">
    <div id="cc" class="easyui-panel" style="background-color: #bdc4d4;padding: 10px;height: 360px;">
        <div style="background-color: #ffffff;height: 340px;">
            <table id="sss"  class="easyui-datagrid" pagination="true" style="background-color: #ffffff;height: 290px;"
                    striped="true" url="../../data/datagrid_data.json"
                    toolbar="#dlg_tb" singleSelect="true"
                    fitColumns="true">
            <thead>
            <tr>
                <th field="name71" width="350"  >车牌号码</th>
                <th field="name81" width="350" >车载编号</th>
                
            </tr>
            </thead>
            </table>
	<div style="text-align:center">
					<button id='updata_save' style="margin-top:10px;"><a style="text-decoration: none;" href="#"></a></button>
				
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