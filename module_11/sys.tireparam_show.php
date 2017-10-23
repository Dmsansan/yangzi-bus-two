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
    <script type="text/javascript">
	 function addUser() {
            $('#addUser').dialog('open').dialog('setTitle','新增轮胎参数');
        };
		$(function(){
			$.ajax({
                url: '../ajaction/v1/?menuid=0&cmd=get_all_norms',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                   console.log('brand', data);
          
                }
            });
			$('#brand').combobox({
				
			});
			$('#tire').combobox({
				
			});
			$('#pr').combobox({
				
			});
			$('#figure').combobox({
				
			});
			
			
			
			
		})
        function formatOption(value, row, index) {
                return '<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px; margin-left:20px;" onclick="editUser('+index+')">编辑</a> <a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:6px;" onclick="deletData('+index+')">删除</a>';
        }
        var url;
        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','修改轮胎参数');
                $('#fm').form('load',row);
         
            }
        };
		function deletData(index){
			
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
		
	</style>
</head>
<body class="easyui-layout" style="width: 100%;height: 100%;background-color: #ffffff">

    <table id="dg" class="easyui-datagrid"
           data-options="singleSelect:true,toolbar:'#tb',striped:'true',pagination:'true'">
        <thead>
        <tr>
            <th data-options="field:'itemid',width:'8%'">编号</th>
            <th data-options="field:'productid',width:'8%'">制造商</th>
            <th data-options="field:'listprice',width:'8%'">品牌</th>
            <th data-options="field:'unitcost',width:'8%'">轮胎规格</th>
            <th data-options="field:'listprice',width:'8%'">层级</th>
            <th data-options="field:'unitcost',width:'8%'">花纹</th>
            <th data-options="field:'listprice',width:'8%'">胎压上限</th>
            <th data-options="field:'unitcost',width:'8%'">胎压下限</th>
            <th data-options="field:'listprice',width:'10%'">胎温上限</th>
            <th data-options="field:'unitcost',width:'10%'">速度上限</th>
            <th data-options="field:'listprice',width:'10%'">TKPH值</th>
            <th data-options="field:'_operate',width:'10%',formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">
    <input type="text" placeholder="角色名称"/> <button>搜索</button>
    <button style="float: right; margin-top: 15px;"><a style="text-decoration: none;" href="#" onclick="addUser()">增加</a></button>
</div>
    <!--修改信息弹出框 -->  
	<div id="dlg" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#updata_dlg'" style="width:650px;height: 300px;background-color: #bdc4d4">
    <div style="background-color: #ffffff;height:340px;margin:10px;">
    <span id="addMessage">基本信息</span>
    <table id="aa" style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
        <tr>
            <td>
                制造商：
				</td>
            <td>
                <input id="updata_pm" class="easyui-textbox" style="width:130px;" type="text"/>
            </td>
            <td>  
                品牌：
			</td>
            <td>
                <input id="updata_brand" style="width: 130px;" />
            </td>
			<td>
                轮胎规格：
				</td>
            <td>
                <input id="updata_tire" style="width: 130px;" />
            </td>
        </tr>
        <tr>
            <td>
                层级（PR）：
				</td>
            <td>
                <input id="updata_pr" class="easyui-textbox"  style="width: 130px;" />
            </td>
			<td>  
                花纹类型：
				</td>
            <td>
                <input id="updata_figure" style="width: 130px;" />
            </td>
			<td>
                压力范围：
				</td>
            <td>
                <input id="updata_pressure" style="width: 30px;" />至<input id="rolePower" style="width:30px;" />
            </td>
        </tr>
        <tr>
            <td style="width:100px">
                温度上限：
				</td>
            <td>
                <input id="updata_tem" class="easyui-textbox" style="width:130px;"/>
            </td>
			<td>
                速度上限(KM/h)：
				</td>
            <td>
                <input id="updata_speed" class="easyui-textbox" style="width:130px;"/>
            </td>
			<td>
               TPKH值：
			   </td>
            <td>
                <input id="updata_tpkh" class="easyui-textbox" style="width:130px;"/>
            </td>

        </tr>
		 <tr>
            <td>
                标准充气压力：
				</td>
            <td>
                <input id="updata_standard" class="easyui-textbox" style="width:130px;"/>
            </td>
            <td>  
                一保(KM)：
			</td>
            <td>
                <input id="updata_one" style="width: 130px;" />
            </td>
			<td>
                二保(KM)：
				</td>
            <td>
                <input id="updata_two" style="width: 130px;" />
            </td>
        </tr>
		 <tr>
            <td>
                额定总里程(KM)：
				</td>
            <td>
                <input id="updata_all" class="easyui-textbox" style="width:130px;" type="text"/>
            </td>
            <td>  
             
			</td>
            <td>
               
            </td>
			<td>
               
				</td>
            <td>
              
            </td>
        </tr>

        <tr style="text-align: center">
		<td>
		</td>
		<td>
		</td>
           <td>
               <button id='updata_save'><a style="text-decoration: none;" href="#"></a></button>
           </td>
            <td>
                <button id='updata_close'><a style="text-decoration: none" href="#"></a></button>
            </td>
			<td>
			</td>
        </tr>
    </table>
    </div>
    </div>
   <div id="addUser" class="easyui-dialog" data-options="closed:true,modal:true,iconCls:'icon-add2'" style="width:875px;height:400px;background-color: #bdc4d4">
    <div style="background-color: #ffffff;height:340px;margin:10px;">
    <span id="addMessage">基本信息</span>
    <table id="aa" style="width: 100%;height: 80%;padding-right: 28px;padding-left: 24px;">
        <tr>
            <td>
                制造商：
				</td>
            <td>
                <input id="productor" class="easyui-textbox" style="width:130px;" type="text"/>
            </td>
            <td>  
                品牌：
			</td>
            <td>
                <input id="brand" style="width: 130px;" />
            </td>
			<td>
                轮胎规格：
				</td>
            <td>
                <input id="tire" style="width: 130px;" />
            </td>
        </tr>
        <tr>
            <td>
                层级（PR）：
				</td>
            <td>
                <input id="pr" class="easyui-textbox"  style="width: 130px;" />
            </td>
			<td>  
                花纹类型：
				</td>
            <td>
                <input id="figure" style="width: 130px;" />
            </td>
			<td>
                压力范围：
				</td>
            <td>
                <input id="pressure" style="width: 30px;" />至<input id="rolePower" style="width:30px;" />
            </td>
        </tr>
        <tr>
            <td style="width:110px">
                温度上限：
				</td>
            <td>
                <input id="temp" class="easyui-textbox" style="width:130px;"/>
            </td>
			<td>
                速度上限(KM/h)：
				</td>
            <td>
                <input id="speed" class="easyui-textbox" style="width:130px;"/>
            </td>
			<td>
               TPKH值：
			   </td>
            <td>
                <input id="tpkh" class="easyui-textbox" style="width:130px;"/>
            </td>

        </tr>
		 <tr>
            <td>
                标准充气压力：
				</td>
            <td>
                <input id="standard" class="easyui-textbox" style="width:130px;"/>
            </td>
            <td>  
                一保(KM)：
			</td>
            <td>
                <input id="one" style="width: 130px;" />
            </td>
			<td>
                二保(KM)：
				</td>
            <td>
                <input id="two" style="width: 130px;" />
            </td>
        </tr>
		 <tr>
            <td>
                额定总里程(KM)：
				</td>
            <td>
                <input id="all" class="easyui-textbox" style="width:130px;" type="text"/>
            </td>
            <td>  
             
			</td>
            <td>
               
            </td>
			<td>
               
				</td>
            <td>
              
            </td>
        </tr>

        <tr style="text-align: center">
		<td>
		</td>
		<td>
		</td>
           <td>
               <button id='save'><a style="text-decoration: none;" href="#"></a></button>
           </td>
            <td>
                <button id='close'><a style="text-decoration: none" href="#"></a></button>
            </td>
			<td>
			</td>
        </tr>
    </table>
    </div>
</div>
	
<div id="alarmDialog">
</div>

</body>
</html>