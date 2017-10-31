<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>轮胎里程报表</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(function(){
        $.ajax({
            url:'../ajaction/v1/?menuid=131311&cmd=qry',
            type:'POST',
            dataType:'json',
            success:function(data){
                console.log('success',data);
                $('#dg').datagrid('loadData',data.Rows);
            }
        })
    })
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
</head>
<body class="easyui-layout" style="width: 100%;height: 100%;background-color: #ffffff">
<div  class="u-content">
    <table id="dg" class="easyui-datagrid" style="width: 100%"
           data-options="singleSelect:true,url:'../ajaction/v1/?menuid=131311&cmd=qry',method:'get',toolbar:'#tb',striped:'true',pagination:'true'">
        <thead>
        <tr>
            <th data-options="field:'time_add',width:300">安装时间</th>
            <th data-options="field:'time_remove',width:300">卸载时间</th>
            <th data-options="field:'plate_no',width:230">车辆号码</th>
            <th data-options="field:'place_no',width:200">轮胎号位</th>
            <th data-options="field:'tire_no',width:200">轮胎胎号</th>
            <th data-options="field:'run_time',width:200">累计运行时长</th>
            <th data-options="field:'run_mile',width:200">累计运行里程</th>
        </tr>
        </thead>
    </table>
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px">
        <input type="text" placeholder="车牌号码"/> <button>搜索</button>
        <button style="float: right">+打印</button>
    </div>
    <div id="dlg" class="easyui-dialog" data-options="closed:true" style="width:600px;height: 300px;">
        <span>基本信息</span><hr/>
        <table style="width: 100%;height: 80%;">
            <tr>
                <td>
                    角色名称：
                    <input type="text"/>
                </td>
                <td>
                    角色权限：
                    <select>

                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    操作权限：
                    <select>

                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    角色说明：
                    <input type="text" />
                </td>

            </tr>
        </table>
    </div>
</div>
</body>
</html>