<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>轮胎参数管理</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
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
        <script type="text/javascript">
            function addUser() {
                $('#addUser').window('open').window('setTitle','新增参数');
            };
            $(function () {
                //装载数据操作
                $.ajax({
                    url:'../ajaction/v1/?menuid=101112&cmd=qry&t=1',
                    type:'post',
                    dataType:'json',
                    success:function(data){
                    $("#dg").datagrid("loadData", data.Rows);  
                        console.log('data',data);
                    }                           
                });
                //增加操作
                $('#save').bind('click',function(){
                var brand_name=$('#brand_name').textbox('getText');
                var norms_name=$('#norms_name').textbox('getText');
                var class_name=$('#class_name').textbox('getText');
                var figure_name=$('#figure_name').textbox('getText');
                var remark=$('#remark').textbox('getText');
                $.ajax({
                    url:'../ajaction/v1/?menuid=101112&cmd=add',
                    type:'POST',
                    data:{'brand_name':brand_name,'norms_name':norms_name,'class_name':class_name,'figure_name':figure_name,'remark':remark},
                    dataType:'json',
                    success:function(data){
                        $('#addUser').dialog('close');
						$.messager.show({
                            title : '操作成功',
                            msg:'轮胎参数增加成功！',
                            timeout:3000,
                            showType:'show',  
                            });
							reload();
                        console.log('data',data);
                    }
                })
                
                });

            //更新操作
            $('#updata_save').bind('click',function(){
                var brand_name=$('#up_brand_name').textbox('getText');
                var brand_id=$('#brand_id').val();
                var remark=$('#up_remark').textbox('getText');                         
                var norms_name=$('#up_norms_name').textbox('getText');
                var class_name=$('#up_class_name').textbox('getText');
                var figure_name=$('#up_figure_name').textbox('getText');
               
                
                $.ajax({
                    url:'../ajaction/v1/?menuid=101112&cmd=edit',
                    type:'POST',
                    data:{'brand_name':brand_name,'brand_id':brand_id,'remark':remark,'norms_name':norms_name,'class_name':class_name,'figure_name':figure_name},
                    success:function(data){
                  
                        $('#dlg').dialog('close');
						$.messager.show({
                            title : '操作成功',
                            msg:'轮胎参数修改成功！',
                            timeout:3000,
                            showType:'show',  
                            });
                            reload();   
                    }
                    
                })
                
            });
            //搜索操作：
            $('#search').bind('click',function(){
                var brand_name=$('#search_brand_name').val();
                $.ajax({
                    url:'../ajaction/v1/?menuid=101112&cmd=qry',
                    type:'POST',
                    data:{'brand_name':brand_name},
                    dataType:'json',
                    success:function(data){
                        $("#dg").datagrid("loadData", data.Rows);    
                    }
                });
                
            });

                $('#close').bind('click',function(){
                    $('#addUser').dialog('close');
                }); 
                $('#updata_close').bind('click',function(){
                $('#dlg').dialog('close');
            }); 
            
            })

           function reload(){
            $.ajax({
                    url:'../ajaction/v1/?menuid=101112&cmd=qry&t=1',
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
            $('#up_brand_name').val(313123);
            $('#dg').datagrid('selectRow', index);
            console.log("index",index);
            var row = $('#dg').datagrid('getSelected');
                console.log("row",row);
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','修改参数信息');
                $('#brand_id').val(row.brand_id);
                $('#up_brand_name').textbox('setValue',row.brand_name);
                $('#up_norms_name').textbox('setValue',row.norms_name);
                $('#up_class_name').textbox('setValue',row.class_name);
                $('#up_figure_name').textbox('setValue',row.figure_name);
                $('#up_remark').textbox('setValue',row.remark);
            }
        };
        //删除操作
        function deletData(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if(row){            
                var id=row.brand_id;
            $('#alarm').dialog('open').dialog('setTitle', '提示');    
                $('#sure').bind('click', function() {
                    $.ajax({
                    url:'../ajaction/v1/?menuid=101112&cmd=del',
                    type:'post',
                    data:{'brand_id':id},
                    success:function(data){
					$('#alarm').dialog('close');
                    $.messager.show({
                            title : '操作成功',
                            msg:'轮胎参数删除成功！',
                            timeout:3000,
                            showType:'show',  
                            });
                    reload();
                    }
                })
                })
 
            }
        };
        </script>
</head>
<body class="easyui-layout" style="width: 100%;height: 100%;background-color: #f1f6fd">
<div  class="u-content">
    <table id="dg" class="easyui-datagrid"
           data-options="singleSelect:true,url:'../../datagrid_data1.json',method:'get',toolbar:'#tb',striped:'true',pagination:'true'">
        <thead>
        <tr>
            <!--<th data-options="field:'itemid',width:200">参数编号</th>-->
            <th data-options="field:'brand_name',width:205">品牌名称</th>

            <th data-options="field:'norms_name',width:255">规格名称</th>
            <th data-options="field:'class_name',width:250">层级名称</th>
            <th data-options="field:'figure_name',width:450">花纹名称</th>
            <th data-options="field:'remark',width:305">备注</th>
            <th data-options="field:'_operate',width:220,formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
        <input id="search_brand_name" placeholder="品牌名称" /> <button id="search">搜索</button><button style="float: right;margin-top: 15px;" onclick="addUser()">增加</button>
    </div>
    <div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#upbtn_dlg'" style="width:700px;height: 400px;">
    <div style="background-color: #ffffff;height:340px;margin:10px;">
        <span id="message">参数信息</span>
        <table id="aa" style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
            <tr>
                <td>
                    品牌名称：
                    </td>
                    <td>
                    <input id="brand_id" style="display:none" type="text">
                      <input id="up_brand_name" class="easyui-textbox"  style="width: 150px;" />
                </td>
                <td>
                    规格名称：
                    </td>
                    <td>
                     <input id="up_norms_name" class="easyui-textbox" style="width: 150px;" />
                </td>
            </tr>
            <tr>
                <td>
                    层级名称:
                    </td>
                <td>
                     <input id="up_class_name" class="easyui-textbox" style="width: 150px;" />
                </td>
                <td>
                   花纹名称:
                    </td>
                <td>
                     <input id="up_figure_name" class="easyui-textbox" style="width: 150px;" />
                </td>
            </tr>
            <tr>
                <td>
                    备注：
                    </td>
                <td>
                     <input id="up_remark" class="easyui-textbox" style="width: 150px;" />
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
    <div id="addUser" class="easyui-dialog" data-options="closed:true,modal:true" style="width:700px;height: 400px;">
    <div style="background-color: #ffffff;height:340px;margin:10px;">
        <span id="addmessage">参数信息</span>
        <table id="cc" style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
            <tr>
                <td>
                    品牌名称：
                    </td>
                    <td>
                     <input id="brand_name" class="easyui-textbox" style=" width: 150px;" />
                </td>
                <td>
                    规格名称：
                    </td>
                    <td>
                     <input id="norms_name" class="easyui-textbox" style="width: 150px;" />
                </td>
            </tr>
            <tr>
                <td>
                    层级名称:
                    </td>
                <td>
                     <input id="class_name" class="easyui-textbox" style="width: 150px;" />
                </td>
                <td>
                    花纹名称:
                    </td>
                <td>
                     <input id="figure_name" class="easyui-textbox" style="width: 150px;" />
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