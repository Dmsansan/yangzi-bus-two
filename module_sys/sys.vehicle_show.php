<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车载终端管理</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
    <script type="text/javascript">
        function addUser() {
			
            $('#addUser').dialog('open').dialog('setTitle','增加信息');
        };
        $(function () {
			$('#cancel').bind('click',function(){
				$('#alarm').dialog('close');
			});
			$('#close').bind('click',function(){
				$('#addUser').dialog('close');
			});
			$('#updata_close').bind('click',function(){
				$('#dlg').dialog('close');
			});			
		//加载修理厂全部信息；
			$.ajax({
                url: '../ajaction/v1/?menuid=101110&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    var obj =data.Rows;
                    $("#repairID").combobox("loadData", obj);
                }
            });
		$('#repairID').combobox({
			valueField:'store_id',
			textField:'store_name',
			
		});
        $.ajax({
                url: '../ajaction/v1/?menuid=101110&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    var obj =data.Rows;
                    $("#uprepairID").combobox("loadData", obj);
                }
            });
        $('#uprepairID').combobox({
            valueField:'store_id',
            textField:'store_name',
            
        });

		//加载全部信息；
			$.ajax({
                url: '../ajaction/v1/?menuid=101115&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                   $("#dg").datagrid("loadData", data.Rows);  
                    
                    console.log('data', data);
                }
            });
            //搜索操作
            $('#search').bind('click',function(){
                var v_term_no = $("#search_v_no").val();
                $.ajax({
                    url:'../ajaction/v1/?menuid=101115&cmd=qry',
                    type:"POST",
                    data:{'v_term_no':v_term_no},
                    dataType:'json',
                    success:function(data){
                        $("#dg").datagrid("loadData", data.Rows); 
                    }
                });
            });
			//增加操作
			$('#save').bind('click',function(){
				var v_term_no=$('#vehicleNumber').textbox('getText');
				var v_term_name=$('#vehicleName').textbox('getText');
				//var plate_no=$('#plateNumber').textbox('getText');
				var store_id_val=$('#repairID').combobox('getValue');
				var remark=$('#remark').textbox('getText');
				//console.log('shuju',v_term_no+v_term_name+plate_no+store_id_val+remark);
				$.ajax({
					url:'../ajaction/v1/?menuid=101115&cmd=add	',
					type:'POST',
					data:{'v_term_no':v_term_no,'v_term_name':v_term_name,'store_id_val':store_id_val,'remark':remark},
					success:function(data){
						reload();
						console.log('data',data);
					}
				})
	
				
			});
			//修改操作
			$('#updata_save').bind('click',function(){
				var v_term_no=$('#up_vehicleNumber').textbox('getText');
				var v_term_name=$('#up_vehicleName').textbox('getText');
				//var plate_no=$('#up_plateNumber').textbox('getText');
                var store_id_val=$('#uprepairID').combobox('getValue');
                console.log(store_id_val);
				var remark=$('#up_remark').textbox('getText');
				var v_term_id=$('#up_v_term_id').val();
				$.ajax({
					url:'../ajaction/v1/?menuid=101115&cmd=edit',
					type:'POST',
					data:{'v_term_id':v_term_id,'v_term_no':v_term_no,'v_term_name':v_term_name,'store_id_val':store_id_val,'remark':remark},
					success:function(data){
						reload();
						console.log('updata',data);
					}
				});
				
			});
        })


        function formatOption(value, row, index) {
                return '<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px; margin-left:20px;" onclick="editUser('+index+')">编辑</a> <a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:6px;" onclick="deletData('+index+')">删除</a>';
        }
        var url;
        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            console.log("index",index);
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','修改信息');
               console.log('row',row);
			   $('#up_vehicleNumber').textbox('setValue',row.v_term_no);
			   $('#up_vehicleName').textbox('setValue',row.v_term_name);
			   $('#up_plateNumber').textbox('setValue',row.plate_no);
				$('#up_remark').textbox('setValue',row.remark);
				$('#up_v_term_id').val(row.v_term_id);
            }
        };
		function reload(){
			$.ajax({
                url: '../ajaction/v1/?menuid=101115&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                   $("#dg").datagrid("loadData", data.Rows);  
                    
                    console.log('data', data);
                }
            });
		}
		function deletData(index){
			 $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                var id = row.v_term_id;
                $('#alarm').dialog('open').dialog('setTitle', '提示');
                $('#sure').bind('click', function() {
                    $.ajax({
                        url: '../ajaction/v1/?menuid=101115&cmd=del',
                        type: 'post',
                        data: {
                            'v_term_id': id
                        },
                        success: function(data) {
							reload();
                            console.log('delete', data);
                         
                        }
                    })
                })
            }
		};
    </script>
	 <style type="text/css">
          #sure{
            height: 25px;
            width: 60px;
            border: none;
            margin-right: 11px;
            background: url("../css/img/yes_normal.png") no-repeat;
        }
        #sure:visited,#sure:link{
            background: url("../css/img/yes_normal.png") no-repeat;
        } 
        #sure:hover,#sure:active{
            background: url("../css/img/yes_highlighted.png") no-repeat;
        }
        #cancel{
            height: 25px;
            width: 60px;
            border: none;
            background: url("../css/img/no_normal.png") no-repeat;
        }
        #cancel:visited,#cancel:link{
            background: url("../css/img/no_normal.png") no-repeat;
        }
        #cancel:hover,#cancel:active{
            background: url("../css/img/no_highlighted.png") no-repeat;
        }
		 #save{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #save:visited,#save:link{
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #save button:active,#save button:hover{
            background: url("../css/img/ok_seleected.png") no-repeat;

        }
        #close{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #close:visited,#close:link{
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #close button:active,#close button:hover{
            background: url("../css/img/cancel_selected.png") no-repeat;

        }
		#updata_save{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #updata_save:visited,#updata_save:link{
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #updata_save button:active,#updata_save button:hover{
            background: url("../css/img/ok_seleected.png") no-repeat;

        }
        #updata_close{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #updata_close:visited,#updata_close:link{
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #updata_close button:active,#updata_close button:hover{
            background: url("../css/img/cancel_selected.png") no-repeat;

        }
		</style>
