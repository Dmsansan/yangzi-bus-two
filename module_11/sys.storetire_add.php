

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--<link href="../lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />-->
	<link href="../lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />
	<link href="../lib/ligerUI/skins/ext/css/ligerui-fix.css" rel="stylesheet" type="text/css" />
	<!--<link href="../lib/ligerUI/skins/ext/css/ligerui-all.css" rel="stylesheet" type="text/css" />-->
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
			comparam=getparastr("r_store_id");	
			serchpanel();
			manager=$("#maingrid4").ligerGrid({
                checkbox: true,
                columns: [
                { display: '编号', name:'tire_id', align: 'left', width: 60 },
                { display: '胎号', name:'factory_code', width:150 },
				{ display: '传感器编号', name:'sensor_no', width: 150,isSort:false },
				{ display: '规格',name:'norms_name',width: 120,isSort:false},
				{ display: '层级',name:'class_name',width: 100,isSort:false},
				{ display: '花纹',name:'figure_name',width: 100,isSort:false},
				{ display: '品牌',name:'brand_name',width: 100,isSort:false},
				{ display: '状态',name:'status',width: 100},
				{ display: '速度上限',name:'speed_ul',width: 100},
				{ display: '温度上限',name:'temp_ul',width: 100},
				{ display: '胎压上限',name:'pressure_ul',width: 100},
				{ display: '胎压下限',name:'pressure_ll',width: 100}				
				], pageSize:10,
                url:'../ajaction/v1/?menuid=111110&cmd=qry&store_id='+comparam,
				/*url:'../ajaction/sysaction/sys.roles_grid_show.php?a=3',*/
                /*toolbar:toolbarOptions,*/
                width: '100%',height:'97%',
				dataAction: 'server', //服务器排序
                usePager: true,       //服务器分页
				onSuccess:f_onSucess,
				onError:f_onError,
				isChecked: f_isChecked,				
				onCheckRow: f_onCheckRow, 
				onCheckAllRow: f_onCheckAllRow,
				onContextmenu : function (parm,e)
                {
                    //actionCustomerID = parm.data.CustomerID;
                    menu.show({ top: e.pageY, left: e.pageX });
                    return false;
                }
            });		
            
        });
		
		function doclear() {
            $("input:hidden", "#serchform").val("");
            $("input:text", "#serchform").val("");
            $(".l-selected").removeClass("l-selected");
        }
		
		function doserch() {
            var sendtxt = "&rnd=" + Math.random();
            var serchtxt = $("#serchform :input").fieldSerialize() + sendtxt;
			$('.pcontrol input', manager.toolbar).val(1);
			manager.changePage('input');
			manager.set({url:'../ajaction/v1/?menuid=111110&cmd=qry&'+serchtxt});
			//manager.loadData(true);
		
        }
		
		
		$("#pageloading").hide(); 
		function f_onSucess(data,grid)
		{
			$("#pageloading").hide(); 
			//alert("加载完成");
		}
		function f_onError(req,status,e)
		{
			alert(status);
			
			alert(req);
			alert(e);
		}
		
		function f_onCheckAllRow(checked)
        {
            for (var rowid in this.records)
            {
                if(checked)
                    addCheckedCustomer(this.records[rowid]['tire_id']);
                else
                    removeCheckedCustomer(this.records[rowid]['tire_id']);
            }
        }
 
        /*
        该例子实现 表单分页多选
        即利用onCheckRow将选中的行记忆下来，并利用isChecked将记忆下来的行初始化选中
        */
        var checkedCustomer = [];
        function findCheckedCustomer(userid)
        {
            for(var i =0;i<checkedCustomer.length;i++)
            {
                if(checkedCustomer[i] == userid) return i;
            }
            return -1;
        }
        function addCheckedCustomer(userid)
        {
            if(findCheckedCustomer(userid) == -1)
                checkedCustomer.push(userid);
        }
        function removeCheckedCustomer(userid)
        {
            var i = findCheckedCustomer(userid);
            if(i==-1) return;
            checkedCustomer.splice(i,1);
        }
        function f_isChecked(rowdata)
        {
            if (findCheckedCustomer(rowdata.tire_id) == -1)
                return false;
            return true;
        }
        function f_onCheckRow(checked, data)
        {
            if (checked) addCheckedCustomer(data.tire_id);
            else removeCheckedCustomer(data.tire_id);
        }
        function f_getChecked()
        {
            return(checkedCustomer.join(','));
        }
		
		
		
		function serchpanel() {
            //initSerchForm();
            if ($(".az").css("display") == "none") {
                $("#grid").css("margin-top", $(".az").height() + "px");
                //$("#maingrid4").ligerGetGridManager().onResize();
                //$("#maingrid5").ligerGetGridManager().onResize();
				$(".az").css("display","inline");
				$(".az").css("position","absolute");
				$(".az").css("left","5px");
				$(".az").css("top","5px");
				
				//alert("1");
            } else {
                $("#grid").css("margin-top", "0px");
				$(".az").css("display","none");
				
                //$("#maingrid4").ligerGetGridManager().onResize();
                //$("#maingrid5").ligerGetGridManager().onResize();
				//alert("2");
            }
            $("#company").focus();
        }
		
		
        function f_save() {
            /*if ($(form1).valid()) {
                var sendtxt = "&cmd=add";
				if(comparam!="" && comparam!=null) {
					sendtxt="&cmd=edit&sensor_id=" + comparam;
				}
                var param=$("form :input").fieldSerialize() + sendtxt;				
				return param;
				
				
            }else{
				//alert("valid");
			}*/
			var q=f_getChecked();
			if(q==""){
				top.$.ligerDialog.error('未选择轮胎！');	
				
			}else{
				var sparam="&cmd=add&store_id="+comparam+"&tire_list="+q;
				return sparam;
			}
			
			
        }
        var a; var b; var c; var d; var e; var f; var g; var h; var i;
        function remote() {
            //var url = "CRM_Customer.validate.xhd?T_cid=" + getparastr("cid") + "&rnd=" + Math.random();
            //return url;
			return "";
        }
    </script>
</head>
<body>
<body style="margin-top:0px">
 <div id="message" style="width:700px"></div>
<div class="l-loading" style="display:block" id="pageloading"></div> 
  <form id="form1" onsubmit=" return false ">
    
	<div id="grid">
		<div id="maingrid4" style="margin:-1px"></div>
		<!--<div id="toolbar1"></div>-->		
	</div>
  </form>
  <div class="az" style="display:none;">
        <form id='serchform'>
            <table style='width: 960px' class="bodytable1">
                <tr>
                    <td style='width:200px'>
                        <div style='float: left; text-align: right; width: 60px;'>轮胎编码：</div>
						<div style='float: left;'>
						<input type='text' id='factory_code' name='factory_code' ltype='text' ligerui='{width:120}' />
						</div>
                    </td>
					<td style='width:300px'>
						<div style="text-align: left; float: left;display:inline;"></div>
                        <div style='float: left; text-align: left; width: 80px;display:inline;'>传感器编码：</div>
						<div style='float: left;text-align: left;display:inline;'>
						<input type='text' id='sensor_no' name='sensor_no' ltype='text' ligerui='{width:120}' />
						</div>
                    </td>
                    <td style='align:left'>
                        <input  id='Button2' type='button' value='重置' style='height: 24px; width: 80px;'
                            onclick=" doclear() " />						
                        <input  id='Button1' type='button' value='搜索' style='height: 24px; width: 80px;' onclick=" doserch() " />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    
</body>
</html>
