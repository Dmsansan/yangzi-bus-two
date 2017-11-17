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
    	$.ajax({
				 url:'../ajaction/v1/?menuid=101112&cmd=qry',
				dataType:'json',
				success:function(data){
					var msg=data.rows;
					$("#brand_no").combobox('loadData',msg);
					$("#norms_no").combobox('loadData',msg);
				}
			});
		$('#brand_no').combobox({
	        valueField:'brand_id',
	        textField:'brand_name'
    	});
    	$('#norms_no').combobox({
	        valueField:'brand_id',
	        textField:'norms_name'
    	});
    	 //搜索
        $('#search').bind('click',function(){
            //alert($('#plate_no').val());
            $("#dg").datagrid('load',{
                brand_id: $('#brand_no').combobox('getValue'),
                norms_id: $('#norms_no').combobox('getValue'),
                date: $('#time').val()
            }); 
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
<body class="easyui-layout" style="margin:0;padding:0; background-color:#f1f6fd;overflow-y: auto">
 	<div id="toolbar" style="padding:20px;font-size:12px;">
	品牌：<input id="brand_no" class="easyui-combobox" prompt="轮胎品牌"/> 
    规格：<input id="norms_no" class="easyui-combobox" prompt="轮胎规格"/>
    日期：<input id="time" class="easyui-datebox" style="width: 100px;height:26px;">
	<button id="search" class="searchbutton" style="vertical-align:middle">搜索 </button>

	</div>
 	<table id="dg" class="easyui-datagrid" style="width: 100%" url="../ajaction/v1/?menuid=111110&cmd=qry_kc"
          rownumbers="false" pagination="true" striped="true">
        <thead>
        <tr>
            <th data-options="field:'brand',width:300">轮胎品牌</th>
            <th data-options="field:'norms_name',width:300">轮胎规格</th>
            <th data-options="field:'rk_num',width:230">入库数量</th>
            <th data-options="field:'ck_num',width:200">出库数量</th>
            <th data-options="field:'kc_num',width:200">库存数量</th>
        </tr>
        </thead>
    </table>

</body>
</html>
