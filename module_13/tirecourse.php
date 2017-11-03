﻿<!DOCTYPE html>
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
        //按车牌号搜索
        $('#search').bind('click',function(){
            var plate_no = $('#plate_no').val();
            $.ajax({
                url:'../ajaction/v1/?menuid=131311&cmd=qry',
                type:'POST',
                data:{'plate_no':plate_no},
                dataType:'json',
                success:function(data){
                    console.log('serach_success',data);
                    $('#dg').datagrid('loadData',data.rows);
                },
                error:function(data){
                    console.log('search_error',data);
                }
            });
        })
    })
    </script>
</head>
<body class="easyui-layout" style="width: 100%;height: 100%;background-color: #ffffff">
<div  class="u-content">
<div id="tb" style="margin-bottom: 10px;margin-top: 10px">
        <input id="plate_no" type="text" placeholder="车牌号码"/> <button id="search">搜索</button>
        <button id="exp" style="float: right"><span style="display:inline-block;margin-right:12px;">+</span>打印</button>
    </div>
<<<<<<< HEAD
    <table id="dg" class="easyui-datagrid" style="width: 100%" url="../ajaction/v1/?menuid=131311&cmd=qry" 
          rownumbers="false" pagination="true">
=======
    <table id="dg" class="easyui-datagrid" style="width: 100%" url="../ajaction/v1/?menuid=131311&cmd=qry"
          rownumbers="false" pagination="true" striped="true">
>>>>>>> 6899dcdc01aa0d16222a68d6e5b09ad54d1dd3f9
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
</div>
</body>
</html>