</head>
<body class="easyui-layout" style="width: 100%;height: 100%;background-color: #ffffff">
<div  class="u-content">
    <table id="dg" class="easyui-datagrid"
           data-options="singleSelect:true,url:'../../datagrid_data1.json',method:'get',toolbar:'#tb',striped:'true',pagination:'true'">
        <thead>
        <tr>
            <th data-options="field:'v_term_no',width:'15%'">终端编号</th>
            <th data-options="field:'v_term_name',width:'15%'">终端名称</th>
            <th data-options="field:'mile_count',width:'15%'">累计里程</th>
            <th data-options="field:'store_name',width:'15%'">所属工厂</th>
            <th data-options="field:'remark',width:'15%'">备注</th>
            <th data-options="field:'_operate',width:'26%',formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
        <input id="search_v_no" type="text" placeholder="终端编号"/> <button id="search">搜索</button>
        <button style="float: right;"><a style="text-decoration: none;" href="#" onclick="addUser()">增加</a></button>
    </div>
    <div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#upbtn_dlg'" style="width:700px;height: 400px;">
        <div style="background-color: #ffffff;height:340px;margin:10px;">
		<span id="message">基本信息</span><hr/>
        <table id="cc" style="width: 100%;height: 80%;padding-left: 10px;padding-right: 10px">
             <tr>
                <td>
				<input id="up_v_term_id" style="display:none;" />
                    车载终端编号：
					</td>

				<td>
                      <input id="up_vehicleNumber" class="easyui-textbox" style="width: 150px;" />
                </td>
                <td>
                    车载终端名称：
					</td>

				<td>
                     <input id="up_vehicleName" class="easyui-textbox" style="width: 150px;" />
                </td>
            </tr>
            <tr>
                    <td>
                        修理厂名称：
                        </td>
                    <td>
                         <input id="uprepairID"  style="width: 150px;" />
                    </td>
                </tr>
			<tr>
                <td>
                    备注：
					</td>

				<td colspan="3">
                      <input id="up_remark" class="easyui-textbox" style="width:470px;" />
                </td>

            </tr>
			<tr style="text-align: center">
				<td>
				</td>

				<td>
					<button id='updata_save' style="margin-top:10px;"><a style="text-decoration: none;" href="#"></a></button>
				</td>
				<td>
					<button id='updata_close' style="margin-top:10px;"><a style="text-decoration: none" href="#"></a></button>
				</td>
				<td>
				</td>
			</tr>
        </table>
		</div>
    </div>
    <div id="addUser" class="easyui-dialog" data-options="closed:true,modal:true,iconCls:'icon-add2'" style="width:700px;height: 400px;background-color: #bdc4d4">
		<div style="background-color: #ffffff;height:340px;margin:10px;">
			<span id="addMessage">基本信息</span><hr/>
			<table  style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
				 <tr>
					<td>
						车载终端编号：
						</td>

				<td>
						  <input id="vehicleNumber" class="easyui-textbox" style="width: 150px;" />
					</td>
					<td>
						车载终端名称：
						</td>

				<td>
						 <input id="vehicleName" class="easyui-textbox" style="width: 150px;" />
					</td>
				</tr>
				<tr>
					<td>
						修理厂名称：
						</td>
					<td>
						 <input id="repairID"  style="width: 150px;" />
					</td>
				</tr>
				<tr>
					<td>
						备注：
						</td>

				<td colspan="3">
						  <input id="remark" class="easyui-textbox" style="width: 470px;" />
					</td>

				</tr>
				<tr style="text-align: center">
						<td>
						</td>
						<td>
							<button id='save' style="margin-top:10px;"><a style="text-decoration: none;" href="#"></a></button>
						</td>
						<td>
							<button id='close' style="margin-top:10px;"><a style="text-decoration: none" href="#"></a></button>
						</td>
						<td>
						</td>
				</tr>
			</table>
			</div>
			
			<div id="alarm" class="easyui-dialog" style="text-align: center;width:310px;height: 163px;background-color: #bdc4d4" data-options="closed:true,modal:true" >
        <div style="background-color: #ffffff;height:121px;margin:1px;">

            <span style="font-size:14px;color:#333333;font-weight: bold;display: inline-block;height: 78px;line-height: 78px;">用户删除无法恢复，确定删除？</span>
        <div  style="width:100%;">
            <button id="sure"></button>
            <button id="cancel"></button>
        </div>
        </div>
    </div>
    </div>
</div>
</body>
</html>