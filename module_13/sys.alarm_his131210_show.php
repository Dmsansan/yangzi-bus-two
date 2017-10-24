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
	</style>
	<script type="text/javascript">
		$(function(){
			$('#tireCount').combobox({
				url:'../css/homepagecss/tireweizhi.json',
				valueField:'id',
				textField:'text'
			});
			$.ajax({
				url:'../ajaction/v1/?menuid=131210&cmd=qry',
				success:function(data){
					console.log('hh',data);
				}
			})
		})
	
	</script>
</head>
<body class="easyui-layout" style="height: 100%; width: 100%">
<table id="datatable" class="easyui-datagrid" pagination="true"
       striped="true"
       style="width: 100%; height: 100%;margin-top:20px;" toolbar="#toolbar" singleSelect="true"
       fitColumns="true">
    <thead>
    <tr>
        <th field="name1" width="15%">时间</th>
        <th field="name3" width="10%">车牌号码</th>
        <th field="name4" width="10%">轮胎号位</th>
        <th field="name3" width="10%">车载控制器编号</th>
        <th field="name4" width="10%">轮胎胎号</th>
        <th field="name3" width="10%">轮胎压力（Kg）</th>
        <th field="name4" width="10%">压力阀值（Kg）</th>
    </tr>

    </thead>
</table>
<div id="toolbar" style="height:50px; background-color: white;padding-left: 19px;padding-right:39px;padding-top:10px">
    <div style="margin-left: 10px;">
        起始日期: <input class="easyui-datebox" style="width: 100px">
        终止日期: <input class="easyui-datebox" style="width: 100px">
        车辆号码: <input id="carplate" style="width: 100px" />
		轮胎号位: <input id="tireCount"  style="width: 100px"/>
				<button style="display: inline-block; margin-right: 10px;"><a style="text-decoration: none;" href="#" onclick="addUser()">搜索</a></button>
				<button style="float:right;"><a href="#" style="text-decoration: none;" iconCls="icon-save"
           plain="true">导出</a></button>
    </div>
</div>
</body>
</html>