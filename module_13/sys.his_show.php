<html xmlns="http://www.w3.org/1999/xhtml">
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
            manager.loadData(true);
        };
		
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
			manager.set({url:'../ajaction/v1/?menuid=131110&cmd=qry&'+serchtxt});
			//131110
			//manager.loadData(true);
        }
		function doexport() {
            var sendtxt = "&rnd=" + Math.random();
            var serchtxt = $("#serchform :input").fieldSerialize() + sendtxt;
			//$('.pcontrol input', manager.toolbar).val(1);
			//manager.changePage('input');
			//manager.set({url:'../ajaction/v1/?menuid=131110&cmd=qry&'+serchtxt});
			//131110
			//manager.loadData(true);
			
			window.open("../ajaction/v1/?menuid=131110&cmd=exp&"+serchtxt);
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
 		
        $(function () {
				
				  
                //$("#grid").height(document.documentElement.clientHeight - $(".toolbar").height());
				$('form').ligerForm();
				toolbar();
				//
				serchpanel();
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
                columns: [{display: '时间', name: 'Time',align:'left',width:160},
				{display: '车牌号码', name: 'Plate_No',align:'left',width:80},
				{display: '速度', name: 'speed',align:'left',width:80,
					/*render: function (row,rowindex, value, column) {  
						//alert(column);
						
						if(typeof(row.overflow_speed)=="undefined"){
							return "<div style='text-align: center'>-</div>";
						}
						var html = row.overflow_speed <=0 ? row.speed: "<span style='color:red'>"+row.speed+"</span>";  
						return html;
					}*/  
				},
				{display: '累计里程(Km)', name: 'mile_count',align:'left',width:80},
                <?php
					$i=1;
					for($i;$i<=6;$i++){
				?>
                { display: gettirename(<?php echo $i;?>), columns:
                [
                    { display: '压力(Kg)', name: 'pressure<?php echo $i;?>', align: 'left', width: 60 ,
						render: function (row,rowindex, value, column) {  
						
							if(typeof(row.overflow_pressure<?php echo $i;?>)=="undefined"){
								return "<div style='text-align: center'>-</div>";
							}
							var html = row.overflow_pressure<?php echo $i;?> <=0 ? row.pressure<?php echo $i;?>: "<span style='color:red'>"+row.pressure<?php echo $i;?>+"</span>";  
							return html;
						}
					}, 
                    { display: '温度(℃)', name: 'temp<?php echo $i;?>', width: 60, align: 'left',
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
                ], pageSize:10,
                /*url:'../ajaction/v1/?menuid=131010&cmd=qry&t=1',*/
				/*url:'../ajaction/sysaction/sys.roles_grid_show.php?a=3',*/
                /*toolbar:toolbarOptions,*/
                width: '100%',height:'97%',
				dataAction: 'server', //服务器排序
                usePager: true,       //服务器分页
				onSuccess:f_onSucess,
				onError:f_onError,
				isChecked: f_isChecked, 
				/*
				onCheckRow: f_onCheckRow, 
				onCheckAllRow: f_onCheckAllRow,*/
				onContextmenu : function (parm,e)
                {
                    //actionCustomerID = parm.data.CustomerID;
                    menu.show({ top: e.pageY, left: e.pageX });
                    return false;
                }
            });
			
            
        });
		$("#pageloading").hide(); 
		function f_onSucess(data,grid)
		{
			$("#pageloading").hide(); 
			//alert("加载完成");
		}
		function f_onError(req,status,e)
		{
			var s=status+" : "+req.status+","+req.statusText;
			alert(s);
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
		function getGridOptions(checkbox) {
             var options = {
                 columns: [
                 { display: '车牌号码', name: 'plate_no', align: 'left', width: 100, minWidth: 60 },
                 { display: '车载编码', name: 'v_term_no', minWidth: 120, width: 100 },								 
                 ], switchPageSizeApplyComboBox: false,
                 /*data: $.extend({}, CustomersData),*/
				 url:'../ajaction/v1/?menuid=121010&cmd=qry&t=1',
                 pageSize: 10,
				 dataAction:'server'
				
             };
             return options;
         }

		
		//表单搜索
		 function initSerchForm() {
            //$('#title').ligerComboBox({ width: 97, emptyText: '（空）'});         
            $("#begin_date").ligerDateEditor({ showTime: false, labelWidth: 100, labelAlign: 'left' });
			$("#end_date").ligerDateEditor({ showTime: false, labelWidth: 100, labelAlign: 'left' });
			com_place=$("#place_no").ligerComboBox({
						width:196,
						valueField:'id',
						textField:'name',
						/*data:obj,
						url: "../ajaction/sysaction/get_all_roles.php?rnd=" + Math.random(),*/
						isMultiSelect: false 					
			
			});
			 $("#plate_no").ligerPopupEdit({
             condition: {
                 prefixID:'plate_no',
                 fields: [{name:'plate_no',type:'text',label:'车牌号'}],
				 
             },
             grid: getGridOptions(true),
				valueField: 'bus_id',
				textField: 'plate_no',
				width: 100,
				searchClick:function(obj){
					/*
						obj 
						grid: grid,
                        rules: rules   {"op":"like","field":"plate_no","value":"苏1","type":"text"}
					*/
					var s="";
					for(var i=0;i<obj.rules.length;i++){
						s=s+obj.rules[i].field+"="+encodeURI(obj.rules[i].value);
					}
					if(s!="") s="&"+s;
					$('.pcontrol input', obj.grid.toolbar).val(1);
					obj.grid.changePage('input');
					obj.grid.set({url:'../ajaction/v1/?menuid=121010&cmd=qry&t=1'+s});
					obj.grid.loadData(true);
					
				},
				dlgWidth:400,
				dlgHeight:300,
				onSelect:function(x){
					//按了选择按钮
					/*
					value: value.join(p.split),
                text: text.join(p.split),
                data: data,
					*/
					
					if(x.data.length==1){
						//alert(x.data.length);
						//alert(x.data[0].wheel_count);  //选择了这个ID ,这个车子轮数
						var data=[{'id':0,'name':'所有'}];
						for(var i=1;i<=x.data[0].wheel_count;i++){
							data.push({'id':i,'name':gettirename(i)});
						}
						com_place.setData(data);
						com_place.selectValue(0);  //默认选中0
					}
				}
			});
			
			
			

		
		}
		
		
		
		
		function serchpanel() {
            initSerchForm();
            if ($(".az").css("display") == "none") {
                $("#grid").css("margin-top", $(".az").height()+ "px");
                //$("#maingrid4").ligerGetGridManager().onResize();
                //$("#maingrid5").ligerGetGridManager().onResize();
				$(".az").css("display","inline");
				$(".az").css("position","absolute");
				$(".az").css("left","5px");
				$(".az").css("top","20px");
				
				//alert("1");
            } else {
                $("#grid").css("margin-top", "20px");
				$(".az").css("display","none");
				
                //$("#maingrid4").ligerGetGridManager().onResize();
                //$("#maingrid5").ligerGetGridManager().onResize();
				//alert("2");
            }
            //$("#company").focus();
        }		
		//serchpanel();
    </script>

<body style="margin-top:0px">
 <div id="message" style="width:800px"></div>
<div class="l-loading" style="display:none" id="pageloading"></div> 
    <div id="toolbar" ></div>	
	<div id="grid">
		<div id="maingrid4" style="margin:0px"></div>
		<!--<div id="toolbar1"></div>-->		
	</div>
  <div class="az" style="display:none;">
        <form id='serchform'>
            <table style='width: 960px' class="bodytable1">
                <tr>
                    <td>
                        <div style='float: left; text-align: left; width: 60px;'>起始日期：</div>
					</td>
					<td>
						<div style='float: left;'>
						<input type='text' id='begin_date' name='begin_date'  ligerui='{width:120}' />
						</div>
                    </td>
					<td>
                        <div style='float: left; text-align: left; width: 60px;'>终止日期：</div>
					</td>
					<td>
						<div style='float: left;'>
						<input type='text' id='end_date' name='end_date'  ligerui='{width:120}' />
						</div>
                    </td>
					<td>
                        <div style='float: left; text-align: left; width: 60px;'>车辆号码：</div>
					</td>
					<td>
						<div style='float: left;'>
						<!--<input type='text' id='plate_no' name='plate_no'  ligerui='{width:120}' />-->
						<input id="plate_no"  type="text" readonly="" style="width: 120px;"  />
						</div>
                    </td>
					<td>
                        <div style='float: left; text-align: left; width: 60px;'>轮胎号位：</div>
					</td>
					<td>					
						<input type='text' id='place_no' name='place_no'  ligerui='{width:120}' style="display:none"  />						
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

  <div style="display:none;">
  
</div>

</body>
</html>
