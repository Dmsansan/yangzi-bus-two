<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="../jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="../jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../jquery-easyui/jquery.min.js"></script>
    <link href="../jquery-easyui/demo.css" rel="stylesheet" type="text/css">
	  <link href="../css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
    <script src="../jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <script src="../jquery-easyui/locale/easyui-lang-zh_CN.js" type="text/javascript"></script>
	<script type="text/javascript">
	function addTire(){
		$('#dlg').dialog('open').dialog('setTitle','安装轮胎');
	}
	     function formatOption(value, row, index) {
            return '<a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px;" onclick="deletData('+index+')">卸载轮胎</a>';
        }
		
       
        function deletData(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#alarm').dialog('open').dialog('setTitle','新增角色');
              
            }
        }
        $(function () {
				$('#cancel').bind('click',function(){
				$('#alarm').dialog('close');
			});
			
			$('#updata_close').bind('click',function(){
				$('#dlg').dialog('close');
			});
			
            $('#kk').tabs({
                onSelect:function(index){
                    var p = $(this).tabs('getTab', index);
                    p.find('iframe').attr('src','vv.php');
                    console.log('ss',index);
                }
            });
          tab.panel('refresh'); // get selected panel

        })
	</script>
	<style>
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
	</style>
</head>
<body class="easyui-layout" style="width:100%;height:100%;padding-top:20px;	">
<table id="dg" class="easyui-datagrid" url="../jquery-easyui/datagrid_data1.json" width="100%" height="90%" style="background-color: #ffb3b3" style="padding-top:20px;"
       toolbar="#tb" singleSelect="true" fitColumns="true" striped="true">
    <thead style="width: 100%">
    <tr>
        <th field="name1" width="10%" >轮胎位置</th>
        <th field="name2" width="15%" >传感器编号</th>
        <th field="name3" width="10%" >轮胎号码</th>
        <th field="name4" width="10%" >品牌</th>
        <th field="name1" width="10%" >规格/层级/花纹</th>
        <th field="name2" width="10%" >速度上限</th>
        <th field="name3" width="10%" >温度上限</th>
        <th field="name4" width="10%" >胎压上限</th>
        <th field="name6" width="10%"  formatter="formatOption">操作</th>
    </tr>
    </thead>
</table>
    <div id="tb" sstyle="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
    <div style="margin-bottom: 20px;height: 30px;">
	   	<button style="display: inline-block; float:right;margin-right: 10px;margin-top:10px"><span style="color:blue;font-size:14px;">+</span><a style="text-decoration: none;" href="#" onclick="addTire()">安装轮胎</a></button>
    </div>

    </div>
	 <div id="dlg" class="easyui-dialog" data-options="closed:true" style="width:450px;height: 300px;background-color: #bdc4d4">
        <div style="background-color: #ffffff;height:240px;margin:10px;">
             <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
            <table style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        规格/层级/花纹：
						</td>
				<td>
                        <input id="update_all" class="easyui-combobox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        传感器编号：
						</td>
				<td>
                        <input id="update_sensor" class="easyui-combobox" style="width: 150px;" />
                    </td>
				</tr>
                <tr>	
                    <td>
                        花纹深度：
						</td>
				<td>
                        <input id="update_pr" class="easyui-combobox" style="width: 150px;" />
                    </td>

                </tr>
				<tr style="text-align: center">
				

				<td>
					<button id='updata_save' style="margin-top:10px;"><a style="text-decoration: none;" href="#"></a></button>
				</td>
				<td>
					<button id='updata_close' style="margin-top:10px;"><a style="text-decoration: none" href="#"></a></button>
				</td>
				
			</tr>
            </table>
        </div>
    </div>
	 <div id="alarm" class="easyui-dialog" style="text-align: center;width:310px;height: 163px;background-color: #bdc4d4" data-options="closed:true,modal:true" >
        <div style="background-color: #ffffff;height:121px;margin:1px;">

            <span style="font-size:14px;color:#333333;font-weight: bold;display: inline-block;height: 78px;line-height: 78px;">数据删除无法恢复，确定删除？</span>
        <div  style="width:100%;">
            <button id="sure"></button>
            <button id="cancel"></button>
        </div>
        </div>
    </div>

</body>
</html>