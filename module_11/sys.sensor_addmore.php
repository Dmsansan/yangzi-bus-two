

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--<link href="../lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />-->
	<link href="../lib/ligerUI/skins/ext/css/ligerui-all.css" rel="stylesheet" type="text/css" />
	<link href="../css/input.css" rel="stylesheet" />
	<script src="../lib/jquery/jquery-1.9.0.min.js" type="text/javascript"></script> 
	<script src="../lib/json2.js" type="text/javascript"></script>
	<script src="../lib/ligerUI/js/core/base.js" type="text/javascript"></script>   
	<script src="../lib/ligerUI/js/core/inject.js" type="text/javascript"></script>   
	<script src="../lib/ligerUI/js/ligerui.all.js" type="text/javascript"></script>        
	<script src="../lib/ligerUI/js/plugins/ligerGrid.js" type="text/javascript"></script> 
	<script src="../lib/ligerUI/js/plugins/ligerLayout.js" type="text/javascript"> </script> 
	<script src="../lib/ligerUI/js/plugins/ligerForm.js" type="text/javascript"></script>
	<script src="../lib/ligerUI/js/plugins/ligerCheckBox.js" type="text/javascript"></script>
    <script src="../lib/ligerUI/js/plugins/ligerResizable.js" type="text/javascript"></script>
    <script src="../lib/ligerUI/js/plugins/ligerComboBox.js" type="text/javascript"></script>
	<script src="../lib/ligerUI/js/plugins/ligerCombobox_ex.js" type="text/javascript"></script>
	<script src="../lib/jquery-validation/jquery.validate.js" type="text/javascript"></script>
    <script src="../lib/jquery-validation/jquery.metadata.js" type="text/javascript"></script>
    <script src="../lib/jquery-validation/messages_cn.js" type="text/javascript"></script>
	
	
	<script src="../js/XHD.js" type="text/javascript"> </script>
	
    <script src="../lib/jquery.form.js" type="text/javascript"></script>
    <script src="../js/Toolbar.js" type="text/javascript"></script>
    <script src="../js/XHD.js" type="text/javascript"></script>
    <script type="text/javascript">
		$(function () {
            $.metadata.setType("attr", "validate");
            XHD.validate($(form1));
            $("form").ligerForm();
			comparam=getparastr("r_sensor_id");			
            loadForm(comparam);

            //$('#T_employee').ligerComboBox({ width: 196, onBeforeOpen: f_selectContact });
            //$("#admin_name").attr("validate", "{ required: true,messages: {required: '请输入IP'} }");
			
			

        })
        function f_save() {
            if ($(form1).valid()) {
                var sendtxt = "&cmd=add";
				if(comparam!="" && comparam!=null) {
					sendtxt="&cmd=edit&sensor_id=" + comparam;
				}
                var param=$("form :input").fieldSerialize() + sendtxt;				
				return param;
				
				
            }else{
				//alert("valid");
			}
        }
        var a; var b; var c; var d; var e; var f; var g; var h; var i;

        function loadForm(oaid) {
				com_num=$("#sensor_num").ligerComboBox({
						width:60,
						valueField:'id',
						textField:'name',
						data:[],						
						isMultiSelect: false 
				});
				var dat=[];
				for(var i=1;i<=15;i++){
					dat.push({"id":i,"name":i});
				}
				com_num.setData(dat);
				
		
        }
        function remote() {
			return "";
        }
    </script>
</head>
<body>
    <form id="form1" onsubmit="return false">
        <table style="width: 600px; margin: 5px;" class='bodytable1'>
            <tr>
                <td colspan="8" class="table_title1">基本信息</td>
            </tr>
            <tr>
                <td>
                    <div style="width: 80px; text-align: right; float: right">传感器编号：</div>
                </td>
                <td colspan="3">
					<div style="float:left; width:200px;">
					<div style="float:left;">
					<input type="text" id="sensor_no" name="sensor_no" ltype="text" ligerui="{width:150}" validate="{required:true}"/>
					</div>
					<div style="float:left;">
					-
					</div>
					<div style="float:left;">
					<input type="text" id="sensor_num" name="sensor_num"  ligerui="{width:40}" validate="{required:true}"/>
					</div>
					</div>
				</td>
				<td>
                    <div style="width: 100px; text-align: right; float: right">压力测量范围：</div>
                </td>
                <td >
					<!--<input type="text" id="txt3"/>-->
					
                    <input type="text" id="pressure_ll"  name="pressure_ll" ltype="text" value="0" validate="{required:true,number:true}" ligerui="{width:40}" />
				</td>	
				<td>~</td>
				<td>
				<input type="text" id="pressure_ul"  name="pressure_ul" ltype="text" value="1400" validate="{required:true,number:true}" ligerui="{width:40}" />
				</td>
            </tr>
			<tr>
			<td>
                    <div style="width: 100px; text-align: right; float: right">温度测量范围：</div>
                </td>
                <td>
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="temp_ll"  name="temp_ll" ltype="text" value="-40" validate="{required:true,number:true}" ligerui="{width:80}" />
				</td>
				<td style="text-align:center;width=30px;">~</td>
					<td>
					<input type="text" id="temp_ul"  name="temp_ul" ltype="text" value="125" validate="{required:true,number:true}" ligerui="{width:80}" />
					</td>
				<td colspan="4"></td>
			</tr>
			<tr>
				<td>
                    <div style="width: 80px; text-align: right; float: right">添加轮胎：</div>
                </td>                
                <td>
                    <input id="tire_switch" name="tire_switch" type="checkbox" ltype="checkbox" ligerui="{width:495}" /></td>
            </tr>
			<tr>
				<td>
                    <div style="width: 80px; text-align: right; float: right">备注：</div>
                </td>                
                <td colspan="7">
                    <input id="remark" name="remark" type="text" ltype="text" ligerui="{width:495}" /></td>
            </tr>
        </table>
    </form>
</body>
</html>
