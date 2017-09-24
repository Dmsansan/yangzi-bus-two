<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>车辆及轮胎告警历史</title>
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
			manager.set({url:'../ajaction/v1/?menuid=131112&cmd=qry&'+serchtxt});
			//131110
			//manager.loadData(true);
        }
		/*
		function toolbar() {
				//这里需要改成根据用户权限来获取
                var toolbarOptions = {
          				items: [
            		{ text:'增加',id:'add', click:itemclick,img:"../lib/ligerUI/skins/icons/add.gif" },
            		{ line:true},
					{ text:'编缉',id:'edit',click:itemclick,img:"../lib/ligerUI/skins/icons/edit.gif" },
            		{ line:true},            		
					{ text:'查询',id:'searchbtn',click:itemclick,img:"../lib/ligerUI/skins/icons/search.gif" },
					]};
				$("#toolbar").ligerToolBar({items: toolbarOptions.items});
				menu = $.ligerMenu({ width: 120, items:toolbarOptions.items});         

           }
 		*/
        $(function () {
				
				  
                //$("#grid").height(document.documentElement.clientHeight - $(".toolbar").height());
				$('form').ligerForm();
				//toolbar();
				//
				serchpanel();
			/*
			时间
车辆编号
轮胎号位
车载控制器编号
轮胎胎号
轮胎压力
压力阀值
轮胎温度
温度上限
			*/	  
            
            manager=$("#maingrid4").ligerGrid({
                checkbox: false,
                columns: [{display: '时间', name: 'Time',align:'left',width:160},
				{display: '车牌号码', name: 'Plate_No',align:'left',width:80},
				{display: '轮胎号位', name: 'place_no',align:'left',width:80,render:function(row,rowindex,value,column){
				
						return gettirename(Number(row.place_no));
						
					}
				},
				{display: '车载控制器编号', name: 'sensor_no',align:'left',width:120},
				{display: '轮胎胎号', name: 'tire_no',align:'left',width:80},
				{display: '轮胎压力(Kg)', name: 'pressure_val',align:'left',width:80},
				{display: '压力阀值(Kg)', name: 'pressure',align:'left',width:80},
				/*{display: '轮胎温度', name: 'temp_val',align:'left',width:80},
				{display: '温度上限', name: 'temp_ul',align:'left',width:80},
				*/
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
			alert(status);
			
			alert(req);
			alert(e);
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
                 { display: '车队编号', name:'store_id', align: 'left', width: 60 },
                { display: '车队代码', name:'store_no', width:150 },
				{ display: '名称', name:'store_name', width: 100 },
				{ display: '联系人',name:'contact',width: 100},
				{ display: '联系电话',name:'tel',width: 100},
				{ display: '手机号',name:'mobile',width: 100},
				{ display: '详址',name:'address',width: 100}
                 ], switchPageSizeApplyComboBox: false,
                 /*data: $.extend({}, CustomersData),*/
				 url:'../ajaction/v1/?menuid=101110&cmd=qry&t=1',
                 pageSize: 10,
				 dataAction:'server',
				 allowUnSelectRow:true,
				 checkbox:true
				
             };
             return options;
         }		
		//表单搜索
		 function initSerchForm() {
            //$('#title').ligerComboBox({ width: 97, emptyText: '（空）'});         
            $("#begin_date").ligerDateEditor({ showTime: false, labelWidth: 100, labelAlign: 'left' });
			$("#end_date").ligerDateEditor({ showTime: false, labelWidth: 100, labelAlign: 'left' });
			$("#store_list").ligerPopupEdit({
             condition: {
                 prefixID:'store_list',
                 fields: [{name:'store_name',type:'text',label:'车队名'}],
				 
             },
			 split:',',
             grid: getGridOptions(true),
				valueField: 'store_id',
				textField: 'store_name',
				width: 100,
				searchClick:function(obj){
					/*
						obj 
						grid: grid,
                        rules: rules   {"op":"like","field":"plate_no","value":"苏1","type":"text"}
					*/
					var s="";
					for(var i=0;i<obj.rules.length;i++){
						s=s+obj.rules[i].field+"="+obj.rules[i].value;
					}
					if(s!="") s="&"+s;
					obj.grid.set({url:'../ajaction/v1/?menuid=101110&cmd=qry&t=1'+s});
					obj.grid.loadData(true);
					
				},
				dlgWidth:400,
				dlgHeight:300,
				onSelect:function(x){
										
				}
			});
			
			

		
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
				$(".az").css("top","0px");
				
				//alert("1");
            } else {
                $("#grid").css("margin-top", "0px");
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
                        <div style='float: left; text-align: left; width: 60px;'>车队：</div>
					</td>
					<td>
						<div style='float: left;'>
						<!--<input type='text' id='plate_no' name='plate_no'  ligerui='{width:120}' />-->
						<input id="store_list"  name='store_list' type="text" readonly="" style="width: 120px;" validate="{required:true}"  />
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

  <div style="display:none;">
  
</div>

</body>
</html>
