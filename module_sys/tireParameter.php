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

            });
			$.ajax({
                url: '../ajaction/v1/?menuid=111010&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                 
                    
                    console.log('data', data);
                }
            });
        })


        function formatOption(value, row, index) {
           return '<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px; margin-left:20px;" onclick="editUser('+index+')">编辑</a> <a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:6px;" onclick="deletData('+index+')">删除</a>';
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
<body class="easyui-layout" style="width: 100%;height: 100%;background-color: #f1f6fd">
<div  class="u-content">
    <table id="dg" class="easyui-datagrid"
           data-options="singleSelect:true,url:'../../datagrid_data1.json',method:'get',toolbar:'#tb',striped:'true',pagination:'true'">
        <thead>
        <tr>
            <th data-options="field:'itemid',width:200">轮胎编号</th>
            <th data-options="field:'productid',width:205">品牌名称</th>

            <th data-options="field:'listprice',width:245">规格名称</th>
            <th data-options="field:'unitcost',width:250">层级名称</th>
            <th data-options="field:'itemid',width:200">花纹名称</th>
            <th data-options="field:'productid',width:205">备注</th>
            <th data-options="field:'_operate',width:420,formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
        <input type="text" placeholder="轮胎编号"/> <button>搜索</button> <button>重置</button><button style="float: right" onclick="addUser()">增加</button>
    </div>
    <div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true" style="width:600px;height: 300px;">
        <span id="message">基本信息</span><hr/>
        <table id="cc" style="width: 100%;height: 80%;padding-left: 10px;padding-right: 10px">
            <tr>
                <td>
                    角色名称：
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
                    角色名称：
                    <input class="easyui-textbox" style="display: inline-block;width:45%" type="text"/>
                </td>
                <td>
                    角色权限：
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
                    角色说明：
                    <input class="easyui-textbox" style="display: inline-block;width:45%" type="text"/>
                </td>

            </tr>
        </table>
    </div>
</div>
</body>
</html>