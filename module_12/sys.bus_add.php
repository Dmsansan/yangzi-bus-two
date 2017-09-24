

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
			comparam=getparastr("r_plate_no");			
			//alert(comparam);
            loadForm(comparam);

            //$('#T_employee').ligerComboBox({ width: 196, onBeforeOpen: f_selectContact });
            //$("#plate_no").attr("validate", "{ required: true,messages: {required: '请输入车牌号'} }");
			
			

        })
        function f_save() {
            if ($(form1).valid()) {
                var sendtxt = "&cmd=add";
				if(comparam!="" && comparam!=null) {
					sendtxt="&cmd=edit&plate_no=" + comparam;
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
			//alert(oaid);
			com_terminal=$("#terminal_id").ligerComboBox({
						width:196,
						valueField:'id',
						textField:'name',
						/*data:obj,
						url: "../ajaction/sysaction/get_all_roles.php?rnd=" + Math.random(),*/
						isMultiSelect: false 					
			
			});
			
			com_wheel_count=$("#wheel_count").ligerComboBox({
					width:96,
					valueField:'id',
					textField:'name',
					data:[
                    { name: '4', id: '4' },
                    { name: '6', id: '6' }                    
                ],isMultiSelect: false 					
			});
			
			//com_modules.setData(obj);
			//获取role_title
			$.ajax({
                type: "POST",
                /*url: "../ajaction/sysaction/get_all_store.php?rnd=" + Math.random(),*/				
				url:"../ajaction/v1/?menuid=0&cmd=get_all_vterm",
				success:function (result) {					//
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
					com_terminal.setData(obj.items);
					
				},
				error:function(){
					alert("获取终端列表");
				}
			});
			
			//$("#plate_no").ligerGetTextBoxManager().setDisabled();
			
			if(oaid!=="" && oaid!==null ) {
			
            $.ajax({
                type: "GET",
                url: "../ajaction/v1/?menuid=121010&cmd=qrybyone&plate_no="+(oaid), 
                data: { rnd: Math.random() }, 
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
                    $("#plate_no").val(obj.plate_no);
					$("#plate_no").ligerGetTextBoxManager().setDisabled();  //只读不可以随便改
                    com_terminal.selectValue(obj.v_term_id);
					com_wheel_count.selectValue(obj.wheel_count);
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
                <td colspan="4" class="table_title1">基本信息</td>
            </tr>
            <tr>
                <td>
                    <div style="width: 80px; text-align: right; float: right">车牌号码：</div>
                </td>
                <td>
                    <input type="text" id="plate_no" name="plate_no" ltype="text" ligerui="{width:196}" /></td>
				<td>
                    <div style="width: 80px; text-align: right; float: right">车载终端：</div>
                </td>
                <td>
					<!--<input type="text" id="txt3"/>-->					
                    <input type="text" id="terminal_id"  name="terminal_id" ligerui="{width:196}" validate="{required:true}" /></td> 
            </tr>
			<tr>
				<td>
					<div style="width: 80px; text-align: right; float: right">车轮数：</div>
				</td>
				<td>
					<input type="text" id="wheel_count" name="wheel_count" ligerui="{width:196}" validate="{required:true}" /></td>
				</td>
			</tr>
			
			<tr>
				<td>
                    <div style="width: 80px; text-align: right; float: right">备注：</div>
                </td>                
                <td colspan="3">
                    <input id="remark" name="remark" type="text" ltype="text" ligerui="{width:495}" /></td>
            </tr>
        </table>
    </form>
</body>
</html>
