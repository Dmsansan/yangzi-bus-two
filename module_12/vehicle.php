<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车辆维护</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
  <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
    <script type="text/javascript">
	    function Option(value, row, index) {
            return '<a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px;" onclick="uninstallData('+index+')">卸载轮胎</a>';
			}
		
       
        function uninstallData(index) {
            $('#tire_dg').datagrid('selectRow', index);
            var row = $('#tire_dg').datagrid('getSelected');
            if (row){
				var tire_id = row.tire_id;
                $('#tire_alarm').dialog('open').dialog('setTitle','卸载轮胎');
				$('#tire_sure').on('click',function(){	
					$.ajax({
						url:'../ajaction/v1/?menuid=121011&cmd=removeTire',
						dataType:'json',
						type:'post',
						data:{'tire_id':tire_id},
						success:function(data){
							console.log('jieshu',data);
						}
					});
				})
            }
        }
			
		$(function(){
			
			$('#tire_cancel').bind('click',function(){
				$('#tire_alarm').dialog('close');
			});
			
			$('#tire_close').bind('click',function(){
				$('#tire_dlg').dialog('close');
			});
			
			$('#add').on('click',function(){
				  $('#addUser').dialog('open').dialog('setTitle', '新增车辆');
			});
			
			//增加功能
			$('#save').bind('click',function(){
				var plate_no=$('#tireNumber').textbox('getText');
				var wheel_count_val=$('#tire_count').combobox('getText');
				var terminal_id_val=$('#tireVehicle').combobox('getValue');
				var remark=$('#remark').combobox('getText');
				$.ajax({
					url:'../ajaction/v1/?menuid=121010&cmd=add',
					type:'POST',
					data:{'plate_no':plate_no,'wheel_count_val':wheel_count_val,'terminal_id_val':terminal_id_val,'remark':remark},
					success:function(data){
						console.log('haha',data);
						reload();
						$('#addUser').dialog('close');
						
					}
					
				})
			})
			$('#tireVehicle').combobox({
				valueField:'v_term_id',
				textField:'v_term_no',
			});
			$('#tire_count').combobox({
				url:'../css/homepagecss/chelun.json',
				valueField:'id',
				textField:'text',
				onSelect:function(rec){
					
				}
			});
			$('#up_tireVehicle').combobox({
				valueField:'v_term_id',
				textField:'v_term_no',
			});
			$('#up_tireCount').combobox({
				url:'../css/homepagecss/chelun.json',
				valueField:'id',
				textField:'text',
			});
			//加载安装位置：
			$('#tire_pr').combobox({
				valueField:'id',
				textField:'name',
			})
			//加载全部车载终端；
			$.ajax({
                url: '../ajaction/v1/?menuid=101115&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                   var msg=data.Rows;
				   $('#tireVehicle').combobox('loadData',msg);
				    $('#up_tireVehicle').combobox('loadData',msg);
                    
                    
                    console.log('data', data);
                }
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
			$.ajax({
				url:'../ajaction/v1/?menuid=121010&cmd=qry&t=1',
				type:'GET',
				dataType:'json',
				success:function(data){
					 $("#dg").datagrid("loadData", data.Rows);
					console.log('ddd',data);
				}
			});
			//修改记录
			$('#updata_save').bind('click',function(){
				var plate_no=$('#up_tireNumber').textbox('getText');
				var wheel_count_val=$('#up_tireCount').combobox('getText');
				var terminal_id_val=$('#up_tireVehicle').combobox('getValue');
				var remark=$('#up_remark').combobox('getText');
				$.ajax({
					url:'../ajaction/v1/?menuid=121010&cmd=edit',
					type:'post',
					data:{'plate_no':plate_no,'wheel_count_val':wheel_count_val,'terminal_id_val':terminal_id_val,'remark':remark},
					success:function(data){
						reload();
					 $('#dlg').dialog('close');	
					}
				})
			});
			
			//安装轮胎
			$('#install_tire').on('click',function(){
				 var row = $('#dg').datagrid('getSelected');
				 if(row==null){
					 $.messager.alert('警告','没有选中车辆','info');
				 }else{
					$('#tire_dlg').dialog('open').dialog('setTitle','安装轮胎');
					var plateNumber=row.plate_no;
					saveTire(plateNumber);
					var wheelcount=row.wheel_count;
	
				 }
				 		
			console.log('dddd',row);
			});
			$('#tire_sensor').combobox({
				valueField:'id',
				textField:'name',
			})
			//加载轮胎胎号
			$('#tire_all').combobox({
				valueField:'id',
				textField:'name',
				onSelect:function(rec){
					var id=rec.id;
					getTireCount("../ajaction/v1/?menuid=0&cmd=get_all_tire&tire_param_id="+id);
				}
			});
			
			$.ajax({
				url:'../ajaction/v1/?menuid=0&cmd=get_all_tireparam',
				dataType:'json',
				success:function(data){
					console.log('sssa',data);
					$('#tire_all').combobox('loadData',data.items);
				}
			});
			$('#tire_pr').combobox({
				url:'../css/homepagecss/tireweizhi.json',
				valueField:'id',
				textField:'text',
			})
			//点击车辆列表
			$('#dg').datagrid({
				onSelect:function(index,data){
					var number=data.plate_no;
					loadgrid(number);					
				}
			})
			
			
		})
		//获取轮胎胎号
		function getTireCount(curl){
		$.ajax({
			url:curl,
			dataType:'json',
			type:'post',
			success:function(data){
				if(data.status!='OK'){
					$.messager.alert('警告','没有轮胎','info');
				}else{
					$('#tire_sensor').combobox('loadData',data.items);
				}
			}
		})
		}
		function saveTire(plateNumber){
		$('#tire_save').on('click',function(){
				 var tire_id_val=$('#tire_sensor').combobox('getValue');
				 var plate_no=plateNumber; 
				var place_no_val=$('#tire_pr').combobox('getText');			
			//绑定轮胎
			$.ajax({
					url:'../ajaction/v1/?menuid=121011&cmd=addtire&plate_no='+plate_no+'&tire_id_val='+tire_id_val+'&place_no_val='+place_no_val,
					dataType:'json',
					type:'post',
					success:function(data){
						console.log('lll',data);
						if(data.status!='OK'){
							$.messager.alert('警告','错误','info');
						}else{
							alert('成功');
						}
					}
				});
			})
		}
		//加载数据
		function loadgrid(plateNumber){
			var plate_no =plateNumber;
			$.ajax({
				url:'../ajaction/v1?menuid=121011&cmd=qry&plate_no='+plate_no,
				dataType:'json',
				type:'GET',
				success:function(data){
					console.log('success',data);
					
					$('#tire_dg').datagrid('loadData',data.Rows);
					
				}
			})
		} 

        function formatOption(value, row, index) {
            return '<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px; margin-left:20px;" onclick="editUser('+index+')">编辑</a> <a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:6px;" onclick="deletData('+index+')">删除</a>';
        }
      //修改车辆记录
        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if (row){
				console.log('ltdata',row);
                $('#dlg').dialog('open').dialog('setTitle','修改记录');
				$('#up_tireNumber').textbox('setValue',row.plate_no);
				$('#up_tireVehicle').combobox('setValue',row.v_term_no);
				$('#up_tireCount').combobox('setValue',row.wheel_count);
				$('#up_remark').textbox('setValue',row.remark);
				
            }
        }
		//删除车辆记录
		function deletData(index){
			 $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
			if(row){
				$('#alarm').dialog('open').dialog('setTitle','删除记录');
				var plate_no=row.plate_no;
				$('#sure').bind('click',function(){
					$.ajax({
						url:'../ajaction/v1/?menuid=121010&cmd=del ',
						type:'POST',
						data:{'plate_no':plate_no},
						success:function(data){
							reload();
							$('#alarm').dialog('close');
							console.log('delete',data);
						}
					})
				})
				
			}
		}
      
		function reload(){
			$.ajax({
				url:'../ajaction/v1/?menuid=121010&cmd=qry&t=1',
				type:'GET',
				dataType:'json',
				success:function(data){
					 $("#dg").datagrid("loadData", data.Rows);
				}
			});
		}
    </script>
	<style>
	#toolbar button{
		border: 1px solid #1c66dc;
		height: 25px;
		line-height: 2px;
		width: 100px;
		background-color: white;
		border-radius: 20px;
		vertical-align: middle;
		color: #1c66dc;
	}
	#toolbar button:active,#toolbar button:hover{
		color:#ffffff;
		background-color:#1c66dc;
	}
	#tire_tb button{
		border: 1px solid #1c66dc;
		height: 25px;
		line-height: 2px;
		width: 100px;
		background-color: white;
		border-radius: 20px;
		vertical-align: middle;
		color: #1c66dc;
	}
	#tire_tb button:active,#tire_tb button:hover{
		color:#ffffff;
		background-color:#1c66dc;
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
	#tire_save{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #tire_save:visited,#tire_save:link{
            background: url("../css/img/ok_normal.png") no-repeat;

        }
        #tire_save:active,#tire_save:hover{
            background: url("../css/img/ok_seleected.png") no-repeat;

        }
        #tire_close{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #tire_close:visited,#tire_close:link{
            background: url("../css/img/cancel_normal.png") no-repeat;

        }
        #tire_close:active,#tire_close:hover{
            background: url("../css/img/cancel_selected.png") no-repeat;

        }
		 #tire_sure{
            height: 25px;
            width: 60px;
            border: none;
            margin-right: 11px;
            background: url("../css/img/yes_normal.png") no-repeat;
        }
        #tire_sure:visited,#tire_sure:link{
            background: url("../css/img/yes_normal.png") no-repeat;
        } 
        #tire_sure:hover,#tire_sure:active{
            background: url("../css/img/yes_highlighted.png") no-repeat;
        }
        #tire_cancel{
            height: 25px;
            width: 60px;
            border: none;
            background: url("../css/img/no_normal.png") no-repeat;
        }
        #tire_cancel:visited,#tire_cancel:link{
            background: url("../css/img/no_normal.png") no-repeat;
        }
        #tire_cancel:hover,#tire_cancel:active{
            background: url("../css/img/no_highlighted.png") no-repeat;
        }
      
	</style>
