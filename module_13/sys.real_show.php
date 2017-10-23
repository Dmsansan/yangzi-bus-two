<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车辆轮胎状态</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/carManger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
</head>
<body class="easyui-layout" style="height: 100%; width: 100%">
<table id="datatable" class="easyui-datagrid" pagination="true"
       url="../../datagrid_data1.json" striped="true", style="width: 100%; height: 100%;"
       toolbar="#tb" singleSelect="true" fitColumns="true">
    <thead>
    <tr>
        <th field="name1" width="15%" rowspan="2">时间</th>
        <th field="name2" width="5%" rowspan="2">信息</th>
        <th field="name3" width="10%" rowspan="2">车牌号码</th>
        <th field="name4" width="10%" rowspan="2">累计里程</th>
        <th colspan=2 width="10%">左前轮</th>
        <th colspan=2 width="10%">右前轮</th>
        <th colspan=2 width="10%">左后外侧</th>
        <th colspan=2 width="10%">左后内侧</th>
        <th colspan=2 width="10%">右后内侧</th>
        <th colspan=2 width="10%">右后外侧</th>
    </tr>
    <tr>
        <th field="name5" width="5%">温度</th>
        <th field="name6" width="5%">压力</th>
        <th field="name7" width="5%">温度</th>
        <th field="name8" width="5%">压力</th>
        <th field="name9" width="5%">温度</th>
        <th field="name10" width="5%">压力</th>
        <th field="name11" width="5%">温度</th>
        <th field="name12" width="5%">压力</th>
        <th field="name13" width="5%">温度</th>
        <th field="name14" width="5%">压力</th>
        <th field="name15" width="5%">温度</th>
        <th field="name16" width="5%">压力</th>
    </tr>
    </thead>
</table>
<div id="tb">
    <span>车队</span><input
        class="easyui-combobox" style="width: 100px"
        url="../../data/combobox_data.json" valueField="id" textField="text">
</div>
</body>
</html>