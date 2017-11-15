<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>轮胎库存查询</title>
	<link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
	<script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
		$('#datatable').datagrid({
			fitColumns:true,
			striped:true,
			pagination:true,
			singleSelect:true,
			loading:'正在加载.....',
			toolbar:'#toolbar',
			columns:[[
			{field:'code',title:'轮胎品牌',width:100},
			{field:'name',title:'轮胎规格',width:100},
			{field:'price',title:'进库数量',width:100,align:'right'},
			{field:'price',title:'出库数量',width:100,align:'right'},
			{field:'price',title:'库存数量',width:100,align:'right'}
			]]
		})	
	})
</script>
<style type="text/css">
 .searchbutton{
	background-color:#ffffff;
	border-radius:10px;
	border:1px solid #1c66dc;
	color:#1c66dc;
	padding:3px 30px;
	outline:none;
 }
 .searchbutton:active,.searchbutton:hover{
	 background-color:#1c66dc;
	 color:#ffffff;
 }

</style>
</head>
<body class="easyui-layout" style="margin:0;padding:0; background-color:#f1f6fd;overflow: hidden">
 	<div id="toolbar" style="padding:20px;">
	<input class="easyui-textbox" prompt="轮胎品牌"/> <button class="searchbutton" style="vertical-align:middle">搜索 </button>

	</div>
 	<table id="dg" class="easyui-datagrid" style="width: 100%" url="../ajaction/v1/?menuid=131311&cmd=qry"
          rownumbers="false" pagination="true" striped="true">
        <thead>
        <tr>
            <th data-options="field:'time_add',width:300">安装时间</th>
            <th data-options="field:'time_remove',width:300">卸载时间</th>
            <th data-options="field:'plate_no',width:230">车辆号码</th>
            <th data-options="field:'place_no',width:200">轮胎号位</th>
            <th data-options="field:'tire_no',width:200">轮胎胎号</th>
            <th data-options="field:'run_time',width:200">累计运行时长(小时/h)</th>
            <th data-options="field:'run_mile',width:200">累计运行里程(千米/Km)</th>
        </tr>
        </thead>
    </table>

</body>
</html>
