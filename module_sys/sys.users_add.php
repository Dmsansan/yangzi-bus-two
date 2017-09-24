

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
            loadForm(getparastr("r_admin_id"));

            //$('#T_employee').ligerComboBox({ width: 196, onBeforeOpen: f_selectContact });
            $("#admin_name").attr("validate", "{ required: true, remote: remote, messages: { required: '请输入角色名', remote: '此角色已存在!' } }");

        })
        function f_save() {
            if ($(form1).valid()) {
                var sendtxt = "&cmd=add";
				if(getparastr("r_admin_id")!="" && getparastr("r_admin_id")!=null) {
					sendtxt="&cmd=edit&admin_id=" + getparastr("r_admin_id");
				}
                var param=$("form :input").fieldSerialize() + sendtxt;
				
				return param;
				
				
            }else{
				alert("valid");
			}
        }
        var a; var b; var c; var d; var e; var f; var g; var h; var i;

        function loadForm(oaid) {
            //var dialog = frameElement.dialog;
            //dialog.setShowToggle(0);
			var obj=[{id:1,text:"1"}];
			com_modules=$("#role_id").ligerComboBox({
						width:196,
						valueField:'role_id',
						textField:'role_title',
						/*data:obj,
						url: "../ajaction/sysaction/get_all_roles.php?rnd=" + Math.random(),*/
						isMultiSelect: false 
			});
			manager_is_term = $("#is_term").ligerCheckBox();
			
			//com_modules.setData(obj);
			//获取role_title
			$.ajax({
                type: "POST",
                /*url: "../ajaction/sysaction/get_all_roles.php?rnd=" + Math.random(),*/
				url:"../ajaction/v1/?menuid=0&cmd=get_all_roles&rnd="+Math.random(),
				success:function (result) {
					//
					var obj = eval("("+result+")");
					if(obj.status!="OK"){
						alert(obj.reason);
						return;
					}
					//obj=obj.items;
                    /*for (var n in obj.items) {
                        if (obj.items[n] == "null" || obj.items[n] == null)
                            obj.items[n] = "";
                    }*/
					com_modules.setData(obj.items);
					
				},
				error:function(){
					alert("获取角色列表");
				}
			});
			
			com_store=$("#store_id").ligerComboBox({
						width:196,
						valueField:'store_id',
						textField:'store_name',
						/*data:obj,
						url: "../ajaction/sysaction/get_all_roles.php?rnd=" + Math.random(),*/
						isMultiSelect: false 
			});	
			
			//com_modules.setData(obj);
			//获取role_title
			$.ajax({
                type: "POST",
                /*url: "../ajaction/sysaction/get_all_store.php?rnd=" + Math.random(),*/				
				url:"../ajaction/v1/?menuid=0&cmd=get_all_stores",
				success:function (result) {
					//
					var obj = eval("("+result+")");
					if(obj.status!="OK"){
						alert(obj.reason);
						return;
					}
					//obj=obj.items;
                    /*for (var n in obj.items) {
                        if (obj.items[n] == "null" || obj.items[n] == null)
                            obj.items[n] = "";
                    }*/
					//obj.items.unshift({store_id:0,store_name:"(空)"});
					com_store.setData(obj.items);
					
				},
				error:function(){
					alert("获取车队列表");
				}
			});
			
			
					
					
					
			com_operlist=$("#operlist").ligerComboBox({ isShowCheckBox: true, isMultiSelect: true,
                data: [
                    { text: '修改',id:'修改' },
                    { text: '删除',id:'删除'}
                ], valueFieldID: 'test'
            });			
			if(oaid!=="" && oaid!==null ) {
            $.ajax({
                type: "GET",
                url: "../ajaction/v1/?menuid=101011&cmd=qrybyone", 
                data: { admin_id: oaid, rnd: Math.random() }, 
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
                    $("#admin_name").val(obj.admin_name);
                    $("#remark").val(obj.remark); //用户说明
					$("#admin_pass").val(obj.password); 
					$("#real_name").val(obj.real_name); 
					$("#email").val(obj.email); 
					$("#tel").val(obj.tel); 
					$("#mobile").val(obj.mobile); 					
					//com_modules.setValue(obj.modules_list);
					//com_modules.setValue(obj.modules_list,obj.modules_list);
					com_modules.selectValue(obj.role_id);	
					manager_is_term.setValue(obj.is_term);	
					com_store.selectValue(obj.store_id);  //所属车队	
					
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
                    <div style="width: 80px; text-align: right; float: right">用户名：</div>
                </td>
                <td>
                    <input type="text" id="admin_name" name="admin_name" ltype="text" ligerui="{width:196}" validate="{required:true}" /></td>
				<td>
                    <div style="width: 80px; text-align: right; float: right">用户角色：</div>
                </td>
                <td>
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="role_id"  name="role_id" /></td>  <!--ltype="text" ligerui="{width:196}" validate="{required:true}" -->
            </tr>
			<tr>
				<td>
                    <div style="width: 80px; text-align: right; float: right">密码：</div>
                </td>                
                <td>
                    <input id="admin_pass" name="admin_pass" type="password" ligerui="{width:196}" /></td>
            
			
			
				<td>
                    <div style="width: 80px; text-align: right; float: right">真实姓名：</div>
                </td>                
                <td colspan="3">
                    <input id="real_name" name="real_name" type="text" ltype="text" ligerui="{width:196}"  /></td>
            
			</tr>
			<tr>
			<td>
				<div style="width: 80px; text-align: right; float: right">手持终端：</div>
            </td>   
			<td>
			<input type="checkbox" name="is_term" id="is_term" class="liger-checkbox" />
			</td>
			<td>
                    <div style="width: 80px; text-align: right; float: right">所属车队：</div>
                </td>
                <td>
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="store_id"  name="store_id" validate="{required:true}" /></td> 
			</tr>
			<tr>				
                <td colspan="4" class="table_title1">其他信息</td>
            </tr>
			
			<tr>
                <td>
                    <div style="width: 80px; text-align: right; float: right">联系电话：</div>
                </td>
                <td>
                    <input type="text" id="tel" name="tel" ltype="text" ligerui="{width:196}"  /></td>
				<td>
                    <div style="width: 80px; text-align: right; float: right">手机号码：</div>
                </td>
                <td>
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="mobile"  name="mobile" ltype="text" ligerui="{width:196}" /></td>  <!--ltype="text" ligerui="{width:196}" validate="{required:true}" -->
			</tr>
			
			<tr>
				<td>
                    <div style="width: 80px; text-align: right; float: right">邮箱：</div>
                </td>                
				<td colspan="2">
                   <input id="email" name="email" type="text" ltype="text" ligerui="{width:300}" validate="{email:true}" /></td>
			</tr>
			
			<tr>
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
