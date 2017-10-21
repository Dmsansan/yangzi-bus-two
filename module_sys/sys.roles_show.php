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
			//搜索操作：
			$('#search').bind('click',function(){
				var name=$('#rolesName').val();
				console.log('niaho',name);
				
				
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
						$('#dlg').dialog('close');
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
					$('#addUser').dialog('close');
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
                return '<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px; margin-left:20px;" onclick="editUser('+index+')">编辑</a> <a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:6px;" onclick="deletData('+index+')">删除</a>';

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
			$('#alarm').dialog('open').dialog('setTitle', '提示');	
				$('#sure').bind('click', function() {
                    $.ajax({
					url:'../ajaction/v1/?menuid=101010&cmd=del',
					type:'post',
					data:{'role_id':id},
					success:function(data){
					console.log('delete',data);
					reload();
					$('#alarm').dialog('close');
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
<body class="easyui-layout" style="width:100%; height: 100%;">

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
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
    <input type="text" id="rolesName" placeholder="角色名称"/> <button id="search">搜索</button>
    <button style="float: right; margin-top: 15px;"><a style="text-decoration: none;" href="#" onclick="addUser()">增加</a></button>
</div>
<!--修改信息弹出框 -->  
  <div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true,iconCls:'icon-add2'" style="width:650px;height: 300px;background-color: #bdc4d4">
        <div style="background-color: #ffffff;height:240px;margin:10px;">
		<span id="message">基本信息</span>
        <table id="cc" style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
            <tr>
                <td>
					<img src="../css/img/start.png">
                    角色名称：
					 <input id="role_id"  style="display: none;width:45%；" type="text"/>
					  <input id="module_id"  style="display: none;width:45%；" type="text"/>
                    <input id="title" class="easyui-textbox"  style="width:188px;" />
                </td>
                <td>
					<img src="../css/img/start.png">
                    角色权限：
                    <input id="roles"  style="width:188px;" />
                </td>
            </tr>
            <tr>
                <td>
					<img src="../css/img/start.png">
                    操作权限：
                    <input id="operate" style="width:188px;" />
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-left: 11px;">
                    角色说明：
                    <input id="remark" class="easyui-textbox" style="width:470px"/>
                </td>

            </tr>
			<tr style="text-align: center">

				<td>
					<button id='updata_save'><a style="text-decoration: none;" href="#"></a></button>
				</td>
				<td>
					<button id='updata_close'><a style="text-decoration: none" href="#"></a></button>
				</td>
			</tr>
        </table>
</div>
    </div>
   <div id="addUser" class="easyui-dialog" data-options="closed:true,modal:true,iconCls:'icon-add2'" style="width:650px;height: 300px;background-color: #bdc4d4">
    <div style="background-color: #ffffff;height:240px;margin:10px;">
    <span id="addMessage">基本信息</span>
    <table id="aa" style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
        <tr>
            <td>
                <img src="../css/img/start.png">
                角色名称：
                <input id="addrole" class="easyui-textbox" style="width:188px;" type="text"/>
            </td>
            <td>
                <img src="../css/img/start.png">
                角色权限：
                <input id="rolePower" style="width: 188px;" />
            </td>
        </tr>
        <tr>
            <td>
                <img src="../css/img/start.png">
                操作权限：
                <input id="addoper" style="width: 188px;"/>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 11px;">
                角色说明：
                <input id="addremark" class="easyui-textbox" style="width:470px;" type="text"/>
            </td>

        </tr>

        <tr style="text-align: center">

           <td>
               <button id='save'><a style="text-decoration: none;" href="#"></a></button>
           </td>
            <td>
                <button id='close'><a style="text-decoration: none" href="#"></a></button>
            </td>
        </tr>
    </table>
    </div>
</div>
	
<div id="alarm" class="easyui-dialog" style="text-align: center;width:310px;height: 163px;background-color: #bdc4d4" data-options="closed:true,modal:true" >
        <div style="background-color: #ffffff;height:121px;margin:1px;">

            <span style="font-size:14px;color:#333333;font-weight: bold;display: inline-block;height: 78px;line-height: 78px;">角色删除无法恢复，确定删除？</span>
        <div  style="width:100%;">
            <button id="sure"></button>
            <button id="cancel"></button>
        </div>
        </div>
    </div>
</body>
</html>