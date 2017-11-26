<?php
session_start();
$operlist = $_SESSION['OperList'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修理厂管理</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
    <script type="text/javascript">
       
        $(function () { 
		$('#add').on('click',function(){
			 $('#addUser').dialog('open').dialog('setTitle','增加信息');
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
			
            //搜索操作
            $('#search').bind('click',function(){
               $("#dg").datagrid('load',{
                store_name: $('#xiuli_name').val(),
            }); 
            });
			//增加操作
			$('#save').bind('click',function(){
				var store_no=$('#repairNumber').textbox('getText');
				var store_name=$('#repairName').textbox('getText');
				var contact	=$('#contract').textbox('getText');
				var tel=$('#tel').textbox('getText');
				var mobile=$('#phone').textbox('getText');
				var address	=$('#address').textbox('getText');
				var remark=$('#remark').textbox('getText');
				$.ajax({
					url:'../ajaction/v1/?menuid=101110&cmd=add',
					type:'POST',
					dataType:'json',
					data:{'store_no':store_no,'store_name':store_name,'contact':contact,'tel':tel,'mobile':mobile,'address':address,'remark':remark},
					success:function(data){
						//var res = eval('(' + data + ')')
                        if(data.status=="OK"){
                            $.messager.show({
                                    title : '操作成功',
                                    msg:data.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    });
                            reload();
                            $('#addUser').dialog('close');
                        }else{
                            $.messager.show({
                                    title : '操作失败',
                                    msg:data.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    }); 
                        }   
				
					}
				})
	
				
			});
			//修改操作
			$('#updata_save').bind('click',function(){
				var store_no=$('#up_repairNumber').textbox('getText');
				var store_name=$('#up_repairName').textbox('getText');
				var contact=$('#up_contract').textbox('getText');
				var tel=$('#up_tel').textbox('getText');
				var mobile=$('#up_phone').textbox('getText');
				var address=$('#up_address').textbox('getText');
				var remark=$('#up_remark').textbox('getText');
				var store_id=$('#up_repairId').val();
				$.ajax({
					url:'../ajaction/v1/?menuid=101110&cmd=edit',
					type:'POST',
					data:{'store_id':store_id,'store_no':store_no,'store_name':store_name,'contact':contact,'tel':tel,'mobile':mobile,'address':address,'remark':remark},
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
				});
				
			});
        })


        var operlist='<?php echo $operlist;?>';
        function formatOption(value, row, index) {
            var str='';
           
            if(operlist.indexOf('修改') != -1){
                str+='<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px; " onclick="editUser('+index+')">编辑</a>';
            }
            
            if(operlist.indexOf('删除') != -1){
                str+='<a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:6px;" onclick="deletData('+index+')">删除</a>';
            }
            
            return str;
        }
        var url;
        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            console.log("index",index);
            var row = $('#dg').datagrid('getSelected');

            if (row){
                $('#dlg').dialog('open').dialog('setTitle','修改信息');
               console.log('row',row);
			   $('#up_repairNumber').textbox('setValue',row.store_no);
			   $('#up_repairName').textbox('setValue',row.store_name);
			   $('#up_contract').textbox('setValue',row.contact);
			   $('#up_tel').textbox('setValue',row.tel);
			   $('#up_phone').textbox('setValue',row.mobile);
			    $('#up_address').textbox('setValue',row.address);
				$('#up_remark').textbox('setValue',row.remark);
				$('#up_repairId').val(row.store_id);
            }
        };
		function reload(){
			$.ajax({
                url: '../ajaction/v1/?menuid=101110&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    var obj = eval(data);
                    $("#dg").datagrid("loadData", data.rows);
                    console.log('data', obj);
                }
            });
		}
		function deletData(index){
			 $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                var id = row.store_id;
                $('#alarm').dialog('open').dialog('setTitle', '提示');
                $('#sure').bind('click', function() {
                    $.ajax({
                        url: '../ajaction/v1/?menuid=101110&cmd=del',
                        type: 'post',
                        data: {
                            'store_id': id
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
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
        <input type="text" id="xiuli_name" placeholder="修理厂名称"/> 
         <?php $operlist=explode(',',$_SESSION['OperList']); if(in_array('查看',$operlist)){?><button id="search">搜索</button><?php }?>
         <?php if(in_array('添加',$operlist)){?><button id="add" style="float: right;margin-top: 15px;">增加</button><?php }?>
    </div>
    <table id="dg" class="easyui-datagrid"
           url="../ajaction/v1/?menuid=101110&cmd=qry&t=1" striped="true" rownumbers="false" pagination="true" singleSelect="true">
        <thead>
        <tr>
            <th data-options="field:'store_no',width:'10%'">修理厂编号</th>
            <th data-options="field:'store_name',width:'10%'">修理厂名称</th>
            <th data-options="field:'contact',width:'10%'">联系人</th>
            <th data-options="field:'mobile',width:'10%'">联系电话</th>
            <th data-options="field:'tel',width:'10%'">手机号码</th>
            <th data-options="field:'address',width:'20%'">详细地址</th>
            <th data-options="field:'remark',width:'20%'">说明</th>
            <th data-options="field:'_operate',width:'10%',formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
    
    <div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#upbtn_dlg'" style="width:700px;height: 400px;background-color: #bdc4d4">
	<div style="background-color: #ffffff;height:340px;margin:10px;">
        <span id="message">基本信息</span>
        <table id="cc" style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
            <tr>
                <td>
                    修理厂编号：
					</td>
					<td>
					   <input id="up_repairId" style="display:none; width: 150px;" />
                       <input id="up_repairNumber" class="easyui-textbox" style="width: 150px;" required="true" />
                </td>
                <td>
                    修理厂名称：
					</td>
					<td>
                     <input id="up_repairName" class="easyui-textbox" style="width: 150px;" required="true" />
                </td>
            </tr>
            <tr>
                <td>
                    联系人:
					</td>
                <td>
                     <input id="up_contract" class="easyui-textbox" style="width: 150px;" required="true" />
                </td>
				<td>
                    联系&nbsp;电话:
					</td>
                <td>
                     <input id="up_tel" class="easyui-textbox" style="width: 150px;" required="true" />
                </td>
            </tr>
            <tr>
                <td>
                    手机号码：
					</td>
                <td>
                     <input id="up_phone" class="easyui-textbox" style="width: 150px;" required="true" />
                </td>
				 <td>
                    详细地址：
					</td>
                <td>
                     <input id="up_address" class="easyui-textbox" style="width: 150px;" required="true" />
                </td>

            </tr>
			<tr>
                <td>
				   备注：
				   </td>
				   <td colspan="3">
                      <input id="up_remark" class="easyui-textbox" style="width: 470px;" />
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
    <div id="addUser" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#btn_dlg'" style="width:700px;height: 400px;background-color: #bdc4d4;">
<div style="background-color: #ffffff;height:340px;margin:10px;">       
	   <span id="addMessage">基本信息</span>
        <table  style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
             <tr>
                <td>
                    修理厂编号：
					</td>
                <td>
                      <input id="repairNumber" class="easyui-textbox" style="width: 150px;" required="true" />
                </td>
                <td>
                    修理厂名称：
					</td>
                <td>
                     <input id="repairName" class="easyui-textbox" style="width: 150px;" required="true" />
                </td>
            </tr>
            <tr>
                <td>
                    联系人：
					</td>
                <td>
                     <input id="contract" class="easyui-textbox" style="width: 150px;" required="true" />
                </td>
				<td>
                    联系电话：
					</td>
                <td>
                     <input id="tel" class="easyui-textbox" style="width: 150px;" required="true" />
                </td>
            </tr>
            <tr>
                <td>
                    手机号码：
					</td>
                <td>
                     <input id="phone" class="easyui-textbox" style="width: 150px;" required="true" />
                </td>
				 <td>
                    详细地址：
					</td>
                <td>
                     <input id="address" class="easyui-textbox" style="width: 150px;" required="true" />
                </td>

            </tr>
			<tr>
                <td >
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

            <span style="font-size:14px;color:#333333;font-weight: bold;display: inline-block;height: 78px;line-height: 78px;">修理厂删除无法恢复，确定删除？</span>
        <div  style="width:100%;">
            <button id="sure"></button>
            <button id="cancel"></button>
        </div>
        </div>
    </div>
</div>
</body>
</html>