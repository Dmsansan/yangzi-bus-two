<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>车辆及轮胎实时状态</title>
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
<script src="../lib/ligerUI/js/plugins/ligerDateEditor.js" type="text/javascript"></script>
<script src="../lib/ligerUI/js/plugins/ligerPopupEdit.js" type="text/javascript"></script>
<script src="../lib/ligerUI/js/plugins/ligerComboBox.js" type="text/javascript"></script>

<script src="../js/XHD.js" type="text/javascript"> </script>
<script src="../lib/jquery.form.js" type="text/javascript"> </script>
</head>

 <script type="text/javascript">
	var manager;
	var menu;
	var com_store;
	var tout;
	var plate_no;
	var selectRow;
	
	
	 function trim(str){ //删除左右两端的空格
　　     return str.replace(/(^\s*)|(\s*$)/g, "");
　　 }
　　 function ltrim(str){ //删除左边的空格
　　     return str.replace(/(^\s*)/g,"");
　　 }
　　 function rtrim(str){ //删除右边的空格
　　     return str.replace(/(\s*$)/g,"");
　　 }

 		      //工具条事件
		function itemclick(item) {
			switch (item.id) {
				case "searchbtn":
					serchpanel();
					break;
				case "exp":
					doexport();
                  break;
          }
      }
	  function f_reload() {
            var manager = $("#maingrid4").ligerGetGridManager();			
            manager.set({url:'../ajaction/v1/?menuid=131010&cmd=qry&t=1&store_id='+com_store.getValue()});
			//manager.loadData(true);
        };
		
		function doclear() {
            $("input:hidden", "#serchform").val("");
            $("input:text", "#serchform").val("");
            $(".l-selected").removeClass("l-selected");
        }
		function doexport(){
				var sendtxt = "&rnd=" + Math.random();
				var serchtxt = $("#serchform :input").fieldSerialize() + sendtxt;
				window.open("../ajaction/v1/?menuid=131010&cmd=exp&"+serchtxt);
		}
		function doserch() {
            var sendtxt = "&rnd=" + Math.random();
            var serchtxt = $("#serchform :input").fieldSerialize() + sendtxt;
			$('.pcontrol input', manager.toolbar).val(1);
			manager.changePage('input');
			manager.set({url:'../ajaction/v1/?menuid=131010&cmd=qry&'+serchtxt});
			manager.loadData(true);
        }
		
		function toolbar() {
				//这里需要改成根据用户权限来获取
                var toolbarOptions = {
          				items: [
            		{ text:'导出',id:'exp', click:itemclick,img:"../lib/ligerUI/skins/icons/save.gif" },
            						
					]};
				$("#toolbar").ligerToolBar({items: toolbarOptions.items});
				//menu = $.ligerMenu({ width: 120, items:toolbarOptions.items});         

           }
		   
		function showMessage(id){
			if(id){
				$('#dialog').show();
			 $('#tablemessage').ligerGrid({ 
			  pageSize:200, 
				url:'../ajaction/v1/?menuid=131010&cmd=qrytire&plate_no='+id,
				dataAction: 'server', //服务器排序
                usePager: true,       //服务器分页
				onSuccess:function(data,grid){
					console.log('data',data);
				},
				onError:f_Error
			
			})
			}		
		}
		function f_save(item, dialog) {
			
		}
 		
        $(function () {
				$('#sure').on('click',function(){
					$('#dialog').show();
				});
				$('#test').on('click',function(){
					$('#dialog').hide();
				})
				  
                //$("#grid").height(document.documentElement.clientHeight - $(".toolbar").height());
				$('form').ligerForm();
				toolbar();
				//
				serchpanel();
				
				com_store=$("#store_id").ligerComboBox({
						width:196,
						valueField:'store_id',
						textField:'store_name',
						/*data:obj,
						url: "../ajaction/sysaction/get_all_roles.php?rnd=" + Math.random(),*/
						isMultiSelect: false ,
						onSelected:function(value,text){
							//选择了车队
							clearTimeout(tout);
							f_reload();
							
						}
				});
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
					obj.items.unshift({"store_id":"0","store_name":"所有"});
					com_store.setData(obj.items);
					//com_store.selectValue("0");
					
					
				},
				error:function(){
					//alert("获取车队列表");
				}
				
				
			});
				
				
				
			/*
			tire_param_id	int auto_increment,
	company_name	varchar(40)			comment '制造商',
	brand_id		int 				comment '品牌ID',
	norms_id		int 				comment '规格ID',
	class_id        int   				comment '层级ID',
	figure_id		int					comment  '花纹ID',
	pressure_ul     int                 comment '胎压上限',
    pressure_ll     int                 comment '胎压下限',
	temp_ul         int                 comment '温度上限',
	tkph_val		int                 comment 'TKPH值',
	baro_val		int                 comment '标准充气压力',
			*/	  
            
            manager=$("#maingrid4").ligerGrid({
                checkbox: false,
                columns: [{display: '时间', name: 'Time',width:'10%'},
					{display:"信息",name:'info',aligin:'center',width:'5%',render:
						function (row,rowindex, value, column) {
							
							var html="";
							var nalarm=0;
							
							if(row.overflow_pressure1>0 || row.overflow_pressure2>0 || row.overflow_pressure3>0 || row.overflow_pressure4>0 || row.overflow_pressure5>0 || row.overflow_pressure6>0){
								nalarm=1;
							}							
							if(row.overflow_temp1>0 || row.overflow_temp2>0 || row.overflow_temp3>0 || row.overflow_temp4>0 || row.overflow_temp5>0 || row.overflow_temp6>0){
								nalarm=1;
							}	
							if(nalarm>0){
								html="<img src='../images/icon/tips-selected.png' onclick=\"showMessage('"+row.Plate_No+"')\"/>";
								
							}else{
								html="<img src='../images/icon/news_selected.png' onclick=\"showMessage('"+row.Plate_No+"')\"/>";
							}						
							return html;
						}					
					},
				{display: '车牌号码', name: 'Plate_No',width:'14%',type:'string'},
				{display: '累计里程(Km)', name: 'mile_count',width:'10%'},
                <?php
					$i=1;
					for($i;$i<=6;$i++){
				?>
                { display:gettirename(<?php echo $i;?>), columns:
                [
                    { display: '压力(Kg)', name: 'pressure<?php echo $i;?>', width:'5%' ,
						render: function (row,rowindex, value, column) {  
						
							if(typeof(row.overflow_pressure<?php echo $i;?>)=="undefined"){
								return "<div style='text-align: center'>-</div>";
							}
							var html = row.overflow_pressure<?php echo $i;?> <=0 ? row.pressure<?php echo $i;?>: "<span style='color:red'>"+row.pressure<?php echo $i;?>+"</span>";  
							return html;
						}
					}, 
                    { display: '温度(℃)', name: 'temp<?php echo $i;?>', width:'5%',
						render: function (row,rowindex, value, column) {  
						
							if(typeof(row.overflow_temp<?php echo $i;?>)=="undefined"){
								return "<div style='text-align: center'>-</div>";
							}
							var html = row.overflow_temp<?php echo $i;?> <=0 ? row.temp<?php echo $i;?>: "<span style='color:red'>"+row.temp<?php echo $i;?>+"</span>";  
							return html;
						}
					}
                    
                ]
                },
				<?php
					}
				?>
                ], pageSize:200,
                url:'../ajaction/v1/?menuid=131010&cmd=qry&t=1&store_id='+com_store.getValue(),
				/*url:'../ajaction/sysaction/sys.roles_grid_show.php?a=3',*/
                /*toolbar:toolbarOptions,*/
                width: '100%',height:'97%',
				dataAction: 'server', //服务器排序
                usePager: true,       //服务器分页
				onSuccess:f_onSucess,
				onError:f_onError,
				isChecked: f_isChecked, 
				pageStatMessage: '显示从{from}到{to}，总车辆数 {total} 辆 。每页显示：{pagesize}',
				onContextmenu : function (parm,e)
                {
                    //actionCustomerID = parm.data.CustomerID;
                    menu.show({ top: e.pageY, left: e.pageX });
                    return false;
                },
				
            });			
			
		selectRow=$('#tablemessage').ligerGrid({
						checkbox: false,
						columns: [{display: '轮胎编号', name: 'tire_rfid',width:90},
							{display:"轮胎号位",name:'place',aligin:'center',width:50},
							{display: '品牌', name: 'brand_name',width:80},
							{display: '花纹深度(Cm)', name: 'figure_value',width:90},
							{display: '累计里程(Km)', name: 'mile_count',width:80},
							{display: '装胎时间', name: 'fst_place_stamp',width:130},
							{display: '报警次数', name: 'info_7',width:60},
							{display: '是否翻新', name: 'info_8',width:60}           
						],
					
			});
			 $('#left_one').mouseover(function(){
				$('#left_one').attr('src','../css/img/two.png');
				selectgridRow(0);
			});
			$('#left_one').mouseout(function(){
				$('#left_one').attr('src','../css/img/chelun_selectedonetwo.png');
			}) 
			 $('#right_one').mouseover(function(){
				 selectgridRow(1);
				$('#right_one').attr('src','../css/img/two.png');
			});
			$('#right_one').mouseout(function(){
				$('#right_one').attr('src','../css/img/chelun_selectedonetwo.png');
			}) 
			 $('#leftbehint_one').mouseover(function(){
				  selectgridRow(2);
				$('#leftbehint_one').attr('src','../css/img/two.png');
			});
			$('#leftbehint_two').mouseout(function(){
				$('#leftbehint_two').attr('src','../css/img/chelun_selectedonetwo.png');
			}) 
			 $('#leftbehint_two').mouseover(function(){
				  selectgridRow(3);
				$('#leftbehint_two').attr('src','../css/img/two.png');
			});
			$('#leftbehint_one').mouseout(function(){
				$('#leftbehint_one').attr('src','../css/img/chelun_selectedonetwo.png');
			}) 
			 $('#rightbehint_one').mouseover(function(){
				  selectgridRow(4);
				$('#rightbehint_one').attr('src','../css/img/two.png');
			});
			$('#rightbehint_one').mouseout(function(){
				$('#rightbehint_one').attr('src','../css/img/chelun_selectedonetwo.png');
			}) 
			 $('#rightbehint_two').mouseover(function(){
				  selectgridRow(5);
				$('#rightbehint_two').attr('src','../css/img/two.png');
			});
			$('#rightbehint_two').mouseout(function(){
				$('#rightbehint_two').attr('src','../css/img/chelun_selectedonetwo.png');
			}) 
        });
		
		function f_Error(){
			alert(plate_no);
		}
		
		 function f_totalRender(data, currentPageData)
         {
             return "总车辆数:"+data.UnitsInStockTotal; 
         }
		
		
		$("#pageloading").hide(); 
		function f_onSucess(data,grid)
		{
			$("#pageloading").hide(); 
			//alert("加载完成");
			
			tout=setTimeout(f_reload,45000);
			
		}
		function f_onError(req,status,e)
		{
			//alert(status);
			
			//alert(req);
			//alert(e);
			tout=setTimeout(f_reload,45000);
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
function selectgridRow(index){
	selectRow.select(index);
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
		
		
		//表单搜索
		 function initSerchForm() {
            //$('#title').ligerComboBox({ width: 97, emptyText: '（空）'});         
            
        }
		
		function serchpanel() {
            initSerchForm();
            if ($(".az").css("display") == "none") {
                $("#grid").css("margin-top", $(".az").height() + "px");
                //$("#maingrid4").ligerGetGridManager().onResize();
                //$("#maingrid5").ligerGetGridManager().onResize();
				$(".az").css("display","inline");
				$(".az").css("position","absolute");
				$(".az").css("left","5px");
				$(".az").css("top","30px");		
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
		//serchpanel();
    </script>

<body style="margin-top:0px">

 <div id="message" style="width:800px"></div>
<div class="l-loading" style="display:block" id="pageloading"></div> 
    <div id="toolbar" ></div>
	<div style="position: absolute;width:80px;top:15px;left:70px">修理厂:</div>
    <div id="xxcc" style="position: absolute;width:280px;top:2px;left:120px"><input type="text" id="store_id"  name="store_id"/></td></div>	
	<div id="grid">
		<div id="maingrid4" style="margin:0px"></div>
		<!--<div id="toolbar1"></div>-->		
	</div>

  <div class="az">
        <form id='serchform'>
            <table style='width: 960px' class="bodytable1">
                <tr>
                    <td style='width:200px'>
                        <div style='float: left; text-align: right; width: 60px;'>制造商：</div>
						<div style='float: left;'>
						<input type='text' id='company_name' name='company_name' ltype='text' ligerui='{width:120}' />
						</div>
                    </td>					
                    <td style='align:left'>
                        <input  id='Button2' type='button' value='重置' style='height: 24px; width: 80px;outline:none;'
                            onclick=" doclear() " />						
                        <input  id='Button1' type='button' value='搜索' style='height: 24px; width: 80px;outline:none;' onclick=" doserch() " />
                    </td>
                </tr>
            </table>
        </form>
    </div>

  <div style="display:none;">
  
</div>
<div id='dialog' style="width:980px;height:440px;position:absolute;left:5%;top:3%;display:none;">
<div style="height:40px;background:#353c49">
<span style="margin-left:10px;color:#ffffff;line-height:40px;font-size:14px;">车辆信息</span>
<button id="test" style="height:20px;width:20px; background: url('../images/shutdown.png') no-repeat center center;border:none;float:right;margin-right:10px;margin-top:10px;"></button>
</div>
<div style="height:400px;background-color:#bdc4d4;padding:10px">
<div style="height:400px;background-color:#ffffff">

<div style="height: 400px;width: 230px;border-right:8px solid #bdc4d4; float:left">
<div style="height:40px;background-color:#ffffff">
<span style="line-height:40px;margin-left:10px;font-size:14px;">车辆骨架</span>
</div>
<table  style="width:230px;height:340px;background:url('../css/img/chesheng.png') no-repeat center center; ">
        <tr style="height: 68px">

        </tr>
    
    <tr>
        <td style="width:42px"></td>
        <td><img id="left_one" onfocus=this.blur() onclick="selectgridRow(0)" src="../css/img/chelun_selectedonetwo.png"></td>
        <td style="width: 22px;"></td>
        <td style="width: 58px"></td>
        <td style="width: 22px;"></td>
        <td><img id="right_one" onfocus=this.blur() onclick="selectgridRow(1)" src="../css/img/chelun_selectedonetwo.png"></td>
        <td style="width:42px"></td>

    </tr>
    <tr style="height: 167px;"></tr>
    <tr>
        <td style="width:42px"></td>
        <td><img id="leftbehint_one" onfocus=this.blur()  onclick="selectgridRow(2)" src="../css/img/chelun_selectedonetwo.png"></td>
        <td><img id="leftbehint_two" onfocus=this.blur() onclick="selectgridRow(3)" src="../css/img/chelun_selectedonetwo.png"></td>
        <td style="width: 58px"></td>
        <td><img id="rightbehint_one" onfocus=this.blur() onclick="selectgridRow(4)" src="../css/img/chelun_selectedonetwo.png"></td>
        <td><img id="rightbehint_two" onfocus=this.blur() onclick="selectgridRow(5)" src="../css/img/chelun_selectedonetwo.png"></td>
        <td style="width:42px"></td>
    </tr>
    <tr style="height:38px">

    </tr>

</table>


</div>
	<div  style="float:left;background-color:#f1f6fd">
			<div style="height:40px;background-color:#ffffff">
			<span  style="line-height:40px;margin-left:10px;font-size:14px;">轮胎信息</span>
			</div>
	<div id="tablemessage">
	</div>
	</div>
</div>
</div>
<div>

</body>
</html>
