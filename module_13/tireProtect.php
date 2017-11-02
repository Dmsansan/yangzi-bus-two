<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>轮胎保养记录报表</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
    <script type="text/javascript">
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
    <table id="dg" class="easyui-datagrid"
           data-options="singleSelect:true,url:'../../datagrid_data1.json',method:'get',toolbar:'#tb',striped:'true',pagination:'true'">
        <thead>
		<tr>
			<th field="name1" width="15%" rowspan="2">安装时间</th>
			<th field="name3" width="10%" rowspan="2">车牌号</th>
			<th field="name4" width="10%" rowspan="2">轮胎号位</th>
			<th colspan=2 width="10%">一保</th>
			<th colspan=2 width="10%">二保</th>
			<th colspan=2 width="10%">三保</th>
		</tr>
		<tr>
			<th field="name5" width="5%">里程</th>
			<th field="name6" width="5%">花纹深度</th>
			<th field="name7" width="5%">里程</th>
			<th field="name8" width="5%">花纹深度</th>
			<th field="name9" width="5%">里程</th>
			<th field="name10" width="5%">花纹深度</th>
		</tr>
        </thead>
    </table>
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px">
        <input type="text" placeholder="轮胎胎号"/> <button>搜索</button> <button>重置</button>
		    <button style="float: right"><span style="margin-right:8px;">+</span>打印</button>
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