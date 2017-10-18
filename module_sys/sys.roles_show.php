<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>角色管理</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
    <script type="text/javascript">
        function addUser() {
                $('#addUser').dialog('open').dialog('setTitle','新增角色');
            };
        $(function () {
			 $('#addoper').combobox({
                url:'../css/homepagecss/chedui.json',
                panelHeight:200,
                valueField:'id',
                textField:'text',
                multiple:true,
                formatter:function (row) {
                    var opts = $(this).combobox('options');
                    return '<input type="checkbox" class="combobox-checkbox">' + row[opts.textField];
                    console.log("row",ops.textField);
                }

            });
            $("#rolePower").combotree({
                url:'../ajaction/v1/?menuid=0&cmd=get_all_modules',
				type:'get',
				multiple: true,
				checkbox: true,
				required: true
            });
			$('#roles').combotree({
				url:'../ajaction/v1/?menuid=0&cmd=get_all_modules',
				type:'get',
				width:'200',
				multiple: true,
				checkbox: true,
				required: true
			})
            $('#operate').combobox({
                url:'../css/homepagecss/chedui.json',
                panelHeight:200,
                valueField:'id',
                textField:'text',
                multiple:true,
                formatter:function (row) {
                    var opts = $(this).combobox('options');
                    return '<input type="checkbox" class="combobox-checkbox">' + row[opts.textField];
                    console.log("row",ops.textField);
                }

            });
			//装载数据操作
			$.ajax({
				url:'../ajaction/v1/?menuid=101010&cmd=qry&t=1',
				type:'post',
				dataType:'json',
				success:function(data){
				$("#dg").datagrid("loadData", data.Rows);  
					console.log('data',data);
				}							
			});
			//更新操作
			$('#updata_save').bind('click',function(){
				var title=$('#title').textbox('getText');
				var role_id=$('#role_id').val();
				var remark=$('#remark').textbox('getText');							
				var module_list=$('#roles').combotree('getText');
				var module_list_val=$('#module_id').val();
				var operlist=$('#operate').combobox('getText');
				console.log('dddddd',role_id+remark+module_list+module_list_val+operlist);
				
				$.ajax({
					url:'../ajaction/v1/?menuid=101010&cmd=edit',
					type:'POST',
					data:{'title':title,'role_id':role_id,'remark':remark,'module_list':module_list,'module_list_val':module_list_val,'Operlist':operlist},
					success:function(data){
						console.log("data",data);
							reload();
					}
					
				})
				
			});
			//增加操作
			$('#save').bind('click',function(){
			var addrole=$('#addrole').textbox('getText');
			var rolePower=$('#rolePower').combotree('getText');
			var module_list_val=$('#rolePower').combotree('getValue');
			var addoper=$('#addoper').combobox('getText');
			var addremark=$('#addremark').textbox('getText');
			$.ajax({
				url:'../ajaction/v1/?menuid=101010&cmd=add',
				type:'POST',
				data:{'title':addrole,'remark':addremark,'module_list':rolePower,'module_list_val':module_list_val,'operlist':addoper},
				success:function(data){
					reload();
				console.log('data',data);
				}
			})
			
			}
			);
			
        })
		function reload(){
		$.ajax({
				url:'../ajaction/v1/?menuid=101010&cmd=qry&t=1',
				type:'post',
				dataType:'json',
				success:function(data){
				$("#dg").datagrid("loadData", data.Rows);  
					console.log('data',data);
				}							
			});
		}

        function formatOption(value, row, index) {
        return '<a href="#" onclick="editUser('+index+')">修改</a> <a href="#" onclick="deletData('+index+')">删除</a>';
        }
        var url;
		//装填修改dialog
        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            console.log("index",index);
            var row = $('#dg').datagrid('getSelected');
				console.log("row",row);
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','修改角色信息');
				$('#role_id').val(row.role_id);
				$('#module_id').val(row.modules_list_val);
				  $('#title').textbox('setValue',row.title);
				 $('#roles').combotree('setValue',row.modules_list)
				 $('#operate').combobox('setValue',row.operlist);
				 $('#remark').textbox('setValue',row.remark);
				 console.log('module_id',row.modules_list_val);
            }
        };
		//删除操作
        function deletData(index) {
			$('#dg').datagrid('selectRow', index);
			var row = $('#dg').datagrid('getSelected');
			if(row){
				var id=row.role_id;
				$.ajax({
					url:'../ajaction/v1/?menuid=101010&cmd=del',
					type:'post',
					data:{'role_id':id},
					success:function(data){
					console.log('delete',data);
					reload();
					}
				})
			}
        };
		

    </script>
	 <style type="text/css">
        #btn_dlg{
            text-align: center;
            border-bottom: none;
            border-left:none;
            border-right: none;
        }
        #btn_dlg button{
            border: none;
            padding: 8px 10px;
            vertical-align: middle;
            margin-right: 10px;

        }
        #btn_dlg button:visited,#btn_dlg button:link{
            background-color: #D3D3D3;
        }
        #btn_dlg button:active,#btn_dlg button:hover{
            background-color: #3f3f3f;
        }
		 #updata_dlg{
            text-align: center;
            border-bottom: none;
            border-left:none;
            border-right: none;
        }
        #updata_dlg button{
            border: none;
            padding: 8px 10px;
            vertical-align: middle;
            margin-right: 10px;

        }
        #updata_dlg button:visited,#updata_dlg button:link{
            background-color: #D3D3D3;
        }
        #updata_dlg button:active,#updata_dlg button:hover{
            background-color: #3f3f3f;
        }

    </style>
