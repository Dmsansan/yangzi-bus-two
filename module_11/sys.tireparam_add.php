

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
			comparam=getparastr("r_tire_param_id");			
            loadForm(comparam);

            //$('#T_employee').ligerComboBox({ width: 196, onBeforeOpen: f_selectContact });
            //$("#admin_name").attr("validate", "{ required: true,messages: {required: '请输入IP'} }");
			
			

        })
        function f_save() {
            if ($(form1).valid()) {
                var sendtxt = "&cmd=add";
				if(comparam!="" && comparam!=null) {
					sendtxt="&cmd=edit&tire_param_id=" + comparam;
				}
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
						alert(obj.reason);
						return;
					}
					//obj=obj.items;
                    /*for (var n in obj.items) {
                        if (obj.items[n] == "null" || obj.items[n] == null)
                            obj.items[n] = "";
                    }*/
					//obj.items.unshift({store_id:0,store_name:"(空)"});
					com_obj.setData(obj.items);
					
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
						isMultiSelect: false 
			});
		}
		function initcom()
		{
			//品牌
			com_brand=initcomo("#brand_id",180);
			//规格norms
			com_norms=initcomo("#norms_id",130);
			//class_id        int   				comment '层级ID',
			//figure_id		int					comment  '花纹ID',
			com_class=initcomo("#class_id",130);
			com_figure=initcomo("#figure_id",180);
			//每个组件都需要获取数据
			getlistdata(com_brand,"../ajaction/v1/?menuid=0&cmd=get_all_brand");
			getlistdata(com_norms,"../ajaction/v1/?menuid=0&cmd=get_all_norms");
			getlistdata(com_class,"../ajaction/v1/?menuid=0&cmd=get_all_class");
			getlistdata(com_figure,"../ajaction/v1/?menuid=0&cmd=get_all_figure");
		}
        function loadForm(oaid) {
            //var dialog = frameElement.dialog;
            //dialog.setShowToggle(0);
			var obj=[{id:1,text:"1"}];
			initcom();
			if(oaid!=="" && oaid!==null ) {
            $.ajax({
                type: "GET",
                url: "../ajaction/v1/?menuid=111010&cmd=qrybyone", 
                data: { tire_param_id: oaid, rnd: Math.random() }, 
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
                    $("#company_name").val(obj.company_name);
					
					  .selectValue(obj.brand_id);
					com_norms.selectValue(obj.norms_id);
					com_class.selectValue(obj.class_id);
					com_figure.selectValue(obj.figure_id);
					$("#pressure_ll").val(obj.pressure_ll);
					$("#pressure_ul").val(obj.pressure_ul);
					$("#speed_ul").val(obj.speed_ul);
					$("#temp_ul").val(obj.temp_ul);
					$("#tkph_val").val(obj.tkph_val);
					$("#baro_val").val(obj.baro_val);   
					$("#mainterance1").val(obj.mainterance1);
					$("#mainterance2").val(obj.mainterance2);
					$("#rated_mile").val(obj.rated_mile);
		
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
                    <div style="width: 80px; text-align: right; float: right">制造商：</div>
                </td>
                <td colspan="3">
                    <input type="text" id="company_name" name="company_name" ltype="text" ligerui="{width:340}" validate="{required:true}"/></td>
				<td style="width:50:px">
                    <div style="width: 80px; text-align: right; float: right">品牌：</div>
                </td>
                <td colspan="3">
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="brand_id"  name="brand_id" validate="{required:true}" /></td> 
            </tr>
			
			<tr>
				<td>
                    <div style="width: 80px; text-align: right; float: right">轮胎规格：</div>
                </td>
                <td>
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="norms_id"  name="norms_id" validate="{required:true}" /></td>
				<td>
                    <div style="width: 60px; text-align: right; float: right">层级(PR)：</div>
                </td>
                <td>
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="class_id"  name="class_id" validate="{required:true}" /></td>
				<td>
                    <div style="width: 80px; text-align: right; float: right">花纹类型：</div>
                </td>
                <td colspan="3">
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="figure_id"  name="figure_id" validate="{required:true}" /></td> 
			</tr>
			<tr>
				<td>
                   <div style="width: 100px; text-align: right; float: right">压力测量范围：</div>
                </td>
                <td colspan="1">
					<div style="text-align: left; float: left;display:inline;">
                    <input type="text" id="pressure_ll"  name="pressure_ll" ltype="text" value="6.5" validate="{required:true,number:true}" ligerui="{width:40}" />
					</div>
					<div style="width:20px;text-align: left; float: left;display:inline;">~</div>
					<div style="text-align: left; float: left;display:inline;">
					<input type="text" id="pressure_ul"  name="pressure_ul" ltype="text" value="12.5" validate="{required:true,number:true}" ligerui="{width:40}" />
					</div>				
				</td>	
				<td><div style="width: 80px; text-align: right; float: right">速度(km/h)：</div></td>
				<td>
				<input type="text" id="speed_ul"  name="speed_ul" ltype="text" value="40" validate="{required:true,number:true}" ligerui="{width:40}" />
				</td>
				<td><div style="width: 80px; text-align: right; float: right">温度上限(℃)：</div></td>
				<td>
				<input type="text" id="temp_ul"  name="temp_ul" ltype="text" value="90" validate="{required:true,number:true}" ligerui="{width:40}" />
				</td>
				<td><div style="width: 60px; text-align: right; float: right">TKPH值：</div></td>
				<td>
				<input type="text" id="tkph_val"  name="tkph_val" ltype="text" value="0" validate="{required:true,number:true}" ligerui="{width:40}" />
				</td>				
			</tr>			
			<tr>
				<td >
                    <div style="width: 100px; text-align: right; float: right">标准充气压力：</div>
                </td>                
                <td >
                    <input type="text" id="baro_val"  name="baro_val" ltype="text" value="0" validate="{required:true,number:true}" ligerui="{width:40}" />
				</td>
				<td><div style="width: 80px; text-align: right; float: right">一保(KM)：</div></td>
				<td>
				<input type="text" id="mainterance1"  name="mainterance1" ltype="text" value="50000" validate="{required:true,number:true}" ligerui="{width:60}" />
				</td>
				<td><div style="width: 80px; text-align: right; float: right">二保(KM)：</div></td>
				<td>
				<input type="text" id="mainterance2"  name="mainterance2" ltype="text" value="80000" validate="{required:true,number:true}" ligerui="{width:60}" />
				</td>
			</tr>
			<tr>
				<td >
                    <div style="width: 100px; text-align: right; float: right">额定里程(KM)：</div>
                </td>                
                <td >
                    <input type="text" id="rated_mile"  name="rated_mile" ltype="text" value="180000" validate="{required:true,number:true}" ligerui="{width:60}" />
				</td>

			</tr>
        </table>
    </form>
</body>
</html>