</head>
<body class="easyui-layout" style="height: 100%; width: 100%;" >
<div data-options="region:'west',title:'车辆列表'" style="width:40%">
    <div style="width: 100%;height:49%;" title="车辆列表">
        <table id="dg" class="easyui-datagrid" style="width: 100%;"
               toolbar="#toolbar" singleSelect="true" fitColumns="true" striped="true">
            <thead>
            <tr>
                <th field="plate_no" width="20%" >车牌号码</th>
                <th field="v_term_no" width="25%" >车载编号</th>
                <th field="remark" width="25%" >备注</th>
                <th field="name4" width="30%" formatter="formatOption">操作</th>
            </tr>
            </thead>
        </table>
       <div id="toolbar" style="margin-bottom: 10px;margin-top: 10px;height:54px; background-color: white;padding-left: 19px;padding-right:39px;padding-top:15px">
           
            <div id="t-bottom">
                <input data-options="prompt:'车牌号码'" class="easyui-textbox" />
                <span> 起始日期：</span> <input id="startDate" type="text" class="easyui-datebox" required="required">
                <span> 终止日期：</span> <input id="stopDate" type="text" class="easyui-datebox" required="required">
                <button style="display: inline-block;margin-right: 10px;margin-left: 10px;">搜索</button>
				<button id="add" style="display: inline-block; float:right;margin-right: 10px;">增加</button>
            </div>
        </div>
        </div>
   

