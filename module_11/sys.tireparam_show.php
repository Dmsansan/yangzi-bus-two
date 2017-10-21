<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>轮胎参数管理</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
    <script type="text/javascript">
	 function addUser() {
            $('#addUser').dialog('open').dialog('setTitle','增加信息');
        };
        function formatOption(value, row, index) {
            return '<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px; margin-left:20px;" onclick="editUser('+index+')">编辑</a> <a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:20px;" onclick="deletData('+index+')">删除</a>';
        }
        var url;
        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','新增角色');
                $('#fm').form('load',row);
         
            }
        }
    </script>
</head>
<body class="easyui-layout" style="width: 100%;height: 100%;background-color: #ffffff">

    <table id="dg" class="easyui-datagrid"
           data-options="singleSelect:true,toolbar:'#tb',striped:'true',pagination:'true'">
        <thead>
        <tr>
            <th data-options="field:'itemid',width:'10%'">编号</th>
            <th data-options="field:'productid',width:105">制造商</th>
            <th data-options="field:'listprice',width:140">品牌</th>
            <th data-options="field:'unitcost',width:140">轮胎规格</th>
            <th data-options="field:'listprice',width:140">层级</th>
            <th data-options="field:'unitcost',width:140">花纹</th>
            <th data-options="field:'listprice',width:140">胎压上限</th>
            <th data-options="field:'unitcost',width:140">胎压下限</th>
            <th data-options="field:'listprice',width:140">胎温上限</th>
            <th data-options="field:'unitcost',width:140">速度上限</th>
            <th data-options="field:'listprice',width:100">TKPH值</th>
            <th data-options="field:'_operate',width:260,formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
    <input type="text" placeholder="角色名称"/> <button>搜索</button>
    <button style="float: right; margin-top: 15px;"><a style="text-decoration: none;" href="#" onclick="addUser()">增加</a></button>
</div>
    <!--修改信息弹出框 -->  
	<div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#updata_dlg'" style="width:650px;height: 300px;background-color: #bdc4d4">
        <div style="background-color: #ffffff;height:240px;margin:10px;">
		<span id="message">基本信息</span><hr/>
        <table id="cc" style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
            <tr>
                <td>
                    角色名称：
					 <input id="role_id"  style="display: none;width:45%；" type="text"/>
					  <input id="module_id"  style="display: none;width:45%；" type="text"/>
                    <input id="title" class="easyui-textbox"  style="display: inline-block;width:200px;" type="text"/>
                </td>
                <td>
                    角色权限：
                    <input id="roles"  style="width:200px;" />

                </td>
            </tr>
            <tr>
                <td>
                    操作权限：
                    <select id="operate" style="width:200px;">

                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    角色说明：
                    <input id="remark" class="easyui-textbox" style="display: inline-block;width:45%" type="text"/>
                </td>

            </tr>
			<tr style="text-align: center">

				<td>
					<button id='updata_save'><a style="text-decoration: none;" href="#"></a></button>
				</td>
				<td>
					<button id='updata_close'><a style="text-decoration: none" href="#"></a></button>
				</td>
        </tr>
        </table>
		</div>
    </div>
   <div id="addUser" class="easyui-dialog" data-options="closed:true,modal:true,iconCls:'icon-add2'" style="width:855px;height: 300px;background-color: #bdc4d4">
    <div style="background-color: #ffffff;height:240px;margin:10px;">
    <span id="addMessage">基本信息</span>
    <table id="aa" style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
        <tr>
            <td style="width:252px;">
                制造商：
                <input id="addrole" class="easyui-textbox" style="width:200px;" type="text"/>
            </td>
            <td>  
                品牌：
                <input id="rolePower" style="width: 150px;" />
            </td>
			<td>
                操作权限：
                <input id="rolePower" style="width: 100px;" />
            </td>
        </tr>
        <tr>
            <td>
                层级：
                <input id="addoper" style="width: 200px;" />
            </td>
			<td>  
                花纹：
                <input id="rolePower" style="width: 150px;" />
            </td>
			<td>
                压力范围：
                <input id="rolePower" style="width: 30px;" />至<input id="rolePower" style="width:30px;" />
            </td>
        </tr>
        <tr>
            <td>
                温度上限：
                <input id="addremark" class="easyui-textbox" style="width:150px;"/>
            </td>
			<td>
                速度上限(km/h)：
                <input id="addremark" class="easyui-textbox" style="width:150px;"/>
            </td>
			<td>
               TPKH值：
                <input id="addremark" class="easyui-textbox" style="width:150px;"/>
            </td>

        </tr>

        <tr style="text-align: center">

           <td>
               <button id='save'><a style="text-decoration: none;" href="#"></a></button>
           </td>
            <td>
                <button id='close'><a style="text-decoration: none" href="#"></a></button>
            </td>
        </tr>
    </table>
    </div>
</div>
	
<div id="alarmDialog">
</div>

</body>
</html>