</head>
<body class="easyui-layout" style="width:100%; height: 100%;background-color: #ffffff">

    <table id="dg" class="easyui-datagrid" data-options="singleSelect:true,method:'get',toolbar:'#tb',striped:'true',pagination:'true',width:'100%'" >
        <thead>
        <tr>
            <th field="role_id" width="15%" sortable="true">角色编号</th>
            <th data-options="field:'title',width:'15%'">角色名称</th>
            <th data-options="field:'modules_list',width:'15%'">模块列表</th>
            <th data-options="field:'remark',width:'30%'">说明</th>
             <th data-options="field:'_operate',width:'25%',formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px">
        <input type="text" placeholder="角色名称"/> <button>搜索</button> <button>重置</button>
        <button style="float: right;"><a style="text-decoration: none;" href="#" onclick="addUser()">增加</a></button>
    </div>
<!--修改信息弹出框 -->  
  <div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#updata_dlg'" style="width:600px;height: 300px;">
        <span id="message">基本信息</span><hr/>
        <table id="cc" style="width: 100%;height: 80%;padding-left: 10px;padding-right: 10px">
            <tr>
                <td>
                    角色名称：
					 <input id="role_id"  style="display: none;width:45%；" type="text"/>
					  <input id="module_id"  style="display: none;width:45%；" type="text"/>
                    <input id="title" class="easyui-textbox"  style="display: inline-block;width:45%;border:1px solid #dddddd; " type="text"/>
                </td>
                <td>
                    角色权限：
                    <input id="roles"  style="width:45%" />

                </td>
            </tr>
            <tr>
                <td>
                    操作权限：
                    <select id="operate" style="width: 45%;">

                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    角色说明：
                    <input id="remark" class="easyui-textbox" style="display: inline-block;width:45%" type="text"/>
                </td>

            </tr>
        </table>
    </div>
	<div id="updata_dlg">
    <button id='updata_save'><a style="text-decoration: none;" href="#">保存</a></button><button id='updata_close'><a style="text-decoration: none" href="#">关闭</a></button>
</div>
    <div id="addUser" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#btn_dlg'" style="width:600px;height: 300px;">
        <span id="addMessage">基本信息</span><hr/>
        <table id="aa" style="width: 100%;height: 80%;padding-right: 10px;padding-left: 10px;">
            <tr>
                <td>
                    角色名称：
                    <input id="addrole" class="easyui-textbox" style="display: inline-block;width:45%" type="text"/>
                </td>
                <td>
                    角色权限：
                    <input id="rolePower" style="width: 150px;" />
                </td>
            </tr>
            <tr>
                <td>
                     操作权限：
                    <select id="addoper" style="width: 45%;">

                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    角色说明：
                    <input id="addremark" class="easyui-textbox" style="display: inline-block;width:45%" type="text"/>
                </td>

            </tr>
        </table>
    </div>
	<div id="btn_dlg">
    <button id='save'><a style="text-decoration: none;" href="#">保存</a></button><button id='close'><a style="text-decoration: none" href="#">关闭</a></button>
</div>
<div id="alarmDialog">

</div>
</body>
</html>