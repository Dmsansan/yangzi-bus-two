<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>用户管理</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src=" ../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
    <script type="text/javascript">
       
        $(function() {
			$('#add').on('click',function(){
				$('#addUser').dialog('open').dialog('setTitle', '新增角色');
			});
			//获得角色列表；
			$.ajax({
				url: '../ajaction/v1/?menuid=0&cmd=get_all_roles',
				dataType:'json',
				success:function(data){
					var msg=data.items;
					$("#userRole").combobox('loadData',msg);
					$("#up_userRole").combobox('loadData',msg);
					
				}
			});
            $("#userRole").combobox({       
                valueField: 'role_id',
                textField: 'role_title',
				type:'json',
                editable: false,
            });

            $("#up_carTeam").combobox({
                valueField: 'store_id',
                textField: 'store_name',
                editable: false
            }); 
            $("#up_userRole").combobox({
                valueField: 'role_id',
                textField: 'role_title',
                editable: false
            });
			//获取车队列表
			$.ajax({
				url:'../ajaction/v1/?menuid=0&cmd=get_all_stores',
				dataType:'json',
				success:function(data){
					var team=data.items;
					$('#carTeam').combobox('loadData',team);
					$('#up_carTeam').combobox('loadData',team);
					console.log('msg',data);
				}
			});
            $('#carTeam').combobox({
                valueField: 'store_id',
                textField: 'store_name',
                editable: false
            });
            $('#operate').combobox({
                url: '',
                panelHeight: 200,
                valueField: 'id',
                textField: 'text',
                multiple: true,
                formatter: function(row) {
                    var opts = $(this).combobox('options');
                    return '<input type="checkbox" class="combobox-checkbox">' + row[opts.textField];
                    console.log("row", ops.textField);
                }

            });
			//获取user
            $.ajax({
                url: '../ajaction/v1/?menuid=101011&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    var obj = eval(data);
                    $("#dg").datagrid("loadData", data.Rows);
                    console.log('data', obj);
                }
            });
			//搜索操作：
			$('#search').bind('click',function(){
				var username = $('#username').val();
				$.ajax({
				    url:'../ajaction/v1/?menuid=101011&cmd=qry',
                    type:'POST',
                    data:{'admin_name':username},
                    dataType:'json',
                    success:function(data){
                        $("#dg").datagrid("loadData", data.Rows);
                    }	
				})
			});
			//修改操作：
			$('#updata_save').bind('click',function(){
			var admin_id=$('#admin_id').val();
			var admin_name=$('#up_userName').textbox('getText');
			var role_id=$('#up_roleId').val();
			var admin_pass=$('#up_password').textbox('getText');
			var real_name= $('#up_truthName').textbox('getText');
			var tel=$('#up_tel').textbox('getText');
			var mobile=$('#up_phone').textbox('getText');
			var email=$('#up_email').textbox('getText');
			var remark=$('#up_remark').textbox('getText');
			var is_term;
			if($('#up_check').is(':checked')){
					is_term='N';
				}else{
					is_term='Y';
				}
			var store_id_val=$('#up_storeid').val();
			$.ajax({
				url:'../ajaction/v1/?menuid=101011&cmd=edit',
				type:'post',
				data:{'admin_id':admin_id,'admin_name':admin_name,'role_id_val':role_id,'admin_pass':admin_pass,'real_name':real_name,'tel':tel,'mobile':mobile,'email':email,'remark':remark,'is_term':is_term,
				'store_id_val':store_id_val},
				success:function(data){
					reload();
					console.log('updata',data);
				}
			})
			});
            //增加操作：
            $('#save').bind('click', function() {
                var admin_name = $('#userName').textbox('getText');
                var role_id_val=$('#userRole').combobox('getValue');				
                var real_name = $('#truthName').textbox('getText');
                var tel=$('#tel').textbox('getText');
                var mobile=$('#phone').textbox('getText');
                var email =$('#email').textbox('getText');
				var remark=$('#remark').textbox('getText');
				var admin_pass=$('#password').textbox('getText');
                var is_term;
				if($('#check').is(':checked')){
					is_term='N';
				}else{
					is_term='Y';
				}
				
				console.log('role_id',is_term);
                var store_id=$('#carTeam').combobox('getValue');
                $.ajax({
                url:'../ajaction/v1/?menuid=101011&cmd=add',
				data:{'admin_name':admin_name,'real_name':real_name,'role_id_val':role_id_val,'tel':tel,'admin_pass':admin_pass,'mobile':mobile,'email':email,'remark':remark,'is_term':is_term,'store_id':store_id},
				success:function(data){
					reload();
					console.log("loadDa",data);
				}
                });
            });
			$('#cancel').bind('click',function(){
				$('#alarm').dialog('close');
			});
			$('#close').bind('click',function(){
				$('#addUser').dialog('close');
			});
			$('#updata_close').bind('click',function(){
				$('#dlg').dialog('close');
			});
			

        })

        function reload() {
            $.ajax({
                url: '../ajaction/v1/?menuid=101011&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    $("#dg").datagrid("loadData", data.Rows);
                 
                }
            });
        }

        function formatOption(value, row, index) {
                return '<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px; margin-left:20px;" onclick="editUser('+index+')">编辑</a> <a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:6px;" onclick="deletData('+index+')">删除</a>';

        }
        var url;

        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');

            if (row) {
                console.log("row", row);
					$('#dlg').dialog('open').dialog('setTitle', '修改角色');
					$('#admin_id').val(row.admin_id);
					$('#up_roleId').val(row.role_id);
					$('#up_userName').textbox('setValue',row.admin_name);
					$('#up_userRole').combobox('setValue',row.role_title);
					$('#up_password').textbox('setValue',row.password);
					$('#up_truthName').textbox('setValue',row.real_name);
				 if(row.is_term==="N"){
					$('#up_check').attr('checked',true); 
				 }else{
					$('#up_check').attr('checked',false); 
				 }
					$('#up_carTeam').combobox('setValue',row.store_name);
					$('#up_tel').textbox('setValue',row.tel);
					$('#up_phone').textbox('setValue',row.mobile);
					$('#up_email').textbox('setValue',row.email);
					$('#up_remark').textbox('setValue',row.remark);
					$('#up_storeid').val(row.store_id);
            }
        };
        //删除操作
        function deletData(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
			
            if (row) {
                var id = row.admin_id;
                $('#alarm').dialog('open').dialog('setTitle', '提示');
                $('#sure').bind('click', function() {
                    $.ajax({
                        url: '../ajaction/v1/?menuid=101011&cmd=del',
                        type: 'post',
                        data: {
                            'admin_id': id
                        },
                        success: function(data) {
                   
                            reload();
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

<body class="easyui-layout">
    <div class="u-content">
        <table id="dg" class="easyui-datagrid" data-options="singleSelect:true,method:'get',toolbar:'#tb',striped:'true',pagination:'true'">
            <thead>
                <tr>
                    <th data-options="field:'admin_id',width:'10%'">用户编号</th>
                    <th data-options="field:'admin_name',width:'10%'">用户名称</th>
                    <th data-options="field:'real_name',width:'10%'">姓名</th>
                    <th data-options="field:'role_title',width:'10%'">角色</th>
                    <th data-options="field:'store_name',width:'10%'">归属车队</th>
                    <th data-options="field:'remark',width:'25%'">说明</th>
                    <th data-options="field:'_operate',width:'26%',formatter:formatOption">操作</th>
                </tr>
            </thead>
        </table>
        <div id="tb" style="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
            <input id="username" type="text" placeholder="用户名称" />
            <button id="search">搜索</button>
           <button id="add"  style="float: right; margin-top: 15px;">增加</button>
        </div>
        <div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true,iconCls:'icon-add2'" style="width:650px;height: 400px;background-color: #bdc4d4">
		<div style="background-color: #ffffff;height:340px;margin:10px;">           
		   <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
            <table style="width: 100%;height:30%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        用户名称：
                    </td>
                    <td>
					
                        <input id="up_userName" class="easyui-textbox" style="width: 150px;" />
                    </td>
                    <td>
                        用户角色：
                    </td>
                    <td>
					 <input id="up_roleId" style="display:none; width: 150px;" />
                        <input id="up_userRole" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        密码：
                    </td>
                    <td>
                        <input id="up_password" type="password" class="easyui-textbox" style="width: 150px;" />
                    </td>
                    <td>
                        真实姓名：
                    </td>
                    <td>
                        <input id="up_truthName" class="easyui-textbox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        手持终端：
                    </td>
                    <td>
                        <input id="up_check"  type="checkbox" style="width:16px;height:16px;" />
                    </td>
                    <td>
                        所属车队：
                    </td>
                    <td>
					<input id="up_storeid" style="display:none; width: 150px;" />
                        <input id="up_carTeam" class="easyui-textbox" style="width: 150px;" />
                    </td>
                </tr>
            </table>
			<hr/>
               <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">其他信息</span>
            <table style="width: 100%;height:28%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        联系电话：
						 </td>
                    <td>
						 <input id="admin_id" style="display:none; width: 150px;" />
                        <input id="up_tel" class="easyui-textbox" style="width: 150px;" />
                    </td>
                    <td>
                        手机号码：
						 </td>
                    <td>
                        <input id="up_phone" class="easyui-textbox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        邮箱：
						 </td>
                    <td>
                        <input id="up_email" class="easyui-textbox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        说明：
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
        <!--增加角色 -->
        <div id="addUser" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#btn_dlg'" style="width:650px;height: 400px;background-color: #bdc4d4">
		<div style="background-color: #ffffff;height:340px;margin:10px;">   
               <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
            <table id="aa" style="width: 100%;height:30%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        用户名称：
                    </td>
                    <td>
                        <input id="userName" class="easyui-textbox" style="width: 150px;" />
                    </td>
                    <td>
                        用户角色：
                    </td>
                    <td>
                        <input id="userRole" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        密码：
                    </td>
                    <td>
                        <input id="password" class="easyui-textbox" style="width: 150px;" />
                    </td>
                    <td>
                        真实姓名：
                    </td>
                    <td>
                        <input id="truthName" class="easyui-textbox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        手持终端：
                    </td>
                    <td>
                        <input id="check" type="checkbox" style="width:50px;" />
                    </td>
                    <td>
                        所属车队：
                    </td>
                    <td>
                        <input id="carTeam"  style="width: 150px;" />
                    </td>
                </tr>
            </table>
			<hr/>
              <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">其他信息</span>
            <table style="width: 100%;height:28%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        联系电话：
					</td>
                    <td>
                        <input id="tel" class="easyui-textbox" style="width: 150px;" />
                    </td>
                    <td>
                        手机号码：
					</td>
                    <td>
                        <input id="phone" class="easyui-textbox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        邮箱：
						</td>
                    <td>
                        <input id="email" class="easyui-textbox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td >
                        说明：
						</td>
                    <td colspan="3">
                        <input id="remark" class="easyui-textbox" style="width:470px;" />
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
</body>

</html>