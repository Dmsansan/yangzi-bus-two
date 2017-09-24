<!DOCTYPE html>
<html>
  <head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>轮胎信息</title>
    
	<link href="../lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />
	<link href="../lib/ligerUI/skins/ext/css/ligerui-fix.css" rel="stylesheet" type="text/css" />
	<link href="../css/input.css" rel="stylesheet" />
	<script src="../lib/jquery/jquery-1.9.0.min.js" type="text/javascript"></script> 
	<script src="../lib/json2.js" type="text/javascript"></script>
	<script src="../lib/ligerUI/js/core/base.js" type="text/javascript"></script>   
	<script src="../lib/ligerUI/js/core/inject.js" type="text/javascript"></script>   
	<script src="../lib/ligerUI/js/ligerui.all.js" type="text/javascript"></script>        
	<script src="../lib/ligerUI/js/plugins/ligerGrid.js" type="text/javascript"></script> 
	
	<script src="../lib/ligerUI/js/plugins/ligerLayout.js" type="text/javascript"> </script> 
	<script src="../lib/ligerUI/js/plugins/ligerComboBox.js" type="text/javascript"></script>
	<script src="../lib/ligerUI/js/plugins/ligerCombobox_ex.js" type="text/javascript"></script>
	<script src="../js/XHD.js" type="text/javascript"> </script>
	<script src="../lib/jquery.form.js" type="text/javascript"> </script>
    
  </head>
  <body style="margin-top:0px">
 <div id="layout1">
   <div position="left" title="车辆骨架" >
   <table id="__02" width="276" height="50" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<!--<td align="center">车队: 一车队</td>-->
	</tr>
	<tr>
		<td align="center"><div id="plate_no"></div></td>
	</tr>
	
   </table>
   <table id="__01" width="276" height="295" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td rowspan="2">
			<img src="images/im_01.png" width="46" height="233" alt="" ></td>
		<td>
			<img src="images/im_0.png" width="40" height="59" alt=""  style="cursor:pointer" onclick="SelectTire(0)" onmouseover="this.src='images/im_0_01.png';SelectTire(0)" onmouseout="this.src='images/im_0.png'"></td>
		<td rowspan="3">
			<img src="images/im_03.png" width="103" height="295" alt=""></td>
		<td>
			<img src="images/im_1.png" width="42" height="59" alt="" style="cursor:pointer" onclick="SelectTire(1)" onmouseover="this.src='images/im_1_01.png';SelectTire(1)" onmouseout="this.src='images/im_1.png'"></td>
		<td rowspan="2">
			<img src="images/im_05.png" width="45" height="233" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/im_06.png" width="40" height="174" alt=""></td>
		<td>
			<img src="images/im_07.png" width="42" height="174" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/im_2.png" width="46" height="62" alt="" style="cursor:pointer" onclick="SelectTire(2)" onmouseover="this.src='images/im_2_01.png';SelectTire(2)" onmouseout="this.src='images/im_2.png'"></td>
		<td>
			<img src="images/im_3.png" width="40" height="62" alt="" style="cursor:pointer" onclick="SelectTire(3)" onmouseover="this.src='images/im_3_01.png';SelectTire(3)" onmouseout="this.src='images/im_3.png'"></td>
		<td>
			<img src="images/im_4.png" width="42" height="62" alt="" style="cursor:pointer" onclick="SelectTire(4)" onmouseover="this.src='images/im_4_01.png';SelectTire(4)" onmouseout="this.src='images/im_4.png'"></td>
		<td>
			<img src="images/im_5.png" width="45" height="62" alt="" style="cursor:pointer" onclick="SelectTire(5)" onmouseover="this.src='images/im_5_01.png';SelectTire(5)" onmouseout="this.src='images/im_5.png'"></td>
	</tr>
</table>

   
   
   </div>
   
   <div position="center" title="轮胎信息" >
	<div id="toolbar"></div>
	<div id="maingrid4" style="margin:0px"></div>
	
	</div>
	</div>
</body>

<script type="text/javascript">

var manager;

	comparam=getparastr("r_plate_no");	
	
	function SelectTire(tire)
	{
		manager.select(tire); 
	}

	function resizeLayout()
		{
			var s;
			
			$(".l-layout").css("height","100%");
			$(".l-layout-left").css("height","100%");
			$(".l-layout-center").css("height","100%");
		}
		function toolbar() {
				//这里需要改成根据用户权限来获取
				//{ text:'',type:'text', click:itemclick,img:"../lib/ligerUI/skins/icons/add.gif" },
                var toolbarOptions = {
          				items: [
							{text:'刷新',id:'freshbtn',click:itemclick,img:"../lib/ligerUI/skins/icons/refresh.gif"},
							{line:true}							
					]};
				$("#toolbar").ligerToolBar({items: toolbarOptions.items});
				
		}
		$(function () {
                //$("#grid").height(document.documentElement.clientHeight - $(".toolbar").height());
				$("#layout1").ligerLayout({ leftWidth:290,minLeftWidth:200,onEndResize:function(){
						resizeLayout();
					},onLeftToggle: function (isColl){
						resizeLayout();
					}
				});	
				//$("#plate_no").val("车牌号: "+comparam);
				document.getElementById("plate_no").innerHTML="车牌号: "+urldecode(comparam);
				toolbar();
				
				manager=$("#maingrid4").ligerGrid({
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
                url:'../ajaction/v1/?menuid=131010&cmd=qrytire&plate_no='+comparam,
	            width: '100%',height:'97%',
				dataAction: 'server', //服务器排序
                usePager: true,       //服务器分页
				onSuccess:f_onSucess,
				onError:f_onError,
				isChecked: f_isChecked			
				
            });			
            
		});
		
		
		function f_onSucess(data,grid)
		{
			//$("#pageloading").hide(); 
			//alert("加载完成");
			
			//tout=setTimeout(f_reload,45000);
			
		}
		function f_onError(req,status,e)
		{
			//alert(status);
			
			//alert(req);
			//alert(e);
			//tout=setTimeout(f_reload,45000);
		}
		function f_onCheckAllRow(checked)
        {
            for (var rowid in this.records)
            {
                if(checked)
                    addCheckedCustomer(this.records[rowid]['userid']);
                else
                    removeCheckedCustomer(this.records[rowid]['userid']);
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
            if (findCheckedCustomer(rowdata.userid) == -1)
                return false;
            return true;
        }
        function f_onCheckRow(checked, data)
        {
            if (checked) addCheckedCustomer(data.userid);
            else removeCheckedCustomer(data.userid);
        }
        function f_getChecked()
        {
            alert(checkedCustomer.join(','));
        }
	
	
	 function itemclick(item) {
			switch (item.id) {
				case "freshbtn":
					//刷新
					GetPoint();
				  break;
			
          }
      }
</script>
</html>
