<?php
session_start();
$operlist = $_SESSION['OperList'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>线路管理</title>
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
				$('#addUser').dialog('open').dialog('setTitle', '新增线路');
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
                }

            });
			//搜索操作：
			$('#search').bind('click',function(){
				$("#dg").datagrid('load',{
                roules_name: $('#search_roules_name').val(),
            }); 
			});
			//修改操作：
			$('#update_save').bind('click',function(){
			var id=$('#up_roules_id').val();
			var roules_name=$('#up_roules_name').textbox('getText');
			var remark=$('#up_remark').textbox('getText');
			//alert(id);
			$.ajax({
				url:'../ajaction/v1/?menuid=101118&cmd=edit',
				type:'post',
				data:{'id':id,'roules_name':roules_name,'remark':remark,},
				success:function(data){
					   var res = eval('(' + data + ')')
                        if(res.status=="OK"){
                            $.messager.show({
                                    title : '操作成功',
                                    msg:res.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    });
                            reload();
                            $('#dlg').dialog('close');
                        }else{
                            $.messager.show({
                                    title : '操作失败',
                                    msg:res.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    }); 
                        } 
				}
			})
			});
            //增加操作：
            $('#save').bind('click', function() {
                var roules_name = $('#roules_name').textbox('getText');
				var remark=$('#remark').textbox('getText');
                $.ajax({
                url:'../ajaction/v1/?menuid=101118&cmd=add',
				data:{'roules_name':roules_name,'remark':remark},
				success:function(data){
					   var res = eval('(' + data + ')')
                        if(res.status=="OK"){
                            $.messager.show({
                                    title : '操作成功',
                                    msg:res.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    });
                            reload();
                            $('#addUser').dialog('close');
                        }else{
                            $.messager.show({
                                    title : '操作失败',
                                    msg:res.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    }); 
                        } 
			
				}
                });
            });
			$('#cancel').bind('click',function(){
				$('#alarm').dialog('close');
			});
			$('#close').bind('click',function(){
				$('#addUser').dialog('close');
			});
			$('#update_close').bind('click',function(){
				$('#dlg').dialog('close');
			});
			

        })

        function reload() {
            $.ajax({
                url: '../ajaction/v1/?menuid=101118&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    $("#dg").datagrid("loadData", data.rows);
                }
            });
        }

        var operlist='<?php echo $operlist;?>';
        function formatOption(value, row, index) {
            var str='';
           
            if(operlist.indexOf('修改') != -1){
                str+='<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px; margin-left:20px;" onclick="editUser('+index+')">编辑</a>';
            }
            
            if(operlist.indexOf('删除') != -1){
                str+='<a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:6px;" onclick="deletData('+index+')">删除</a>';
            }
            
            return str;

        }
        var url;

        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');

            if (row) {
                console.log("row", row);
					$('#dlg').dialog('open').dialog('setTitle', '修改线路');
					$('#up_roules_id').val(row.id);
					$('#up_roules_name').textbox('setValue',row.roules_name);
					$('#up_remark').textbox('setValue',row.remark);
				
            }
        };
        //删除操作
        function deletData(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
			
            if (row) {
                var id = row.id;
                $('#alarm').dialog('open').dialog('setTitle', '提示');
                $('#sure').bind('click', function() {
                    $.ajax({
                        url: '../ajaction/v1/?menuid=101116&cmd=del',
                        type: 'post',
                        data: {
                            'id': id
                        },
                        success: function(data) {
							 var res = eval('(' + data + ')')
                        if(res.status=="OK"){
                            $.messager.show({
                                    title : '操作成功',
                                    msg:res.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    });
                            reload();
                            $('#alarm').dialog('close');
                        }else{
                            $.messager.show({
                                    title : '操作失败',
                                    msg:res.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    }); 
                        } 
							
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
		#update_save{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #update_save:visited,#update_save:link{
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #update_save button:active,#update_save button:hover{
            background: url("../css/img/ok_seleected.png") no-repeat;

        }
        #update_close{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #update_close:visited,#update_close:link{
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #update_close button:active,#update_close button:hover{
            background: url("../css/img/cancel_selected.png") no-repeat;

        }
		</style>
</head>

<body class="easyui-layout">
    <div class="u-content">
        <div id="tb" style="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
            <input id="search_roules_name" type="text" placeholder="线路名称" />
             <?php $operlist=explode(',',$_SESSION['OperList']); if(in_array('查看',$operlist)){?><button id="search">搜索</button><?php }?>
            <?php if(in_array('添加',$operlist)){?><button id="add"  style="float: right; margin-top: 15px;">增加</button><?php }?>
        </div>
        <table id="dg" class="easyui-datagrid" url="../ajaction/v1/?menuid=101118&cmd=qry&t=1"
            striped="true" rownumbers="false" pagination="true" singleSelect="true"
        >
            <thead>
                <tr>
                    <th data-options="field:'id',width:'25%'">线路编号</th>
                    <th data-options="field:'roules_name',width:'25%'">线路名称</th>
                    <th data-options="field:'remark',width:'25%'">备注</th>
                    <th data-options="field:'_operate',width:'25%',formatter:formatOption">操作</th>
                </tr>
            </thead>
        </table>
        
        <div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true,iconCls:'icon-add2'" style="width:650px;height: 200px;background-color: #bdc4d4">
		<div style="background-color: #ffffff;height:140px;margin:10px;">           
		   <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">公司信息</span>
            <table style="width: 100%;height:30%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        线路名称：
                    </td>
                    <td>
					   <input id="up_roules_id" style="display:none">
                       <input id="up_roules_name" class="easyui-textbox" style="width: 150px;" required="true" />
                    </td>
                    <td>
                        备注：
                    </td>
                    <td>
					  <input id="up_remark"  class="easyui-textbox" style="width: 150px;" />
                    </td>
                </tr>
				<tr style="text-align: center">
						<td>
						</td>
						<td>
							<button id='update_save' style="margin-top:10px;"><a style="text-decoration: none;" href="#"></a></button>
						</td>
						<td>
							<button id='update_close' style="margin-top:10px;"><a style="text-decoration: none" href="#"></a></button>
						</td>
						<td>
						</td>
				</tr>
               
            </table>
	</div>
        </div>
        <!--增加角色 -->
        <div id="addUser" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#btn_dlg'" style="width:650px;height: 200px;background-color: #bdc4d4">
		<div style="background-color: #ffffff;height:140px;margin:10px;">   
               <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
            <table id="aa" style="width: 100%;height:30%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                       线路名称：
                    </td>
                    <td>
                        <input id="roules_name" class="easyui-textbox" style="width: 150px;" required="true" />
                    </td>
                    <td>
                        备注：
                    </td>
                    <td>
                        <input id="remark" class="easyui-textbox" style="width: 150px;" />
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

            <span style="font-size:14px;color:#333333;font-weight: bold;display: inline-block;height: 78px;line-height: 78px;">线路删除无法恢复，确定删除？</span>
        <div  style="width:100%;">
            <button id="sure"></button>
            <button id="cancel"></button>
        </div>
        </div>
    </div>
		
    </div>
</body>

</html>