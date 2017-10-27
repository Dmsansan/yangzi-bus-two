<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>车辆维护</title>
<link href="../lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />
<link href="../lib/ligerUI/skins/ext/css/ligerui-fix.css" rel="stylesheet" type="text/css" />
<link href="../css/input.css" rel="stylesheet" />
<script src="../lib/jquery/jquery-1.9.0.min.js" type="text/javascript"></script> 
<script src="../lib/json2.js" type="text/javascript"></script>
<script src="../lib/ligerUI/js/core/base.js" type="text/javascript"></script>   
<script src="../lib/ligerUI/js/core/inject.js" type="text/javascript"></script>   
<script src="../lib/ligerUI/js/ligerui.all.js" type="text/javascript"></script>        
<script src="../lib/ligerUI/js/plugins/ligerGrid.js" type="text/javascript"></script>
<script src="../lib/ligerUI/js/plugins/ligerDateEditor.js" type="text/javascript"></script> 
<script src="../lib/ligerUI/js/plugins/ligerLayout.js" type="text/javascript"> </script> 
<script src="../js/XHD.js" type="text/javascript"> </script>
<script src="../lib/jquery.form.js" type="text/javascript"> </script>
<script src="../CheckOper.php" type="text/javascript"> </script>
</head>

 <script type="text/javascript">
	var manager;
	var manager2;
	var menu;
	function EditRow()
	{
		var row = manager.getSelectedRow();
            if (!row) { alert('请选择行'); return; }
			alert(row.userid);
            alert(JSON.stringify(row));  //这里只有一条记录，打开编缉的页面编辑吧
	}
	
	 function trim(str){ //删除左右两端的空格
　　     return str.replace(/(^\s*)|(\s*$)/g, "");
　　 }
　　 function ltrim(str){ //删除左边的空格
　　     return str.replace(/(^\s*)/g,"");
　　 }
　　 function rtrim(str){ //删除右边的空格
　　     return str.replace(/(\s*$)/g,"");
　　 }

	function removeTire()
	{
		var row=manager.getSelectedRow();
		var rowt=manager2.getSelectedRow();
		if(rowt&&row){
		 $.ligerDialog.confirm("确定卸载该轮胎？", function (yes) {
                    if (yes) {
                        $.ajax({
                            url: "../ajaction/v1/?menuid=121011&cmd=removeTire", type: "POST",
                            data: { plate_no: row.plate_no,tire_id:rowt.tire_id, rnd: Math.random() },
                            success: function (responseText) {								
								//
								responseText=trim(responseText);
								//top.$.ligerDialog.error(responseText);
								if(typeof(responseText)=="undefined" || responseText=="" || responseText==null){
										//服务器没有数据反回
										top.$.ligerDialog.error("未知错误");
								}else{
									var dataObj = eval("("+responseText+")");
									//alert(JSON2.stringify(dataObj));
									if (dataObj.status == "OK") {
										f_reload2();
									}
									else {
										top.$.ligerDialog.error(dataObj.reason);
									}
								}
                            },
                            error: function () {
                                top.$.ligerDialog.error('删除失败!');
                            }
                        });
                    }
                })
            }
            else {
                $.ligerDialog.warn("请选择记录");
            }
	}
	function deleteRow()
       { 
            //manager.deleteSelectedRow();
			//f_getChecked();
			
			var row=manager.getSelectedRow();
			if (row) {
                $.ligerDialog.confirm("记录删除无法恢复，确定删除？", function (yes) {
                    if (yes) {
                        $.ajax({
                            url: "../ajaction/v1/?menuid=121010&cmd=del", type: "POST",
                            data: { plate_no: row.plate_no, rnd: Math.random() },
                            success: function (responseText) {								
								//
								responseText=trim(responseText);
								//top.$.ligerDialog.error(responseText);
								if(typeof(responseText)=="undefined" || responseText=="" || responseText==null){
										//服务器没有数据反回
										top.$.ligerDialog.error("未知错误");
								}else{
									var dataObj = eval("("+responseText+")");
									//alert(JSON2.stringify(dataObj));
									if (dataObj.status == "OK") {
										f_reload();
									}
									else {
										top.$.ligerDialog.error(dataObj.reason);
									}
								}
                            },
                            error: function () {
                                top.$.ligerDialog.error('删除失败!');
                            }
                        });
                    }
                })
            }
            else {
                $.ligerDialog.warn("请选择记录");
            }
			
			
       }
	   
	   //编缉
	   function edit() {
            //var manager = $("#maingrid4").ligerGetGridManager();
            var row = manager.getSelectedRow();
            if (row) {
                f_openWindow('module_12/sys.bus_add.php?r_plate_no=' +encodeURI(row.plate_no), "修改记录", 780, 490, f_save);
            } else {
                $.ligerDialog.warn('请选择行！');
            }
        }
	
 		      //工具条事件
		function itemclick(item) {
			switch (item.id) {
				case "add":
                  //var selected = grid.getSelected();
                  //if (!selected) { LG.tip('请选择行!'); return }
                  //alert("增加");
				   f_openWindow("module_12/sys.bus_add.php", "新增车辆", 780, 300, f_save);
                  break;
				case "addtire":
					//安装轮胎
					{
						var row=manager.getSelectedRow();
						if(!row){
							$.ligerDialog.warn("请选择车辆");
							break;
						}
						f_openWindow("module_12/sys.bustire_add.php?r_plate_no="+encodeURI(row.plate_no), "安装轮胎", 400, 300, f_savetire);
					}  
					
					     
					break;
				case "removetire":
					{
						//移除轮胎
						removeTire();
					}
					break;
				case "clearbtn":
					deleteRow();
                  //var selected = grid.getSelected();
                  //if (!selected) { LG.tip('请选择行!'); return }
                  //top.f_addTab(null, '查看', 'watch.aspx?No=1');  // 增加新标签，并打开新页
                  //alert("查看");
				  break;
				case "edit":
					//修改
					edit();
					break;
				case "searchbtn":
					serchpanel();
                  break;
 
          }
      }
		//处理保存
	    function f_save(item, dialog) {
            var issave = dialog.frame.f_save();
            if (issave!="") {
                				
				$.ajax({
                    url: "../ajaction/v1/?menuid=121010",
                    type: "POST",
                    data: issave,					
                    beforesend: function () {
                        top.$.ligerDialog.waitting('数据保存中,请稍候...');
                    },
                    success: function (responseText) {
                        //return "ok";
						top.$.ligerDialog.closeWaitting();
						responseText=$.trim(responseText);
			
						if(typeof(responseText)=="undefined" || responseText=="" || responseText==null){
						//服务器没有数据反回
							top.$.ligerDialog.error("未知错误");
							//f_error();
						}else{
							var dataObj = eval("("+responseText+")");
									
							if (dataObj.status == "OK") {
									dialog.close();
									f_reload();
							}else {
								top.$.ligerDialog.error(dataObj.reason);
								//f_error();
							}
						}
                    },
                    error: function () {
                        top.$.ligerDialog.error('操作失败！');
                    },
                    complete: function () {
                        top.$.ligerDialog.closeWaitting();
                    }
                });
            }
        }
		
		
		function f_savetire(item, dialog) {
            var issave = dialog.frame.f_save();
            if (issave!="") {
                				
				$.ajax({
                    url: "../ajaction/v1/?menuid=121011",
                    type: "POST",
                    data: issave,					
                    beforesend: function () {
                        top.$.ligerDialog.waitting('数据保存中,请稍候...');
                    },
                    success: function (responseText) {
                        //return "ok";
						top.$.ligerDialog.closeWaitting();
						responseText=$.trim(responseText);
			
						if(typeof(responseText)=="undefined" || responseText=="" || responseText==null){
						//服务器没有数据反回
							top.$.ligerDialog.error("未知错误");
							//f_error();
						}else{
							var dataObj = eval("("+responseText+")");
									
							if (dataObj.status == "OK") {
									dialog.close();
									f_reload2();
							}else {
								top.$.ligerDialog.error(dataObj.reason);
								//f_error();
							}
						}
                    },
                    error: function () {
                        top.$.ligerDialog.error('操作失败！');
                    },
                    complete: function () {
                        top.$.ligerDialog.closeWaitting();
                    }
                });
            }
        }
	  
	  function f_reload() {
            var manager = $("#maingrid4").ligerGetGridManager();
            manager.loadData(true);
        };
		
		function f_reload2() {
            var manager2 = $("#maingrid2").ligerGetGridManager();
            manager2.loadData(true);
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
			manager.set({url:'../ajaction/v1/?menuid=121010&cmd=qry&'+serchtxt});
			//manager.loadData(true);
		
        }
	
		function toolbar() {
				//这里需要改成根据用户权限来获取
                var toolbarOptions = {
          				items: [
            		{ text:'增加',id:'add', click:itemclick,img:"../lib/ligerUI/skins/icons/add.gif" ,disable:CheckOper("添加")},
            		{ line:true},
					{ text:'编缉',id:'edit',click:itemclick,img:"../lib/ligerUI/skins/icons/edit.gif",disable:CheckOper("修改") },
            		{ line:true},
            		{ text:'删除',id:'clearbtn',click:itemclick,img:"../lib/ligerUI/skins/icons/candle.gif",disable:CheckOper("删除") },
					{ line:true},
					{ text:'查询',id:'searchbtn',click:itemclick,img:"../lib/ligerUI/skins/icons/search.gif" },
					]};
				$("#toolbar").ligerToolBar({items: toolbarOptions.items});
				menu = $.ligerMenu({ width: 120, items:toolbarOptions.items});         

           }
		   
		   
		function toolbar2() {
				//这里需要改成根据用户权限来获取
                var toolbarOptions = {
          				items: [
            		{ text:'安装轮胎',id:'addtire', click:itemclick,img:"../lib/ligerUI/skins/icons/add.gif",disable:CheckOper("添加") },
            		{ line:true},
					{ text:'卸载轮胎',id:'removetire',click:itemclick,img:"../lib/ligerUI/skins/icons/edit.gif",disable:CheckOper("删除") },
            		{ line:true}            		
					]};
				$("#toolbar2").ligerToolBar({items: toolbarOptions.items});
				menu = $.ligerMenu({ width: 120, items:toolbarOptions.items});         

           }
 		
        $(function () {
				
				  
                //$("#grid").height(document.documentElement.clientHeight - $(".toolbar").height());
				 $("#layout1").ligerLayout({ leftWidth: 400});
				$('form').ligerForm();
				$('form2').ligerForm();
				
				toolbar();
				toolbar2();
				
				//
				serchpanel();
				  
				  
			/*
			
			*/	  
            
            manager=$("#maingrid4").ligerGrid({
                checkbox: false,
                columns: [				
                { display: '车牌号码', name:'plate_no', align: 'left', width: 100 },
                { display: '车载编号', name:'v_term_no', width:150,isSort:false },
				{ display: '备注', name:'remark', width: 150,align:'left' }
								
				], pageSize:10,
                url:'../ajaction/v1/?menuid=121010&cmd=qry&t=1',
				/*url:'../ajaction/sysaction/sys.bus_manage_show.php',*/
                /*toolbar:toolbarOptions,*/
                width: '100%',height:'97%',
				dataAction: 'server', //服务器排序
                usePager: true,       //服务器分页
				onSuccess:f_onSucess,
				onError:f_onError,
				onSelectRow:f_onSelectRow,
				allowUnSelectRow:true,
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
			
			
			manager2=$("#maingrid2").ligerGrid({
                checkbox: false,
                columns: [
                { display: '胎位', name:'place', align: 'left', width: 60,isSort:true },              
				{ display: '传感器编号', name:'sensor_no', width: 150,align:'left' },
				{ display: '胎号',name:'factory_code',width: 120,align:'left'},
				{ display: '品牌',name:'brand_name',width: 100,align:'left'},
				{ display: '规格/层级/花纹',name:'norms',width: 200,align:'left',
					render: function (row,rowindex, value, column) { 					
							
							return "<div style='text-align: center'>"+row.norms_name+"/"+row.class_name+"/"+row.figure_name+"</div>";
							
							//var html = row.overflow_temp<?php echo $i;?> <=0 ? row.temp<?php echo $i;?>: "<span style='color:red'>"+row.temp<?php echo $i;?>+"</span>";  
							//return html;
						}	
				
				},
				{ display: '速度上限',name:'speed_ul',width: 100,align:'left'},
				{ display: '温度上限',name:'temp_ul',width: 100,align:'left'},
				{ display: '胎压上限',name:'pressure_ul',width: 100,align:'left'},
				{ display: '胎压下限',name:'pressure_ll',width: 100,align:'left'}				
				], pageSize:10,
                /*url:'../ajaction/v1/?menuid=111110&cmd=qry&t=1',*/
				/*url:'../ajaction/sysaction/sys.roles_grid_show.php?a=3',*/
                /*toolbar:toolbarOptions,*/
                width: '100%',height:'97%',
				dataAction: 'server', //服务器排序
                usePager: true,       //服务器分页
				onSuccess:f_onSucess,
				onError:f_onError,
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
		}
		function f_onSelectRow(rowdata, rowid, rowobj)
		{
			//alert("选择了行");
			//alert(rowdata.plate_no);
			//manager2.changePage("first");
			$('.pcontrol input', manager2.toolbar).val(1);
			manager2.changePage('input');
			manager2.set({url:'../ajaction/v1/?menuid=121011&cmd=qry&plate_no='+encodeURI(rowdata.plate_no)});
			//manager2.page=1;
			//manager2.loadData(true);
			
			
		}
		function f_onError(req,status,e)
		{
			var s=status+" : "+req.status+","+req.statusText;
			alert(s);
		}
		
		//表单搜索
		 function initSerchForm() {
            //$('#title').ligerComboBox({ width: 97, emptyText: '（空）'});         
            $("#bdate").ligerDateEditor({ showTime: false, labelWidth: 100, labelAlign: 'left' });
			$("#edate").ligerDateEditor({ showTime: false, labelWidth: 100, labelAlign: 'left' });
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
 <!--<div id="message" style="width:800px"></div>-->


 <div id="layout1">
   <div position="left" title="车辆列表">
<div class="l-loading" style="display:block" id="pageloading"></div> 
    <div id="toolbar" ></div>	
	<div id="grid">
		<div id="maingrid4" style="margin:-1px"></div>
		<!--<div id="toolbar1"></div>-->		
	</div>
  <div class="az">
        <form id='serchform'>
            <table style='width: 960px' class="bodytable1">
                <tr>
                    <td style='width:200px'>
                        <div style='float: left; text-align: right; width: 60px;'>车牌号码：</div>
						<div style='float: left;'>
						<input type='text' id='plate_no' name='plate_no' ltype='text' ligerui='{width:120}' />
						</div>
                    </td>					
				</tr>
				<tr height='5'>
				</tr>
				<tr>
					<td style='width:200px'>
                        <div style='float: left; text-align: right; width: 60px;'>日期从：</div>
						<div style='float: left;'>
						<input type='text' id='bdate' name='bdate'  ligerui='{width:120}' />
						</div>
						<div style='float: left; text-align: right; width: 60px;'>到：</div>
						<div style='float: left;'>
						<input type='text' id='edate' name='edate'  ligerui='{width:120}' />
						</div>
                    </td>
				</tr>
				<tr height='5'>
				</tr>
				<tr>
                    <td colspan=2 style='align:center'>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input  id='Button2' type='button' value='重置' style='height: 24px; width: 80px;'
                            onclick=" doclear() " />						
                        <input  id='Button1' type='button' value='搜索' style='height: 24px; width: 80px;' onclick=" doserch() " />
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>	
<div position="center" title="轮胎列表">

<div class="l-loading" style="display:none" id="pageloading2"></div> 
    <div id="toolbar2" ></div>	
	<div id="grid2">
		<div id="maingrid2" style="margin:-1px"></div>
		<!--<div id="toolbar1"></div>-->		
	</div>


</div>  
</div> 
  <div style="display:none;">
</div>

</body>
</html>
