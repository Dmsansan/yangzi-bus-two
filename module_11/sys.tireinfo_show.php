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
                            console.log(res);
                        }
                    });
                    $("#all").combobox({
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
                var figure_id_val = $("#pr").textbox('getText');
                $.ajax({
                    url:'../ajaction/v1/?menuid=111110&cmd=add',
                    type:'POST',
                    data:{'factory_code':factory_code,'brand_id_val':brand_id_val,'norms_id_val':norms_id_val,'sensor_id_val':sensor_id_val,'figure_id_val':figure_id_val},
                    dataType:'json',
                    success:function(data){
                        console.log(data);
                    }
                });
            });
			$('#updata_tireBrand').combobox({
				
			})
			$('#update_all').combobox({
				
			})
			$('#updata_sensor').combobox({
				
			})
			$('#all_tireBrand').combobox({
				
			
			});
			$('#all_all').combobox({
				
			
			});
			//打开批量增加弹出框
			$('#addall').on('click',function(){
				 $('#addalltire').dialog('open').dialog('setTitle','批量增加轮胎');
			});
			//打开增加弹出框
			$('#add').on('click',function(){
				
            $('#addTire').dialog('open').dialog('setTitle','新增轮胎');
			$('#pr').textbox('setValue','500');
			})
        })
        function formatOption(value, row, index) {
            return '<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px; " onclick="editUser('+index+')">编辑</a> <a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:6px;" onclick="deletData('+index+')">删除</a>';
        }

        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','新增角色');
               
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
<body class="easyui-layout" style="width: 100%;height: 100%;background-color: #ffffff;overflow: auto;">
<div  class="u-content">
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
        <input type="text" placeholder="轮胎编号"/> <button>搜索</button>
        <button id="addall" style="float: right;margin-top: 15px;">批量增加</button> <button id="add" style="float: right;margin-top: 15px;margin-right:10px;">增加</button>
    </div>
    <table id="dg" class="easyui-datagrid"
          url="../ajaction/v1/?menuid=111110&cmd=qry&t=1" rownumbers="false" pagination="true" striped="true">
        <thead>
        <tr>
            <th data-options="field:'tire_id',width:'8%'">编号</th>
            <th data-options="field:'factory_code',width:'8%'">轮胎编号</th>
            <th data-options="field:'sensor_no',width:'8%'">传感器编号</th>
            <!--<th data-options="field:'store_name',width:'10%'">归属厂</th>-->
            <th data-options="field:'norms_name',width:'10%'">轮胎规格</th>
            <th data-options="field:'class_name',width:'8%'">层级</th>
            <th data-options="field:'figure_name',width:'8%'">花纹</th>
            <th data-options="field:'brand_name',width:'8%'">品牌</th>
            <th data-options="field:'status',width:'10%'">状态</th>
            <th data-options="field:'speed_ul',width:'10%'">速度上限</th>
            <th data-options="field:'temp_ul',width:'10%'">温度上限</th>
            <th data-options="field:'pressure_ul',width:'10%'">胎压上限</th>
            <th data-options="field:'pressure_ll',width:'10%'">胎压下限</th>
            <th data-options="field:'mile_count',width:'10%'">总里程</th>
            <th data-options="field:'_operate',width:'10%',formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
    
    <div id="dlg" class="easyui-dialog" data-options="closed:true" style="width:750px;height: 400px;background-color: #bdc4d4">
        <div style="background-color: #ffffff;height:340px;margin:10px;">
             <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
            <table style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        轮胎编码：
						</td>
                    <td>
                        <input id="update_tireNumber" class="easyui-combobox" style="width: 150px;"/>
                    </td>
                    <td>
                        品牌：
						</td>
                    <td>
                        <input id="update_tireBrand" class="easyui-combobox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td >
                        规格/层级/花纹：
						</td>
                    <td colspan="3">
                        <input id="update_all"  style="width: 430px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        传感器编号：
						</td>
                    <td>
                        <input id="update_sensor" class="easyui-combobox" style="width: 150px;" />
                    </td>
                    <td>
                        花纹深度：
						</td>
                    <td>
                        <input id="update_pr" class="easyui-combobox" style="width: 150px;" />
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
    <div id="addTire" class="easyui-dialog" data-options="closed:true" style="width:650px;height: 400px;background-color: #bdc4d4">
        <div style="background-color: #ffffff;height:340px;margin:10px;">
             <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
            <table style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        轮胎编码：
                    </td>
                    <td>
                        <input id="tireNumber" class="easyui-textbox"  style="width: 150px;"/>
                    </td>
                    <td>
                        品牌：
							</td>
                    <td>
                        <input id="tireBrand" class="easyui-combobox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        规格/层级/花纹：
                    </td>
                    <td colspan="3">
                        <input id="all" class="easyui-combobox" style="width: 430px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        传感器编号：
                    </td>
                    <td>
                        <input id="sensor" class="easyui-combobox" style="width: 150px;" />
                    </td>
                    <td>
                        花纹深度：
                    </td>
                    <td>
                        <input id="pr" class="easyui-textbox" style="width: 150px;" />
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
                        <input id="all_tireNumber" style="width: 50px;" type="checkbox"/>
                    </td>
                    <td>
                        品牌：
						</td>
                    <td>
                        <input id="all_tireBrand" style="width: 200px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        规格/层级/花纹：
                    </td>
                    <td colspan="3">
                        <input id="all_all" style="width: 400px;" />
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
</div>
</body>
</html>