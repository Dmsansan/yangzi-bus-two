<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>传感器管理</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
    <script type="text/javascript">
		$(function(){		
			//批量增加按钮
			$('#addall').on('click',function(){
				$('#addallsensor').dialog('open').dialog('setTitle','批量增加传感器');
			});
			//增加按钮
			$('#add').on('click',function(){
				$('#addSensor').dialog('open').dialog('setTitle','增加传感器信息');
				$('#pressure').textbox('setValue','6.50');
				$('#pressure_high').textbox('setValue','12.50');
				$('#tem').textbox('setValue','-40');
				$('#tem_high').textbox('setValue','125');
			});
			$('#tireNumber').combobox({
				
			})

			$('#cancel').bind('click',function(){
				$('#alarm').dialog('close');
			});
			$('#close').bind('click',function(){
				$('#addSensor').dialog('close');
			});
			$('#updata_close').bind('click',function(){
				$('#dlg').dialog('close');
			});
			
			$('#all_close').bind('click',function(){
				$('#addallsensor').dialog('close');
			});

			//增加传感器
			$('#save').bind('click',function(){
				var sensor_no=$('#sensorNumber').textbox('getText');
				var pressure_ul=$('#pressure_high').textbox('getText');
				var pressure_ll=$('#pressure').textbox('getText');
				var remark=$('#remark').textbox('getText');
				var temp_ul=$('#tem_high').textbox('getText');
				var temp_ll=$('#tem').textbox('getText');
				$.ajax({
					url:'../ajaction/v1/?menuid=111011&cmd=add',
					type:'POST',
					dataType:'json',
					data:{'sensor_no':sensor_no,'pressure_ul':pressure_ul,'pressure_ll':pressure_ll,'remark':remark,'temp_ul':temp_ul,'temp_ll':temp_ll},
					success:function(data){
						$('#addSensor').dialog('close');
						$.messager.show({
								title:'提示',
								msg:'增加成功',
								timeout:3000,
								showType:'slide'
							});
						reload();
					}
				})
			});
            //批量添加传感器
            $('#all_save').bind('click',function(){						
                //alert('2313');
                var sensor_no=$('#all_sensorNumber').textbox('getText');
                var sensor_num=$('#tire_Number').combobox('getValue');
                var pressure_ul=$('#all_pressure_high').textbox('getText');
                var pressure_ll=$('#all_pressure').textbox('getText');
                var remark=$('#all_remark').textbox('getText');
                var temp_ul=$('#all_tem_high').textbox('getText');
                var temp_ll=$('#all_tem').textbox('getText');
                var tire_switch=$('#tire_switch').checked;
                $.ajax({
                    url:'../ajaction/v1/?menuid=111011&cmd=add',
                    type:'POST',
                    dataType:'json',
                    data:{'sensor_no':sensor_no,'pressure_ul':pressure_ul,'pressure_ll':pressure_ll,'remark':remark,'temp_ul':temp_ul,'temp_ll':temp_ll,'sensor_num':sensor_num,'tire_switch':tire_switch},
                    success:function(data){
                       	$('#addallsensor').dialog('close');
						$.messager.show({
								title:'提示',
								msg:'批量增加成功',
								timeout:3000,
								showType:'slide'
							});
						reload();
                    },
                    error:function(){
                        console.log('失败');
                    }
                })
            });
			//搜索操作
			$('#search').on('click',function(){
				var searchcontent=$('searhName').val();
				$.ajax({
				url:'../ajaction/v1/?menuid=111011&cmd=qry',
				type:'POST',
                dataType:'json',
				data:{'sensor_no':searchcontent},
				success:function(data){
                    console.log('gdata',data);
                    $("#dg").datagrid("loadData", data.Rows);
				}
			});
			})
			
			 
		})
		function update(sensorId){
			$('#updata_save').on('click',function(){
				var sensor_no=$('#updata_sensorNumber').textbox('getText');
				var pressure_ul=$('#updata_pressure_high').textbox('getText');
				var pressure_ll=$('#updata_pressure').textbox('getText');
				var remark=$('#updata_remark').textbox('getText');
				var temp_ul=$('#updata_tem_high').textbox('getText');
				var temp_ll=$('#updata_tem').textbox('getText');
				$.ajax({
					url:'../ajaction/v1/?menuid=111011&cmd=edit',
					type:'POST',
					dataType:'json',
					data:{'sensor_id':sensorId,'sensor_no':sensor_no,'pressure_ul':pressure_ul,'pressure_ll':pressure_ll,'remark':remark,'temp_ul':temp_ul,'temp_ll':temp_ll},
					success:function(data){
						console.log('llh',data);
						if(data.status="OK"){
							$.messager.show({
								title:'提示',
								msg:'修改成功',
								timeout:3000,
								showType:'slide'
							});
							reload();
						 $('#dlg').dialog('close');
						}
					}
				});
			})
		}
		function reload(){
			$.ajax({
				url:'../ajaction/v1/?menuid=111011&cmd=qry&t=1',
				type:'GET',
                dataType:'json',
				success:function(data){
                    console.log('getdata',data);
                    $("#dg").datagrid("loadData", data.Rows);
					//console.log('getdata',data);
				}
			});
		}
        function formatOption(value, row, index) {
                return '<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px;" onclick="editUser('+index+')">编辑</a> <a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:5px;" onclick="deletData('+index+')">删除</a>';
        }

        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
			
            var row = $('#dg').datagrid('getSelected');
            if (row){
				console.log('senorrow',row);
                $('#dlg').dialog('open').dialog('setTitle','修改信息');
				$('#updata_sensorNumber').textbox('setValue',row.sensor_no);
				$('#updata_pressure').textbox('setValue',row.pressure_ll);
				$('#updata_pressure_high').textbox('setValue',row.pressure_ul);
				$('#updata_remark').textbox('setValue',row.remark);
				$('#updata_tem').textbox('setValue',row.temp_ll);
				$('#updata_tem_high').textbox('setValue',row.temp_ul);
				var sensor_id=row.sensor_id;
				update(sensor_id);
			
            }
        }
		function deletData(index){
			 $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
			if(row){
				$('#alarm').dialog('open').dialog('setTitle','提示');
				var sensor_id=row.sensor_id;
				$('#sure').on('click',function(){
					$.ajax({
						url:'../ajaction/v1/?menuid=111011&cmd=del',
						dataType:'json',
						type:'POST',
						data:{'sensor_id':sensor_id},
						success:function(data){
							$('#alarm').dialog('close');
							$.messager.show({
								title:'提示',
								msg:'删除成功',
								timeout:3000,
								showType:'slide'
							});
							reload();
						}
					})
				})
			}
		}
    </script>
	 <style type="text/css">
	 input{
		-web-kit-appearance:none;
		-moz-appearance: none;
		}
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
<div  class="u-content" style="width:100%;height:554px;">
    <div id="tb" style="padding-bottom: 10px;padding-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 34px;">

        <input id="searhName" type="text" placeholder="传感器代码"/> <button id="search">搜索</button>
      <span style="float: right;">  <button id="addall" >批量增加</button> <button id="add">增加</button><div style="clear:both;"></div></span>

     
    </div>
    <table id="dg" class="easyui-datagrid" style="width:100%,height:400px;" fit="false" 
           url="../ajaction/v1/?menuid=111011&cmd=qry&t=1" rownumbers="false" pagination="true" striped="true">
        <thead>
        <tr>
            <th data-options="field:'sensor_id',width:'10%'">传感器编号</th>
            <th data-options="field:'sensor_no',width:'10%'">传感器代码</th>
            <th data-options="field:'pressure_ul',width:'10%'">胎压上限</th>
            <th data-options="field:'pressure_ll',width:'10%'">胎压下限</th>
            <th data-options="field:'temp_ul',width:'10%'">胎温上限</th>
            <th data-options="field:'temp_ll',width:'10%'">温度下限</th>
            <th data-options="field:'remark',width:'20%'">备注</th>
            <th data-options="field:'_operate',width:'10%',formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
 </div>   
    <div id="dlg" class="easyui-dialog" data-options="closed:true" style="width:600px;height: 360px;background-color: #bdc4d4">
	<div style="background-color: #ffffff;height:300px;margin:10px;">
         <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
        <table style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px">
            <tr>
                <td>
                   传感器编号：
				</td>
                <td>
                    <input id="updata_sensorNumber" class="easyui-textbox" style="width:150px;"/>
                <td>
                    压力测量范围：
					  </td>
                <td>
				 <input id="updata_pressure" class="easyui-textbox"  style="width: 60px;" />至<input id="updata_pressure_high" class="easyui-textbox"  style="width:60px;" />
                   
                </td>
            </tr>
            <tr>
                <td>
                    温度测量范围：
					  </td>
                <td>
				 <input id="updata_tem" class="easyui-textbox" style="width: 60px;" />至<input id="updata_tem_high" class="easyui-textbox" style="width:60px;" />
                </td>
            </tr>
            <tr>
                <td>
                    备注：
					  </td>
                <td colspan="3">
                    <input id="updata_remark" class="easyui-textbox" style="width:410px;"/>
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
	<div id="addSensor" class="easyui-dialog" data-options="closed:true,modal:true,iconCls:'icon-add2'" style="width:600px;height: 360px;background-color: #bdc4d4">
		<div style="background-color: #ffffff;height:300px;margin:10px;">
			 <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
			<table style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px">
            <tr>
                <td>
                   传感器编号：
				     </td>
                <td>
                    <input id="sensorNumber" class="easyui-textbox"   style="width:150px;"/>
                </td>
                <td>
                    压力测量范围：
					  </td>
                <td>
				  <input id="pressure" class="easyui-textbox"  style="width: 60px;" />至<input id="pressure_high" class="easyui-textbox"  style="width:60px;" />
                 
                </td>
            </tr>
            <tr>
                <td>
                    温度测量范围：
					  </td>
                <td>
				  <input id="tem" class="easyui-textbox" style="width: 60px;" />至<input id="tem_high" class="easyui-textbox" style="width:60px;" />
                </td>
            </tr>
            <tr>
                <td>
                    备注：
					  </td>
                <td colspan="3">
                    <input id="remark" class="easyui-textbox" style="width:410px;" />
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
	<div id="addallsensor" class="easyui-dialog" data-options="closed:true,modal:true,iconCls:'icon-add2'" style="width:600px;height: 360px;background-color: #bdc4d4">
		<div style="background-color: #ffffff;height:300px;margin:10px;">
			 <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
			<table style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px">
            <tr>
                <td>
                   传感器编号：
				     </td>
                <td>
                    <input id="all_sensorNumber" class="easyui-textbox" style="width:80px;"/>-<select id="tire_Number" class="easyui-combobox" name="dept" style="width:50px;">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
                </td>
                <td>
                    压力测量范围：
					  </td>
                <td>
				<input id="all_pressure" class="easyui-textbox"  style="width: 60px;" />至<input id="all_pressure_high" class="easyui-textbox"  style="width:60px;" />
                </td>
            </tr>
            <tr>
                <td>
                    温度测量范围：
					  </td>
                <td>
				  <input id="all_tem" class="easyui-textbox" style=" width:60px;" />至<input id="all_tem_high" class="easyui-textbox" style="width:60px;" />
					
                </td>
				<td>
				增加轮胎：
				</td>
				<td>
				<input id="tire_switch" type="checkbox"/>
				</td>
            </tr>
            <tr>
                <td>
                    备注：
					  </td>
                <td colspan="3">
                    <input id="all_remark" class="easyui-textbox" style="width:410px;" />
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

            <span style="font-size:14px;color:#333333;font-weight: bold;display: inline-block;height: 78px;line-height: 78px;">角色删除无法恢复，确定删除？</span>
        <div  style="width:100%;">
            <button id="sure"></button>
            <button id="cancel"></button>
        </div>
        </div>
    </div>
</body>
</html>