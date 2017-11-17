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
       $(function(){
        //按车牌号搜索
        $('#search').bind('click',function(){
            //alert($('#plate_no').val());
            $("#dg").datagrid('load',{
                plate_no: $('#plate_no').val(),
                start_time: $('#start_time').val(),
                end_time: $('#end_time').val()
            }); 
        })
        //打印数据表格
        $('#exp').bind('click',function(){
            var start_time = $('#start_time').val();
            var end_time = $('#end_time').val();
            var plate_no = $('#plate_no').val();

            window.open("../ajaction/v1/?menuid=131311&cmd=exp_figure&plate_no="+plate_no+"&start_time="+start_time+"&end_time="+end_time);
        })
    })
    </script>
</head>
<body class="easyui-layout" style="width: 100%;height: 100%;background-color: #ffffff;overflow-y:auto">
<div  class="u-content"  data-options="fit:true" >
    <table id="dg" class="easyui-datagrid"
          url="../ajaction/v1/?menuid=131311&cmd=qry_figure" toolbar="#tb"
          striped="true" rownumbers="false" pagination="true">
        <thead>
		 <tr>
            <th data-options="field:'tire_no',width:120">轮胎胎号</th>
            <th data-options="field:'plate_no',width:120">车辆号码</th>
            <th data-options="field:'place_no',width:200">轮胎号位</th>
            <th data-options="field:'time_add',width:200">装车时间</th>
            <th data-options="field:'figure_mile',width:200">装车花纹深度</th>
        </tr>
        </thead>
    </table>
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px">
        起始日期: <input id="start_time" class="easyui-datebox" style="width: 100px;height:26px;">
        终止日期: <input id="end_time" class="easyui-datebox" style="width: 100px;height:26px;">
        车牌号码：<input id="plate_no" type="text" placeholder="车牌号码"/> 
        <button id="search">搜索</button>
		<button id="exp" style="float: right"><span style="margin-right:8px;">+</span>打印</button>
    </div>
</div>
</body>
</html>