</div>
<div data-options="region:'center',title:'轮胎列表'"> 
<table id="tire_dg" class="easyui-datagrid" width="100%" style="background-color: #ffb3b3" style="padding-top:20px;"
       toolbar="#tire_tb" singleSelect="true" fitColumns="true" striped="true">
    <thead style="width: 100%">
    <tr>
        <th field="place" width="10%" >轮胎位置</th>
        <th field="sensor_no" width="10%" >传感器编号</th>
        <th field="factory_code" width="10%" >轮胎号码</th>
        <th field="brand_name" width="10%" >品牌</th>
        <th field="norms" width="10%" >规格/层级/花纹</th>
        <th field="speed_ul" width="10%" >速度上限</th>
        <th field="temp_ul" width="10%" >温度上限</th>
        <th field="pressure_ul" width="10%" >胎压上限</th>
		<th field="pressure_ll" width="10%" >胎压下限</th>
        <th field="name6" width="10%"  formatter="Option">操作</th>
    </tr>
    </thead>
</table>
    <div id="tire_tb" sstyle="margin-bottom: 10px;margin-top: 50px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
    <div style="margin-bottom: 20px;height: 30px;">
	   	<button id="install_tire" style="display: inline-block; float:right;margin-right: 10px;margin-top:10px"><span style="color:blue;font-size:14px;">+</span>安装轮胎</button>
    </div>
    </div>

	 <div id="tire_dlg" class="easyui-dialog" data-options="closed:true" style="width:450px;height: 300px;background-color: #bdc4d4">
        <div style="background-color: #ffffff;height:240px;margin:10px;">
             <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
            <table style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        规格/层级/花纹：
						</td>
				<td>
                        <input id="tire_all" class="easyui-combobox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        轮胎胎号：
						</td>
				<td>
                        <input id="tire_sensor"  style="width: 150px;" />
                    </td>
				</tr>
                <tr>	
                    <td>
                        安装位置：
						</td>
				<td>
                        <input id="tire_pr" class="easyui-combobox" style="width: 150px;" />
                    </td>

                </tr>
				<tr style="text-align: center">
				

				<td>
					<button id='tire_save' style="margin-top:10px;"></button>
				</td>
				<td>
					<button id='tire_close' style="margin-top:10px;"></button>
				</td>
				
			</tr>
            </table>
        </div>
    </div>
	 <div id="tire_alarm" class="easyui-dialog" style="text-align: center;width:310px;height: 163px;background-color: #bdc4d4" data-options="closed:true,modal:true" >
        <div style="background-color: #ffffff;height:121px;margin:1px;">

            <span style="font-size:14px;color:#333333;font-weight: bold;display: inline-block;height: 78px;line-height: 78px;">数据删除无法恢复，确定删除？</span>
        <div  style="width:100%;">
            <button id="tire_sure"></button>
            <button id="tire_cancel"></button>
        </div>
        </div>
    </div>
	
	

