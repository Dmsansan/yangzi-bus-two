

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
            loadForm(comparam);

            //$('#T_employee').ligerComboBox({ width: 196, onBeforeOpen: f_selectContact });
            //$("#plate_no").attr("validate", "{ required: true,messages: {required: '请输入车牌号'} }");
			
			

        })
        function f_save() {
            if ($(form1).valid()) {
                var sendtxt = "&cmd=addtire";
				if(comparam!="" && comparam!=null) {
					sendtxt="&cmd=addtire&plate_no=" + comparam;
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
						isMultiSelect: false ,
						onSelected: function (newvalue, newtext) {
							if(s=="#norms_id"){
								if (!newvalue)
									newvalue = -1;								
								getlistdata(com_tires,"../ajaction/v1/?menuid=0&cmd=get_all_tire&tire_param_id="+newvalue);
                            }							
						}
			});
		}
        function loadForm(oaid) {
            //var dialog = frameElement.dialog;
            //dialog.setShowToggle(0);
			
			
			
			com_norms=initcomo("#norms_id",340);     //轮胎参数
			com_tires=initcomo("#tire_id",190);
			com_place=initcomo("#place_no",190);     //可安装轮胎数
			getlistdata(com_norms,"../ajaction/v1/?menuid=0&cmd=get_all_tireparam");
			//getlistdata(com_place,"../ajaction/v1/?menuid=0&cmd=get_all_place&plate_no="+oaid);
			//getlistdata(com_place,"../ajaction/v1/?menuid=0&cmd=get_all_place");
			//com_modules.setData(obj);
			//获取role_title		
			$.ajax({
                type: "POST",
                url: "../ajaction/v1/?menuid=0&cmd=get_all_place&plate_no="+oaid,				
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
					for (var n in obj.items) {
                        if (obj.items[n] == "null" || obj.items[n] == null)
                            obj.items[n] = "";
						else{
							obj.items[n].name=gettirename(Number(obj.items[n].id));
						}	
                    }
					com_place.setData(obj.items);
					
				},
				error:function(){
					alert("获取列表失败");
				}
			});
			
			
		
        }
        
        
    </script>
</head>
<body>
    <form id="form1" onsubmit="return false">
        <table style="width:350px; margin: 5px;" class='bodytable1'>
            <tr>
                <td colspan="2" class="table_title1">基本信息</td>
            </tr>
            <tr>
				<td colspan="2">
                    <div style="width: 120px; text-align: left; float: left">规格/层级/花纹：</div>
                </td>               
			</tr>
			<tr>
			<td colspan="2">
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="norms_id"  name="norms_id" validate="{required:true}" ligerui="{width:340}" /></td>
			</tr>
			<tr>
				<td>
                    <div style="width: 80px; text-align: left; float: left">轮胎胎号：</div>
                </td>
                <td>
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="tire_id"  name="tire_id" validate="{required:true}" ligerui="{width:190}" /></td>
			</tr>
			<tr>
				<td>
                    <div style="width: 80px; text-align: left; float: left">安装位置：</div>
                </td>
                <td>
					<!--<input type="text" id="txt3"/>-->
                    <input type="text" id="place_no"  name="place_no" validate="{required:true}" ligerui="{width:190}" /></td>
			</tr>			
        </table>
    </form>
</body>
</html>
