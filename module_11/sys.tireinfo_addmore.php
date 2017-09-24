

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
		var com_norms;
		var com_brand;
		var com_sensor;
		$(function () {
            $.metadata.setType("attr", "validate");
            XHD.validate($(form1));
            $("form").ligerForm();
			//comparam=null;//getparastr("r_tire_id");			
            loadForm();

            //$('#T_employee').ligerComboBox({ width: 196, onBeforeOpen: f_selectContact });
            //$("#admin_name").attr("validate", "{ required: true,messages: {required: '请输入IP'} }");
			
			

        })
        function f_save() {
            if ($(form1).valid()) {
                var sendtxt = "&cmd=addmore";				
                var param=$("form :input").fieldSerialize() + sendtxt;				
				return param;
				
				
            }else{
				//alert("valid");
			}
        }
        var a; var b; var c; var d; var e; var f; var g; var h; var i;
		
		
		function getlistdata(com_obj,url)
		{
			$.ajax({
                type: "POST",
                /*url: "../ajaction/sysaction/get_all_store.php?rnd=" + Math.random(),*/				
				url:url,
				success:function (result) {
					//
					
					var obj = eval("("+result+")");
					if(obj.status!="OK"){
						if (obj.reason )alert(obj.reason);
						return;
					}
					//obj=obj.items;
                    /*for (var n in obj.items) {
                        if (obj.items[n] == "null" || obj.items[n] == null)
                            obj.items[n] = "";
                    }*/
					//obj.items.unshift({store_id:0,store_name:"(空)"});
					if(obj.items !=undefined){
						com_obj.setData(obj.items);
					}
					
				},
				error:function(){
					alert("获取列表失败");
				}
			});
		}
		function initcomo(s,w)
		{
				return $(s).ligerComboBox({
						width:w,
						valueField:'id',
						textField:'name',
						/*data:obj,
						url: "../ajaction/sysaction/get_all_roles.php?rnd=" + Math.random(),*/
						isMultiSelect: false ,
						onSelected: function (newvalue, newtext) {
							if(s=="#brand_id"){
								if (!newvalue)
									newvalue = -1;
								//alert(newvalue);
								 //getlistdata(com_norms,"../ajaction/sysaction/get_all_norms.php?brand_id="+newvalue);
								getlistdata(com_norms,"../ajaction/v1/?menuid=0&cmd=get_all_tireparam&brand_id="+newvalue);
                            }
						}
			});
		}
		function initcom()
		{
			//品牌
			com_brand=initcomo("#brand_id",180);     //轮胎品牌
			com_norms=initcomo("#norms_id",340);     //轮胎参数  
			
			
			//每个组件都需要获取数据
			getlistdata(com_brand,"../ajaction/v1/?menuid=0&cmd=get_all_brand");
			
		}	
        function loadForm() {
            //var dialog = frameElement.dialog;
            //dialog.setShowToggle(0);
			var obj=[{id:1,text:"1"}];
			initcom();
			switch_check = $("#tire_switch").ligerCheckBox({});
			
            $.ajax({
                type: "GET",
                url: "../ajaction/v1/?menuid=111110&cmd=qry_tireswitch", 
                data: { rnd: Math.random() }, 
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (result) {
                    var obj = eval(result);
                    for (var n in obj) {
                        if (obj[n] == "null" || obj[n] == null)
                            obj[n] = "";
                    }
                    if(obj.tire_switch=="on"){
						switch_check.setValue(obj.tire_switch);
					}
					com_brand.selectValue(obj.brand_id);
					com_norms.selectValue(obj.tire_param_id);
                }
            });
			
		
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
        <table style="width: 500px; margin: 5px;" class='bodytable1'>
            <tr>
                <td colspan="4" class="table_title1">基本信息</td>
            </tr>
            <tr>
                <td>
                    <div style="width: 80px; text-align: right; float: right">入库开关：</div>
                </td>
                <td >
                    <input type="checkbox" id="tire_switch" name="tire_switch" ltype="checkbox" ligerui="{width:200}" /></td>
				<td style="width:50:px">
                    <div style="width: 80px; text-align: right; float: right">品牌：</div>
                </td>
                <td colspan="3">
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="brand_id"  name="brand_id" validate="{required:true}" /></td> 
            </tr>
			
			<tr>
				<td>
                    <div style="width: 120px; text-align: right; float: right">规格/层级/花纹：</div>
                </td>
                <td colspan="3">
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="norms_id"  name="norms_id" validate="{required:true}" ligerui="{width:340}" /></td>
				
			</tr>
			
        </table>
    </form>
</body>
</html>
