<?php
session_start();
$operlist = $_SESSION['OperList'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>轮胎管理</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
			$('#cancel').bind('click',function(){
				$('#alarm').dialog('close');
			});
			$('#close').bind('click',function(){
				$('#addTire').dialog('close');
			});
			$('#updata_close').bind('click',function(){
				$('#dlg').dialog('close');
			});
			
			$('#all_close').bind('click',function(){
				$('#addalltire').dialog('close');
			});
            
            //获取品牌参数
            $.ajax({
                url: '../ajaction/v1/?menuid=0&cmd=get_all_brand',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                   console.log('brand', data);
                    var res = data.items;
                    $("#tireBrand").combobox('loadData',res);
                    $("#update_tireBrand").combobox('loadData',res);
                    $("#all_tireBrand").combobox('loadData',res);
                }
            });
			$('#tireBrand').combobox({
				valueField:'id',
                textField:'name',
                type:'json',
                onSelect:function(res){
                    console.log('res',res);
                    $.ajax({
                        url:'../ajaction/v1/?menuid=0&cmd=get_all_tireparam&brand_id='+res.id,
                        type:'POST',
                        dataType:'json',
                        success:function(data){
                            var res = data.items;
                            $("#all").combobox('loadData',res);
                        }
                    });
                    $("#all").combobox({
                        valueField:'id',
                        textField:'name',
                        type:'json'
                    })
                }
			})
            $('#update_tireBrand').combobox({
                valueField:'id',
                textField:'name',
                type:'json',
                onSelect:function(res){
                    console.log('res',res);
                    $.ajax({
                        url:'../ajaction/v1/?menuid=0&cmd=get_all_tireparam&brand_id='+res.id,
                        type:'POST',
                        dataType:'json',
                        success:function(data){
                            var res = data.items;
                            $("#update_all").combobox('loadData',res);
                            console.log(res);
                        }
                    });
                    $("#update_all").combobox({
                        valueField:'id',
                        textField:'name',
                        type:'json'
                    })
                }
            })

            $('#all_tireBrand').combobox({
                valueField:'id',
                textField:'name',
                type:'json',
                onSelect:function(res){
                    console.log('res',res);
                    $.ajax({
                        url:'../ajaction/v1/?menuid=0&cmd=get_all_tireparam&brand_id='+res.id,
                        type:'POST',
                        dataType:'json',
                        success:function(data){
                            var res = data.items;
                            $("#add_all").combobox('loadData',res);
                            //console.log(res);
                        }
                    });
                    $("#add_all").combobox({
                        valueField:'id',
                        textField:'name',
                        type:'json'
                    })
                }
            })

			//获取未使用的传感器
            $.ajax({
                url:'../ajaction/v1/?menuid=0&cmd=get_all_sensor&state=nouse',
                type:'POST',
                dataType:'json',
                success:function(data){
                    var res=data.items;
                    $("#sensor").combobox('loadData',res);
                    //$("#update_sensor").combobox('loadData',res);
                    console.log(res);
                }
            });
			$('#sensor').combobox({
				valueField:'id',
                textField:'name',
                type:'json'
			})
            
            $("#save").bind('click',function(){
                var factory_code = $("#tireNumber").textbox('getText');
                var brand_id_val = $("#tireBrand").combobox('getValue');
                var norms_id_val = $("#all").combobox('getValue');
                var sensor_id_val = $("#sensor").combobox('getValue');
                var figure_val = $("#pr").textbox('getText');
                $.ajax({
                    url:'../ajaction/v1/?menuid=111110&cmd=add',
                    type:'POST',
                    data:{'factory_code':factory_code,'brand_id_val':brand_id_val,'norms_id_val':norms_id_val,'sensor_id_val':sensor_id_val,'figure_value':figure_val},
                    dataType:'json',
                    success:function(data){
                    if(data.status=="OK"){
                            $.messager.show({
                                    title : '操作成功',
                                    msg:data.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    });
                            reload();
                            $('#addTire').dialog('close');
                        }else{
                            $.messager.show({
                                    title : '操作失败',
                                    msg:data.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    }); 
                        } 
                    }
                });
            });
            //批量添加
            $('#all_save').bind('click',function(){

                var brand_id_val = $('#all_tireBrand').combobox('getValue');
                var norms_id_val = $('#add_all').combobox('getValue');
                //var tire_switch = $('#all_tireNumber').val();
                var figure_mile = $('#all_pr').textbox('getText');
                var ttire_switch=$("input[id='all_tireNumber']").is(':checked');
                //alert(tire_switch);
                var tire_switch;
                if(ttire_switch == false){
                    tire_switch='off';
                }else{
                    tire_switch='on';
                }
                //alert(tire_switch);
                $.ajax({
                    url:'../ajaction/v1/?menuid=111110&cmd=addmore',
                    type:'post',
                    data:{'brand_id_val':brand_id_val,'norms_id_val':norms_id_val,'tire_switch':tire_switch,'figure_mile':figure_mile},
                    dataType:'json',
                    success:function(data){
                        
                        if(data.status=="OK"){
                            $.messager.show({
                                    title : '操作成功',
                                    msg:data.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    });
                            reload();
                            $('#addTire').dialog('close');
                        }else{
                            $.messager.show({
                                    title : '操作失败',
                                    msg:data.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    }); 
                        } 
                    }
                });
            });
            //修改操作：
            $('#updata_save').bind('click',function(){
            var factory_code = $("#update_tireNumber").textbox('getText');
            var brand_id_val = $("#update_tireBrand").combobox('getValue');
            var norms_id_val = $("#update_all").combobox('getValue');
            var sensor_id_val = $("#update_sensor").val();
            var figure_val = $("#update_pr").textbox('getText');
            
            var tire_id = $("#update_tire_id").val();
            //alert(brand_id_val);
            $.ajax({
                    url:'../ajaction/v1/?menuid=111110&cmd=edit',
                    type:'POST',
                    data:{'factory_code':factory_code,'brand_id_val':brand_id_val,'norms_id_val':norms_id_val,'sensor_id_val':sensor_id_val,'figure_value':figure_val,'tire_id':tire_id},
                    dataType:'json',
                    success:function(data){
                    if(data.status=="OK"){
                            $.messager.show({
                                    title : '操作成功',
                                    msg:data.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    });
                            reload();
                            $('#dlg').dialog('close');
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
            //搜索操作
            $('#search').bind('click',function(){
                $("#dg").datagrid('load',{
                factory_code: $('#factory_code').val(),
                sensor_no:$('#sensor_no').val(),
            }); 
            });
			//打开批量增加弹出框
			$('#addall').on('click',function(){
				 $('#addalltire').dialog('open').dialog('setTitle','批量增加轮胎');
                 $.ajax({
                    url:'../ajaction/v1/?menuid=111110&cmd=qry_tireswitch',
                    type:'post',
                    dataType:'json',
                    success:function(data){
                         //console.log(data);
                         $('#all_pr').textbox('setText',data.figure_mile);
                         $('#all_tireBrand').combobox('setValue',data.brand_id);
                         $('#add_all').combobox('setValue',data.tire_param_id);
                         $('#all_tireNumber').attr("checked",true);
                    }
                 });
                
			});
			//打开增加弹出框
			$('#add').on('click',function(){
				
            $('#addTire').dialog('open').dialog('setTitle','新增轮胎');
			$('#pr').textbox('setValue','5');
			})
        })
        
        var operlist='<?php echo $operlist;?>';
        function formatOption(value, row, index) {
            var str='';
           
            if(operlist.indexOf('修改') != -1){
                str+='<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px;" onclick="editUser('+index+')">编辑</a>';
            }
            
            if(operlist.indexOf('删除') != -1){
                str+='<a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:6px;" onclick="deletData('+index+')">删除</a>';
            }
            
            return str;

        }
        function reload(){
             $.ajax({
                url: '../ajaction/v1/?menuid=111110&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    $("#dg").datagrid("loadData", data.rows);

                }
            });
        }
        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if (row){
                //console.log("row", row);
                $('#dlg').dialog('open').dialog('setTitle','轮胎编辑');
                $("#update_tire_id").val(row.tire_id);
                $("#update_sensor").val(row.sensor_id);
                $('#update_tireNumber').textbox('setValue',row.factory_code);
                $('#update_tireBrand').combobox('setValue',row.brand_id).combobox('setText',row.brand_name);
                $('#update_all').combobox('setValue',row.tire_param_id).combobox('setText',row.norms_name+'/'+row.class_name+'/'+row.figure_name);
                //alert(row.sensor_id);
               
                //$('#update_sensor').combobox('setValue',row.sensor_id);
               
                $('#update_pr').textbox('setValue',row.figure_value);
            }
        }
        function deletData(index){
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if(row){
                var tire_id=row.tire_id;
            $('#alarm').dialog('open').dialog('setTitle', '提示');
            $('#sure').bind('click', function() {
                    $.ajax({
                        url: '../ajaction/v1/?menuid=111110&cmd=del',
                        type: 'post',
                        dataType:'json',
                        data: {
                            'tire_id': tire_id
                        },
                        success: function(data) {
                            if(data.status=="OK"){
                            $.messager.show({
                                    title : '操作成功',
                                    msg:data.reason,
                                    timeout:3000,
                                    showType:'show',  
                                    });
                            reload();
                            $('#alarm').dialog('close');
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
                })
            }
        }
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
        #all_save{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #all_save:visited,#all_save:link{
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #all_save button:active,#all_save button:hover{
            background: url("../css/img/ok_seleected.png") no-repeat;

        }
        #all_close{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #all_close:visited,#all_close:link{
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #all_close button:active,#all_close button:hover{
            background: url("../css/img/cancel_selected.png") no-repeat;

        }
    </style>
</head>
<body class="easyui-layout" style="width: 100%;height: 100%;background-color: #ffffff;overflow-y: auto;">
<div  class="u-content">
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
        <input id="factory_code" type="text" placeholder="轮胎编号"/>
        <input id="sensor_no" type="text" placeholder="传感器编号"/> 
         <?php $operlist=explode(',',$_SESSION['OperList']); if(in_array('查看',$operlist)){?><button id="search">搜索</button><?php }?>
        <?php if(in_array('添加',$operlist)){?> <button id="addall" style="float: right;margin-top: 15px;">批量增加</button> <button id="add" style="float: right;margin-top: 15px;margin-right:10px;">增加</button><?php }?>
    </div>
    <table id="dg" class="easyui-datagrid"
          url="../ajaction/v1/?menuid=111110&cmd=qry&t=1" rownumbers="false" pagination="true" striped="true" singleSelect="true">
        <thead>
        <tr>
            <th data-options="field:'tire_id',width:'8%'">编号</th>
            <th data-options="field:'factory_code',width:'8%'">轮胎编号</th>
            <th data-options="field:'sensor_no',width:'8%'">传感器编号</th>
            <!--<th data-options="field:'store_name',width:'10%'">归属厂</th>-->
            <th data-options="field:'norms_name',width:'10%'">轮胎规格</th>
            <th data-options="field:'class_name',width:'8%'">层级</th>
            <th data-options="field:'figure_name',width:'8%'">花纹</th>
			<th data-options="field:'figure_value',width:'10%'">花纹深度(Cm)</th>
            <th data-options="field:'brand_name',width:'8%'">品牌</th>
            <th data-options="field:'status',width:'10%'">状态</th>
            <th data-options="field:'speed_ul',width:'10%'">速度上限(Km/h)</th>
            <th data-options="field:'temp_ul',width:'10%'">温度上限(℃)</th>
            <th data-options="field:'pressure_ul',width:'10%'">胎压上限(Kg)</th>
            <th data-options="field:'pressure_ll',width:'10%'">胎压下限(Kg)</th>
            <th data-options="field:'mile_count',width:'10%'">总里程(Km)</th>
            <th data-options="field:'bf',width:'10%',styler:cellStyler">是否报废</th>
            <th data-options="field:'_operate',width:'12%',formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
    <script type="text/javascript">
        function cellStyler(value,row,index){
            if (value == '是'){
                return 'background-color:#ffee00;color:red;';
            }
        }
    </script>
    <div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true" style="width:750px;height: 400px;background-color: #bdc4d4">
        <div style="background-color: #ffffff;height:340px;margin:10px;">
             <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
            <table style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        轮胎编码：
						</td>
                    <td>
                        <input id="update_tire_id" type="text" style="display:none">
                        <input id="update_sensor" type="text" style="display:none">
                        <input id="update_tireNumber" class="easyui-textbox" style="width: 150px;" required="true" />
                    </td>
                    <td>
                        品牌：
						</td>
                    <td>
                        <input id="update_tireBrand" class="easyui-combobox" style="width: 150px;" required="true" />
                    </td>
                </tr>
                <tr>
                    <td >
                        规格/层级/花纹：
						</td>
                    <td colspan="3">
                        <input id="update_all" class="easyui-combobox"  style="width: 430px;" required="true" />
                    </td>
                </tr>
                <tr>
                    <!--<td>
                        传感器编号：
						</td>
                    <td>
                        <input id="update_sensor" class="easyui-combobox" style="width: 150px;" />
                    </td>-->
                    <td>
                        花纹深度：
						</td>
                    <td>
                        <input id="update_pr" class="easyui-textbox" style="width: 150px;" required="true" />
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
    <div id="addTire" class="easyui-dialog" data-options="closed:true,modal:true" style="width:650px;height: 400px;background-color: #bdc4d4">
        <div style="background-color: #ffffff;height:340px;margin:10px;">
             <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
            <table style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        轮胎编码：
                    </td>
                    <td>
                        <input id="tireNumber" class="easyui-textbox"  style="width: 150px;" required="true" />
                    </td>
                    <td>
                        品牌：
							</td>
                    <td>
                        <input id="tireBrand" class="easyui-combobox" style="width: 150px;" required="true" />
                    </td>
                </tr>
                <tr>
                    <td>
                        规格/层级/花纹：
                    </td>
                    <td colspan="3">
                        <input id="all" class="easyui-combobox" style="width: 430px;" required="true" />
                    </td>
                </tr>
                <tr>
                    <td>
                        传感器编号：
                    </td>
                    <td>
                        <input id="sensor" class="easyui-combobox" style="width: 150px;" required="true" />
                    </td>
                    <td>
                        花纹深度：
                    </td>
                    <td>
                        <input id="pr" class="easyui-textbox" style="width: 150px;" required="true" />
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
    <div id="addalltire" class="easyui-dialog" data-options="closed:true,modal:true,iconCls:'icon-add2'" style="width:650px;height: 300px;background-color: #bdc4d4">
        <div style="background-color: #ffffff;height:240px;margin:10px;">
           <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
            <table style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        入库开关：
                    </td>
                    <td>
                        <input id="all_tireNumber"  style="width: 50px;" type="checkbox" required="true" />
                    </td>
                    <td>
                        品牌：
					</td>
                    <td>
                        <input id="all_tireBrand"  class="easyui-combobox" style="width: 200px;" required="true" />
                    </td>
                </tr>
                <tr>
                    <td>
                        规格/层级/花纹：
                    </td>
                    <td>
                        <input id="add_all" class="easyui-combobox" style="width: 150px;" required="true" />
                    </td>
                    <td>
                        花纹深度：
                    </td>
                    <td>
                        <input id="all_pr" class="easyui-textbox" style="width: 150px;" required="true" />
                    </td>
                </tr>
				<tr style="text-align: center">
						<td>
						</td>
						<td>
							<button id='all_save' style="margin-top:10px;"><a style="text-decoration: none;" href="#"></a></button>
						</td>
						<td>
							<button id='all_close' style="margin-top:10px;"><a style="text-decoration: none" href="#"></a></button>
						</td>
						<td>
						</td>
				</tr>
            </table>
        </div>
    </div>
     <div id="alarm" class="easyui-dialog" style="text-align: center;width:310px;height: 163px;background-color: #bdc4d4" data-options="closed:true,modal:true" >
        <div style="background-color: #ffffff;height:121px;margin:1px;">

            <span style="font-size:14px;color:#333333;font-weight: bold;display: inline-block;height: 78px;line-height: 78px;">轮胎删除无法恢复，确定删除？</span>
        <div  style="width:100%;">
            <button id="sure"></button>
            <button id="cancel"></button>
        </div>
        </div>
    </div>
</div>
</body>
</html>