

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
		var comparam="";
		$(function () {
            $.metadata.setType("attr", "validate");
            XHD.validate($(form1));
            $("form").ligerForm();			
            comparam=getparastr("r_store_id");
			loadForm(comparam);

            //$('#T_employee').ligerComboBox({ width: 196, onBeforeOpen: f_selectContact });
            $("#store_no").attr("validate", "{ required:true, remote: remote, messages: { required: '请输入角色名', remote: '此角色已存在!' } }");
			$("#mobile").attr("validate", "{ required:false,digits:true,messages:{ required: '请输入角色名', digits:'只能是数值!' } }");

        })
        function f_save() {
            if ($(form1).valid()) {
                var sendtxt = "&cmd=add";
				if(comparam!="" && comparam!=null) {
					sendtxt="&cmd=edit&store_id=" + comparam;
				}
                var param=$("form :input").fieldSerialize() + sendtxt;
				return param;
				
            }else{
				alert("请检查参数");
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
                url: "../ajaction/v1/?menuid=101110&cmd=qrybyone", 
                data: { store_id: oaid, rnd: Math.random() }, 
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
                    $("#store_no").val(obj.store_no);
                    $("#remark").val(obj.remark); //用户说明
					$("#store_name").val(obj.store_name); 					
					$("#contact").val(obj.contact); 					
					$("#address").val(obj.address); 
					$("#tel").val(obj.tel); 
					$("#mobile").val(obj.mobile); 	
					
					//com_modules.setValue(obj.modules_list);
					//com_modules.setValue(obj.modules_list,obj.modules_list);
					//com_modules.selectValue(obj.role_id);	
					//manager_is_term.setValue(obj.is_term);					
					
                    /*titl
                    if (obj.Employee) {
                        fillemp(obj.Department, obj.Department_id, obj.Employee, obj.Employee_id);
                        $("#tr_contact0,#tr_contact1,#tr_contact2,#tr_contact3,#tr_contact4,#tr_contact5").remove();
                    }
                    else {
                        $.getJSON("hr_employee.form.xhd?id=epu&rnd=" + Math.random(), function (result) {
                            var obj = eval(result);
                            for (var n in obj) {
                                if (obj[n] == null)
                                    obj[n] = "";
                            }
                            fillemp(obj.dname, obj.d_id, obj.name, obj.ID);

                        })
                    }*/

                    //$('#T_customertype').ligerComboBox({ width: 97, url: "Param_SysParam.combo.xhd?parentid=1&rnd=" + Math.random(), emptyText: '（空）', initValue: obj.CustomerType_id });
                    
                    /*b = $('#T_City').ligerComboBox({ width: 96, emptyText: '（空）' });
                    c = $('#T_Provinces').ligerComboBox({
                        width: 97,
                        initValue: obj.Provinces_id,
                        url: "Param_City.combo1.xhd?rnd=" + Math.random(),
                        onSelected: function (newvalue, newtext) {
                            if (!newvalue)
                                newvalue = -1;
                            $.get("Param_City.combo2.xhd?pid=" + newvalue + "&rnd=" + Math.random(), function (data, textStatus) {
                                b.setData(eval(data));
                                b.selectValue(obj.City_id);
                            });
                        }, emptyText: '（空）'
                    });
					*/
		
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
                <td colspan="4" class="table_title1">基本信息</td>
            </tr>
            <tr>
                <td>
                    <div style="width: 80px; text-align: right; float: right">车队代码：</div>
                </td>
                <td>
                    <input type="text" id="store_no" name="store_no" ltype="text" ligerui="{width:196}" validate="{required:true}" /></td>
				<td>
                    <div style="width: 80px; text-align: right; float: right">名称：</div>
                </td>
                <td>
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="store_name"  name="store_name" ltype="text" ligerui="{width:196}" validate="{required:true}" /></td>  <!--ltype="text" ligerui="{width:196}" validate="{required:true}" -->
            </tr>
			<tr>
				<td>
                    <div style="width: 80px; text-align: right; float: right">联系人姓名：</div>
                </td>                
                <td>
                    <input id="contact" name="contact" type="text" ltype="text" ligerui="{width:196}" /></td>			
			
				<td>
                    <div style="width: 80px; text-align: right; float: right">固定电话：</div>
                </td>                
                <td colspan="3">
                    <input id="tel" name="tel" type="text" ltype="text" ligerui="{width:196}"  /></td>
            
			</tr>
			
			<tr>
				<td>
                    <div style="width: 80px; text-align: right; float: right">手机号码：</div>
                </td>                
                <td>
                    <input id="mobile" name="mobile" type="text" ltype="text" ligerui="{width:196}" validate="{digits:true}"/></td>			
			
				
			</tr>		
			<!--
			<tr>				
                <td colspan="4" class="table_title1">其他信息</td>
            </tr>
			-->
			<tr>
			<td>
                    <div style="width: 80px; text-align: right; float: right">仓库地址：</div>
                </td>                
                <td colspan="3">
                    <input id="address" name="address" type="text" ltype="text" ligerui="{width:495}"  /></td>
     			<td>
			</tr>
			</tr>
			<td>
                    <div style="width: 80px; text-align: right; float: right">说明：</div>
                </td>                
                <td colspan="3">
                    <input id="remark" name="remark" type="text" ltype="text" ligerui="{width:495}" /></td>
            </tr>
        </table>
    </form>
</body>
</html>