</div>

 <div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true,iconCls:'icon-add2'" style="width:650px;height:220px;background-color: #bdc4d4">
		<div style="background-color: #ffffff;height:160px;margin:10px;">           
               <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">其他信息</span>
            <table style="width: 100%;height:28%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        车牌号码：
						 </td>
                    <td>
                        <input id="up_tireNumber" class="easyui-textbox" style="width: 150px;" />
                    </td>
                    <td>
                        车载终端：
						 </td>
                    <td>
                        <input id="up_tireVehicle" class="easyui-combobox"  style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        车轮数：
						 </td>
                    <td>
                        <input id="up_tireCount" class="easyui-combobox"  style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        备注：
					</td>
                    <td colspan="3">
                        <input id="up_remark" class="easyui-textbox" style="width:450px;" />
                    </td>
                </tr>
				<tr style="text-align: center;margin-top:15px;">
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
 <div id="addUser" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#btn_dlg'" style="width:600px;height: 200px;background-color: #bdc4d4">
		<div style="background-color: #ffffff;height:140px;margin:10px;">   
               <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
            <table id="aa" style="width: 100%;height:30%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        车牌号码：
                    </td>
                    <td>
                        <input id="tireNumber" class="easyui-textbox" style="width: 150px;" />
                    </td>
                    <td>
                        车载终端：
                    </td>
                    <td>
                        <input id="tireVehicle"  style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        车轮数：
                    </td>
                    <td>
                        <input id="tire_count" class="easyui-combobox" style="width: 150px;" />
                    </td>
                    <td>
                        备注：
                    </td>
                    <td>
                        <input id="remark" class="easyui-textbox" style="width: 150px;" />
                    </td>
                </tr>
               <tr style="text-align: center;margin-top:15px;">
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
	

</body>
</html>