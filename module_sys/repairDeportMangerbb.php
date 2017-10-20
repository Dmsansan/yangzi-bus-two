<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修理厂管理</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
    <script type="text/javascript">
        function addUser() {
            $('#addUser').window('open').window('setTitle','新增角色');
        };
        $(function () {
            $("#rolePower").combobox({
                url:'../../css/homepagecss/chedui.json',
                valueField:'id',
                textField:'text',
                editable:false
            });
            $('#operate').combobox({
                url:'../../css/homepagecss/chedui.json',
                panelHeight:200,
                valueField:'id',
                textField:'text',
                multiple:true,
                formatter:function (row) {
                    var opts = $(this).combobox('options');
                    return '<input type="checkbox" class="combobox-checkbox">' + row[opts.textField];
                    console.log("row",ops.textField);
                }

            })
        })


        function formatOption(value, row, index) {
            return '<a href="#" onclick="editUser('+index+')">修改</a> <a href="#" onclick="deletData('+index+')">删除</a>';
        }
        var url;
        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            console.log("index",index);
            var row = $('#dg').datagrid('getSelected');

            if (row){
                $('#dlg').dialog('open').dialog('setTitle','新增角色');
                $('#fm').form('load',row);
                url = '';
            }
        };
    </script>
</head>
<body class="easyui-layout" style="width: 100%;height: 100%;background-color: #ffffff">
<div  class="u-content">
    <table id="dg" class="easyui-datagrid"
           data-options="singleSelect:true,url:'../../datagrid_data1.json',method:'get',toolbar:'#tb',striped:'true',pagination:'true'">
        <thead>
        <tr>
            <th data-options="field:'itemid',width:200">修理厂编号</th>
            <th data-options="field:'productid',width:220">修理厂名称</th>
            <th data-options="field:'listprice',width:200">联系人</th>
            <th data-options="field:'unitcost',width:200">联系电话</th>
            <th data-options="field:'listprice',width:200">手机号码</th>
            <th data-options="field:'unitcost',width:350">详细地址</th>
            <th data-options="field:'unitcost',width:350">说明</th>
            <th data-options="field:'_operate',width:300,formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px">
        <input type="text" placeholder="角色名称"/> <button>搜索</button> <button>重置</button>
        <button style="float: right;"><a style="text-decoration: none;" href="#" onclick="addUser()">增加</a></button>
    </div>
    <div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true" style="width:600px;height: 300px;">
        <span id="message">基本信息</span><hr/>
        <table id="cc" style="width: 100%;height: 80%;padding-left: 10px;padding-right: 10px">
            <tr>
                <td>
                    名称：
                    <input class="easyui-textbox" style="display: inline-block;width:45%" type="text"/>
                </td>
                <td>
                    角色权限：
                    <select id="roles" class="easyui-combobox" style="width:45%">
                        <option>ssss</option>
                        <option>?</option>
                    </select>

                </td>
            </tr>
            <tr>
                <td>
                    操作权限：
                    <select id="operate" style="width: 45%;">

                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    角色说明：
                    <input class="easyui-textbox" style="display: inline-block;width:45%" type="text"/>
                </td>

            </tr>
        </table>
    </div>
    <div id="addUser" class="easyui-window" data-options="closed:true,modal:true" style="width:600px;height: 300px;">
        <span id="addMessage">基本信息</span><hr/>
        <table id="aa" style="width: 100%;height: 80%;padding-right: 10px;padding-left: 10px;">
            <tr>
                <td>
                    用户名称：
                    <input class="easyui-textbox" style="display: inline-block;width:45%" type="text"/>
                </td>
                <td>
                    用户权限：
                    <input id="rolePower" style="width: 150px;" />
                </td>
            </tr>
            <tr>
                <td>
                    操作权限：
                    <input>
                </td>
            </tr>
            <tr>
                <td>
                    用户说明：
                    <input class="easyui-textbox" style="display: inline-block;width:45%" type="text"/>
                </td>

            </tr>
        </table>
    </div>
</div>
</body>
</html>