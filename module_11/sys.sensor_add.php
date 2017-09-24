

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
            //var dialog = frameElement.dialog;
            //dialog.setShowToggle(0);
			var obj=[{id:1,text:"1"}];
			if(oaid!=="" && oaid!==null ) {
            $.ajax({
                type: "GET",
                url: "../ajaction/v1/?menuid=111011&cmd=qrybyone", 
                data: { sensor_id: oaid, rnd: Math.random() }, 
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (result) {
                    var obj = eval(result);
                    for (var n in obj) {
                        if (obj[n] == "null" || obj[n] == null)
                            obj[n] = "";
                    }
                    //alert(obj.constructor); //String 构造函数
					// {"admin_id":1, "admin_name":"管理员","admin_pass":"密码","real_name":"管理员","role_id":角色编号,“is_term”:false,"email",:"","tel":"","mobile","","remark":""}
                    $("#sensor_no").val(obj.sensor_no);
					$("#temp_ll").val(obj.temp_ll);
					$("#temp_ul").val(obj.temp_ul);
					$("#pressure_ll").val(obj.pressure_ll);
					$("#pressure_ul").val(obj.pressure_ul);
                    $("#remark").val(obj.remark); //用户说明
					
                    
		
                }
            });
			}
		
        }
        /*function f_selectContact() {
            top.$.ligerDialog.open({
                zindex: 9003,
                title: '选择员工', width: 850, height: 400, url: "hr/Getemp_Auth.aspx?auth=1", buttons: [
                    { text: '确定', onclick: f_selectContactOK },
                    { text: '取消', onclick: f_selectContactCancel }
                ]
            });
            return false;
        }
        function f_selectContactOK(item, dialog) {
            var data = dialog.frame.f_select();
            if (!data) {
                alert('请选择员工!');
                return;
            }

            fillemp(data.dname, data.d_id, data.name, data.ID);

            dialog.close();
        }
        function fillemp(dep, depid, emp, empid) {
            $("#T_employee").val("【" + dep + "】" + emp);
            $("#T_employee1").val(emp);
            $("#T_employee_val").val(empid);
            $("#T_dep").val(dep);
            $("#T_dep_val").val(depid);
        }
        function f_selectContactCancel(item, dialog) {
            dialog.close();
        }
		*/
        function remote() {
            //var url = "CRM_Customer.validate.xhd?T_cid=" + getparastr("cid") + "&rnd=" + Math.random();
            //return url;
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
                    <input type="text" id="sensor_no" name="sensor_no" ltype="text" ligerui="{width:196}" validate="{required:true}"/></td>
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
                    <div style="width: 80px; text-align: right; float: right">备注：</div>
                </td>                
                <td colspan="7">
                    <input id="remark" name="remark" type="text" ltype="text" ligerui="{width:495}" /></td>
            </tr>
        </table>
    </form>
</body>
</html>
