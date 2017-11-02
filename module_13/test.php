<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车辆维护</title>
	<link href="../lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />
	<!--<link href="../lib/ligerUI/skins/ext/css/ligerui-fix.css" rel="stylesheet" type="text/css" />-->
	<link href="../css/inputcharts.css" rel="stylesheet" />
	<script src="../lib/jquery/jquery-1.9.0.min.js" type="text/javascript"></script> 
	<script src="../lib/json2.js" type="text/javascript"></script>
	<script src="../lib/ligerUI/js/core/base.js" type="text/javascript"></script>   
	<script src="../lib/ligerUI/js/core/inject.js" type="text/javascript"></script>   
	<script src="../lib/ligerUI/js/ligerui.all.js" type="text/javascript"></script>        
	<script src="../lib/ligerUI/js/plugins/ligerGrid.js" type="text/javascript"></script> 
	<script src="../lib/ligerUI/js/plugins/ligerLayout.js" type="text/javascript"> </script> 
	<script src="../lib/ligerUI/js/plugins/ligerDateEditor.js" type="text/javascript"></script>
	<script src="../lib/ligerUI/js/plugins/ligerPopupEdit.js" type="text/javascript"></script>
	<script src="../lib/ligerUI/js/plugins/ligerComboBox.js" type="text/javascript"></script>
	<script src="../lib/ligerUI/js/plugins/ligerCombobox_ex.js" type="text/javascript"></script>

	<script src="../lib/jquery-validation/jquery.validate.js" type="text/javascript"></script>
	<script src="../lib/jquery-validation/jquery.metadata.js" type="text/javascript"></script>
	<script src="../lib/jquery-validation/messages_cn.js" type="text/javascript"></script>
		
	<script src="../js/XHD.js" type="text/javascript"> </script>
	<script src="../lib/jquery.form.js" type="text/javascript"> </script>


<script src="../js/echarts/echarts.min.js"></script>
<script type="text/javascript">
$(function(){
	$('#sure').on('click',function(){
		$('#dialog').show();
	});
	$('#test').on('click',function(){
		$('#dialog').hide();
	})
	$('#message').ligerGrid({
		checkbox: false,
                columns: [{display: '轮胎编号', name: 'tire_rfid',align:'left',width:100},
					{display:"轮胎号位",name:'place',aligin:'center',width:50},
				    {display: '品牌', name: 'company_name',align:'left',width:80},
					{display: '花纹深度', name: 'figure_value',align:'left',width:90},
					{display: '累计里程(Km)', name: 'mile_count',align:'left',width:80},
					{display: '装胎时间', name: 'fst_place_stamp',align:'left',width:130},
					{display: '报警次数', name: 'info_7',align:'left',width:70},
					{display: '是否翻新', name: 'info_8',align:'left',width:70}
					
                
                ], pageSize:200,
               /*  url:'../ajaction/v1/?menuid=131010&cmd=qrytire&plate_no='+comparam, */
	        
				dataAction: 'server', //服务器排序
                usePager: true,       //服务器分页
			
	})
		
	
	
})


</script>
    <style>
   

    </style>
</head>
<body>
<button id="sure">确定</button>
<!-- 车辆列表-->
<div id='dialog' style="width:1078px;height:440px;position:absolute;left:300px;top:100px;display:none;">
<div style="height:40px;background:#353c49">
<span style="margin-left:10px;color:#ffffff;line-height:40px;font-size:14px;">车辆信息</span>
<button id="test" style="height:20px;width:20px; background: url('../images/shutdown.png') no-repeat center center;border:none;float:right;margin-right:10px;margin-top:10px;"></button>
</div>
<div style="height:400px;background-color:#bdc4d4;padding:10px">
<div style="height:400px;background-color:#ffffff">

<div style="height: 400px;width: 230px;border-right:8px solid #bdc4d4; float:left">
<div style="height:40px;background-color:#ffffff">
<span style="line-height:40px;margin-left:10px;font-size:14px;">车辆骨架</span>
</div>
<table  style="width:230px;height:340px;background:url('../css/img/chesheng.png') no-repeat center center; ">
        <tr style="height: 68px">

        </tr>
    
    <tr>
        <td style="width:42px"></td>
        <td><img src="../css/img/chelun_selectedonetwo.png"></td>
        <td style="width: 22px;"></td>
        <td style="width: 58px"></td>
        <td style="width: 22px;"></td>
        <td><img src="../css/img/chelun_selectedonetwo.png"></td>
        <td style="width:42px"></td>

    </tr>
    <tr style="height: 167px;"></tr>
    <tr>
        <td style="width:42px"></td>
        <td><img src="../css/img/chelun_selectedonetwo.png"></td>
        <td><img src="../css/img/chelun_selectedonetwo.png"></td>
        <td style="width: 58px"></td>
        <td><img src="../css/img/chelun_selectedonetwo.png"></td>
        <td><img src="../css/img/chelun_selectedonetwo.png"></td>
        <td style="width:42px"></td>
    </tr>
    <tr style="height:38px">

    </tr>

</table>


</div>
<div  style="float:left;background-color:#f1f6fd">
<div style="height:40px;background-color:#ffffff">
<span  style="line-height:40px;margin-left:10px;font-size:14px;">轮胎信息</span>
</div>
<div id="message"></div>


</div>
</div>
</div>
<div>

</body>
</html>