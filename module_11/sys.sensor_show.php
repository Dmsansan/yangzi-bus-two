<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>传感器管理</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
    <script type="text/javascript">
		function addSensor() {
			
          $('#addSensor').dialog('open').dialog('setTitle','增加传感器信息');
        };
		function addallsensor() {
			
          $('#addSensor').dialog('open').dialog('setTitle','增加传感器信息');
        };
        function formatOption(value, row, index) {
            return '<a href="#" onclick="editUser(\'+index+\')">编辑</a> <a href="#" onclick="editUser(\'+index+\')">删除</a>';
        }
        var url;
        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','新增角色');
                $('#fm').form('load',row);
                url = '';
            }
        }
    </script>
	 <style type="text/css">
          #sure{
            height: 25px;
            width: 60px;
            border: none;
            margin-right: 11px;
            background: url("../css/img/yes_normal.png") no-repeat;
        }
        #sure:visited,#sure:link{
            background: url("../css/img/yes_normal.png") no-repeat;
        } 
        #sure:hover,#sure:active{
            background: url("../css/img/yes_highlighted.png") no-repeat;
        }
        #cancel{
            height: 25px;
            width: 60px;
            border: none;
            background: url("../css/img/no_normal.png") no-repeat;
        }
        #cancel:visited,#cancel:link{
            background: url("../css/img/no_normal.png") no-repeat;
        }
        #cancel:hover,#cancel:active{
            background: url("../css/img/no_highlighted.png") no-repeat;
        }
		 #save{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #save:visited,#save:link{
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #save button:active,#save button:hover{
            background: url("../css/img/ok_seleected.png") no-repeat;

        }
        #close{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #close:visited,#close:link{
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #close button:active,#close button:hover{
            background: url("../css/img/cancel_selected.png") no-repeat;

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
<body class="easyui-layout" style="width: 100%;height: 100%;background-color: #ffffff">
<div  class="u-content">
    <table id="dg" class="easyui-datagrid"
           data-options="singleSelect:true,method:'get',toolbar:'#tb',striped:'true',pagination:'true'">
        <thead>
        <tr>
            <th data-options="field:'itemid',width:'10%'">传感器编号</th>
            <th data-options="field:'productid',width:'10%'">传感器代码</th>
            <th data-options="field:'listprice',width:'10%'">胎压上限</th>
            <th data-options="field:'unitcost',width:'10%'">胎压下限</th>
            <th data-options="field:'listprice',width:'10%'">胎温上限</th>
            <th data-options="field:'unitcost',width:'10%'">温度下限</th>
            <th data-options="field:'listprice',width:'20%'">备注</th>
            <th data-options="field:'_operate',width:'10%',formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px">
        <input type="text" placeholder="角色名称"/> <button>搜索</button>
        <button style="float: right;"><a style="text-decoration: none;" href="#" onclick="addallsensor()">批量增加</a></button> <button style="float: right;"><a style="text-decoration: none;" href="#" onclick="addSensor()">增加</a></button>
    </div>
    <div id="dlg" class="easyui-dialog" data-options="closed:true" style="width:600px;height: 300px;">
        <span>基本信息</span><hr/>
        <table style="width: 100%;height: 80%;">
            <tr>
                <td>
                   传感器编号：
				     </td>
                <td>
                    <input id="updata_sensorNumber" style="width:150px;"/>
                </td>
                <td>
                    压力测量范围：
					  </td>
                <td>
                    <input id="updata_pressure" style="width:150px;"/>
                </td>
            </tr>
            <tr>
                <td>
                    温度测量范围：
					  </td>
                <td>
					<input id="updata_tem" style="width:150px;"/>
                </td>
            </tr>
            <tr>
                <td>
                    备注：
					  </td>
                <td colspan="3">
                    <input type="text" />
                </td>
            </tr>
			<tr style="text-align: center">
				<td>
				</td>

				<td>
					<button id='updata_save' style="margin-top:10px;"><a style="text-decoration: none;" href="#"></a></button>
				</td>
				<td>
					<button id='updata_close' style="margin-top:10px;"><a style="text-decoration: none" href="#"></a></button>
				</td>
				<td>
				</td>
			</tr>
			
        </table>
    </div>
	<div id="addSensor" class="easyui-dialog" data-options="closed:true,modal:true,iconCls:'icon-add2'" style="width:700px;height: 400px;background-color: #bdc4d4">
		<div style="background-color: #ffffff;height:340px;margin:10px;">
			<span id="addMessage">基本信息</span><hr/>
			<table style="width: 100%;height: 80%;">
            <tr>
                <td>
                   传感器编号：
				     </td>
                <td>
                    <input id="updata_sensorNumber" style="width:150px;"/>
                </td>
                <td>
                    压力测量范围：
					  </td>
                <td>
                    <input id="updata_pressure" style="width:150px;"/>
                </td>
            </tr>
            <tr>
                <td>
                    温度测量范围：
					  </td>
                <td>
					<input id="updata_tem" style="width:150px;"/>
                </td>
            </tr>
            <tr>
                <td>
                    备注：
					  </td>
                <td colspan="3">
                    <input type="text" />
                </td>
            </tr>
			<tr style="text-align: center">
						<td>
						</td>
						<td>
							<button id='save' style="margin-top:10px;"><a style="text-decoration: none;" href="#"></a></button>
						</td>
						<td>
							<button id='close' style="margin-top:10px;"><a style="text-decoration: none" href="#"></a></button>
						</td>
						<td>
						</td>
				</tr>
        </table>
	</div>
</div>
</body>
</html>