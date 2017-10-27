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
	
		$(function(){
			$('#add').on('click',function(){
				 $('#addUser').dialog('open').dialog('setTitle','新增轮胎参数');
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
                url: '../ajaction/v1/?menuid=0&cmd=get_all_brand',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    var res = data.items;
                    $("#brand").combobox('loadData',res);
                    $("#tire").combobox('loadData',res);
                    $("#pr").combobox('loadData',res);
                    $("#figure").combobox('loadData',res);
                }
            });
			$('#brand').combobox({
                    valueField:'id',
                    textField:'name',
                    type:'json'
            });
			$('#tire').combobox({
				valueField:'id',
                    textField:'norms_name',
                    type:'json'
			});
			$('#pr').combobox({
				valueField:'id',
                    textField:'class_name',
                    type:'json'
			});
			$('#figure').combobox({
				valueField:'id',
                    textField:'figure_name',
                    type:'json'
			});
		/* 	//加载数据表格：
			$.ajax({
				url:'../ajaction/v1/?menuid=111010&cmd=qry&t=1',
				dataType:'json',
				success:function(data){
				
					console.log('sssa',data);
				}
			}); */
		//增加操作：
			/* $("#save").bind('click',function(){
				var company_name=$('#productor').textbox('getText');
				var brand_id_val=$('#brand').combobox('getValue');
				var	norms_id_val=$('#tire').combobox('getValue');
				var	class_id_val=$('#pr').combobox('getValue');
				var	figure_id_val=$('#figure').combobox('getValue');
				var	pressure_ul=$('#pressure_down').textbox('getText');
				var	pressure_ll=$('#pressure_up').textbox('getText');
				var	speed_ul=$('#speed').textbox('getText');
				var	temp_ul=$('#temp').textbox('getText');
				var	tkph_val=$('#tpkh').textbox('getText');
				var	brao_val=$('#standard').textbox('getText');
				var	mainterance1=$('#one').textbox('getText');
				var	mainterance2=$('#two').textbox('getText');
				var	rated_mile=$('#all').textbox('getText');
				$.ajax({
					url:'../ajaction/v1/?menuid=111010&cmd=add',
					type:'POST',
					dataType:'json',
					data:{'company_name':company_name,'brand_id_val':brand_id_val,'norms_id_val':norms_id_val,'class_id_val':class_id_val,
					'figure_id_val':figure_id_val,'pressure_ul':pressure_ul,'pressure_ll':pressure_ll,'speed_ul':speed_ul,'temp_ul':temp_ul,
					'tkph_val':tkph_val,'brao_val':brao_val,'mainterance1':mainterance1,'mainterance2':mainterance2,'rated_mile':rated_mile},
					success:function(data){
					if(data!=null&&data.status="ok"){
						reload()
					}else{
						alert('数据异常');
					}
						
					 
					}
				});
            });
					
		}) */
		/* function reload(){
			$.ajax({
				url:'../ajaction/v1/?menuid=111010&cmd=qry&t=1',
				dataType:'json',
				success:function(data){
				
					console.log('sssa',data);
				}
			});
		} */
            //加载数据
            $.ajax({
                url: '../ajaction/v1/?menuid=111010&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    var obj = eval(data);
                    $("#dg").datagrid("loadData", data.Rows);
                    console.log('data', obj);
                }
            });
            //增加操作：
            $('#save').bind('click', function() {
                var company_name = $('#productor').textbox('getText');
                var brand_id_val=$('#brand').combobox('getValue');                
                var norms_id_val = $('#tire').combobox('getValue');
                var class_id_val=$('#pr').combobox('getValue');
                var figure_id_val=$('#figure').combobox('getValue');
                var pressure_ll = $('#pressure_ll').textbox('getText');
                var pressure_ul = $('#pressure_ul').textbox('getText');
                var speed_ul = $('#speed_ul').textbox('getText');
                var temp_ul = $('#temp_ul').textbox('getText');
                var tkph_val = $('#tpkh_val').textbox('getText');
                var brao_val = $('#brao_val').textbox('getText');
                var mainterance1 = $('#mainterance1').textbox('getText');
                var mainterance2 = $('#mainterance2').textbox('getText');
                var rated_mile = $('#rated_mile').textbox('getText');
                $.ajax({
                url:'../ajaction/v1/?menuid=111010&cmd=add',
                type:'POST',
                data:{'company_name':company_name,'brand_id_val':brand_id_val,'norms_id_val':norms_id_val,'class_id_val':class_id_val,'figure_id_val':figure_id_val,'pressure_ll':pressure_ll,'pressure_ul':pressure_ul,'speed_ul':speed_ul ,'temp_ul':temp_ul,'tkph_val':tkph_val,'baro_val':brao_val,'mainterance2':mainterance2,'mainterance1':mainterance1,'rated_mile':rated_mile},
                dataType:'json',
                success:function(data){
                    reload();
                    console.log("loadDa",data);
                }
                });
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
					
		})
        function reload() {
            $.ajax({
                url: '../ajaction/v1/?menuid=111010&cmd=qry&t=1',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    var Idata = data.Rows;
                    $("#dg").datagrid("loadData", data.Rows);
                    console.log('data', Idata.admin_name);
                }
            });
        }

        function formatOption(value, row, index) {
                return '<a href="#" style="text-decoration: none;color: #1c66dc; font-size: 12px; border:1px solid #1c66dc;padding:2px 10px; border-radius:4px; margin-left:20px;" onclick="editUser('+index+')">编辑</a> <a href="#" style="text-decoration: none;color: #efad2c; font-size: 12px; border:1px solid #efad2c;padding:2px 10px; border-radius:4px; margin-left:6px;" onclick="deletData('+index+')">删除</a>';
        }
        function editUser(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','修改轮胎参数');
         
            }
        };
		//删除操作
        function deletData(index) {
            $('#dg').datagrid('selectRow', index);
            var row = $('#dg').datagrid('getSelected');
            if (row) {
                var id = row.tire_param_id;
                $('#alarm').dialog('open').dialog('setTitle', '提示');
                $('#sure').bind('click', function() {
                    $.ajax({
                        url: '../ajaction/v1/?menuid=111010&cmd=del',
                        type: 'post',
                        data: {
                            'tire_param_id': id
                        },
                        success: function(data) {
                            console.log('delete', data);
                            reload();
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

    <table id="dg" class="easyui-datagrid"
           data-options="singleSelect:true,toolbar:'#tb',striped:'true',pagination:'true'">
        <thead>
        <tr>
            <th data-options="field:'tire_param_id',width:'8%'">编号</th>
            <th data-options="field:'company_name',width:'8%'">制造商</th>
            <th data-options="field:'brand_name',width:'8%'">品牌</th>
            <th data-options="field:'norms_name',width:'8%'">轮胎规格</th>
            <th data-options="field:'class_name',width:'8%'">层级</th>
            <th data-options="field:'figure_name',width:'8%'">花纹</th>
            <th data-options="field:'pressure_ul',width:'8%'">胎压上限</th>
            <th data-options="field:'pressure_ll',width:'8%'">胎压下限</th>
            <th data-options="field:'temp_ul',width:'10%'">胎温上限</th>
            <th data-options="field:'speed_ul',width:'10%'">速度上限</th>
            <th data-options="field:'tkph_val',width:'10%'">TKPH值</th>
            <th data-options="field:'baro_val',width:'10%'">标准冲气压力</th>
            <th data-options="field:'mainterance1',width:'10%'">一保</th>
            <th data-options="field:'mainterance2',width:'10%'">二保</th>
            <th data-options="field:'rated_mile',width:'10%'">额定里程</th>
            <th data-options="field:'_operate',width:'10%',formatter:formatOption">操作</th>
        </tr>
        </thead>
    </table>
    <div id="tb" style="margin-bottom: 10px;margin-top: 10px;background-color: white;padding-left: 19px;padding-right:39px;line-height: 54px;">

    <input type="text" placeholder="轮胎编号"/> <button>搜索</button>
    <button id="add" style="float: right; margin-top: 15px;">增加</button>

    <input id="search_company_name" type="text" placeholder="制造商"/> <button id="search">搜索</button>
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
                <input id="pr"  style="width: 130px;" />
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
                <input id="pressure_down" class="easyui-textbox" style="width: 30px;" />至<input id="pressure_up" class="easyui-textbox" style="width:30px;" />

                <input id="pressure_ll"  class="easyui-textbox" style="width: 30px;" />至<input id="pressure_ul" class="easyui-textbox" style="width:30px;" />

            </td>
        </tr>
        <tr>
            <td style="width:110px">
                温度上限：
				</td>
            <td>
                <input id="temp_ul" class="easyui-textbox" style="width:130px;"/>
            </td>
			<td>
                速度上限(KM/h)：
				</td>
            <td>
                <input id="speed_ul" class="easyui-textbox" style="width:130px;"/>
            </td>
			<td>
               TPKH值：
			   </td>
            <td>
                <input id="tpkh_val" class="easyui-textbox" style="width:130px;"/>
            </td>

        </tr>
		 <tr>
            <td>
                标准充气压力：
				</td>
            <td>
                <input id="brao_val" class="easyui-textbox" style="width:130px;"/>
            </td>
            <td>  
                一保(KM)：
			</td>
            <td>

                <input id="one" class="easyui-textbox" style="width: 130px;" />

                <input id="mainterance1" class="easyui-textbox" style="width: 130px;" />

            </td>
			<td>
                二保(KM)：
				</td>
            <td>

                <input id="two" class="easyui-textbox" style="width: 130px;" />

                <input id="mainterance2" class="easyui-textbox" style="width: 130px;" />

            </td>
        </tr>
		 <tr>
            <td>
                额定总里程(KM)：
				</td>
            <td>
                <input id="rated_mile" class="easyui-textbox" style="width:130px;" type="text"/>
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
	

 <div id="alarm" class="easyui-dialog" style="text-align: center;width:310px;height: 163px;background-color: #bdc4d4" data-options="closed:true,modal:true" >
        <div style="background-color: #ffffff;height:121px;margin:1px;">

            <span style="font-size:14px;color:#333333;font-weight: bold;display: inline-block;height: 78px;line-height: 78px;">信息删除无法恢复，确定删除？</span>

<div id="alarm" class="easyui-dialog" style="text-align: center;width:310px;height: 163px;background-color: #bdc4d4" data-options="closed:true,modal:true" >
        <div style="background-color: #ffffff;height:121px;margin:1px;">

            <span style="font-size:14px;color:#333333;font-weight: bold;display: inline-block;height: 78px;line-height: 78px;">参数删除无法恢复，确定删除？</span>

        <div  style="width:100%;">
            <button id="sure"></button>
            <button id="cancel"></button>
        </div>
        </div>
    </div>

</body>
</html>