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
        function addUser() {
            $('#addUser').dialog('open').dialog('setTitle', '新增角色');
			
        };
        $(function() {
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
			//修改操作：
			$('#up_save').bind('click',function(){
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
            })

        })

        function reload() {
            $.ajax({
                url: '../ajaction/v1/?menuid=101011&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    var Idata = data.Rows;
                    $("#dg").datagrid("loadData", data.Rows);
                    console.log('data', Idata.admin_name);
                }
            });
        }

        function formatOption(value, row, index) {
            return '<a href="#" onclick="editUser(' + index + ')">修改</a> <a href="#" onclick="deletData(' + index + ')">删除</a>';
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
                            console.log('delete', data);
                            reload();
                        }
                    })
                })



            }
        };
    </script>
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
        <div id="tb" style="margin-bottom: 10px;margin-top: 10px">
            <input type="text" placeholder="用户名称" />
            <button>搜索</button>
            <button>重置</button>
            <button style="float: right;" onclick="addUser()">+增加</button>
        </div>
        <div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#upbtn_dlg'" style="width:600px;height: 400px;">
            <span>基本信息</span>
            <hr/>
            <table style="width: 100%;height:30%;padding-right: 10px;padding-left: 10px;">
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
                        <input id="up_check" type="checkbox" style="width: 150px;" />
                    </td>
                    <td>
                        所属车队：
                    </td>
                    <td>
					<input id="up_storeid" style="width: 150px;" />
                        <input id="up_carTeam" class="easyui-textbox" style="width: 150px;" />
                    </td>
                </tr>
            </table>
            <span>其他信息</span>
            <hr/>
            <table style="width: 100%;height:28%;padding-right: 10px;padding-left: 10px;">
                <tr>
                    <td>
                        联系电话：
						 <input id="admin_id" style="display:none; width: 150px;" />
                        <input id="up_tel" class="easyui-textbox" style="width: 150px;" />
                    </td>
                    <td>
                        手机号码：
                        <input id="up_phone" class="easyui-textbox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        邮箱：
                        <input id="up_email" class="easyui-textbox" style="width: 200px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        说明：
                        <input id="up_remark" class="easyui-textbox" style="width: 200px;" />
                    </td>
                </tr>
            </table>
        </div>
        <!--增加角色 -->
        <div id="addUser" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#btn_dlg'" style="width:600px;height: 400px;">
            <span id="addMessage">基本信息</span>
            <hr/>
            <table id="aa" style="width: 100%;height:30%;padding-right: 10px;padding-left: 10px;">
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
                        <input id="check" type="checkbox" style="width: 150px;" />
                    </td>
                    <td>
                        所属车队：
                    </td>
                    <td>
                        <input id="carTeam"  style="width: 150px;" />
                    </td>
                </tr>
            </table>
            <span>其他信息</span>
            <hr/>
            <table style="width: 100%;height:28%;padding-right: 10px;padding-left: 10px;">
                <tr>
                    <td>
                        联系电话：
                        <input id="tel" class="easyui-textbox" style="width: 150px;" />
                    </td>
                    <td>
                        手机号码：
                        <input id="phone" class="easyui-textbox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        邮箱：
                        <input id="email" class="easyui-textbox" style="width: 200px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        说明：
                        <input id="remark" class="easyui-textbox" style="width: 200px;" />
                    </td>
                </tr>
            </table>
        </div>
        <div id="alarm" class="easyui-dialog" style="text-align: center;width:600px;height: 300px;" data-options="closed:true,modal:true">
            <span style="height: 70%;font-size: 24px;font-weight: bold;">确定删除？</span>
            <div style="width:100%; height: 20%;margin-top: 150px;">
                <button id="sure">确定</button>
                <button id="cancel">取消</button>
            </div>
        </div>
        <div id="btn_dlg">
            <button id="save"><a style="text-decoration: none;" href="#">保存</a>
            </button>
            <button id="cancle"><a style="text-decoration: none" href="#">关闭</a>
            </button>
        </div>
        <div id="upbtn_dlg">
            <button id="up_save"><a style="text-decoration: none;" href="#">保存</a>
            </button>
            <button><a style="text-decoration: none" href="#">关闭</a>
            </button>
        </div>
    </div>
</body>

</html>