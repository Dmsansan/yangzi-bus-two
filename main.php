<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <link href="jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script src="jquery-easyui/jquery.min.js" type="text/javascript"></script>
    <link href="jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <script src="jquery-easyui/jquery.easyui.min.js" type="text/javascript"></script>
    <!--实时时间JS-->
    <script src="js/jquery.jclock.js" type="text/javascript"></script>
    <style>
     #save{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("css/img/ok_normal.png") no-repeat;

        }
        #save:visited,#save:link{
            background: url("css/img/ok_normal.png") no-repeat;

        }
        #save button:active,#save button:hover{
            background: url("css/img/ok_seleected.png") no-repeat;

        }
        #close{
            border: none;
            width: 60px;
            height: 30px;
            vertical-align: middle;
            margin-right: 10px;
            background: url("css/img/cancel_normal.png") no-repeat;

        }
        #close:visited,#close:link{
            background: url("css/img/cancel_normal.png") no-repeat;

        }
        #close button:active,#close button:hover{
            background: url("css/img/cancel_selected.png") no-repeat;

        }
    </style>
    <script type="text/javascript">
    $(function () {
        $('#company').combobox({
            //url:'./ajaction/v1/?menuid=0&cmd=get_all_stores',
            valueField:'store_id',
            textField:'store_name', 
            onSelect:function(rec){
                $.ajax({
                    url:'./ajaction/v1/?menuid=0&cmd=get_index_data&store_id='+rec.store_id,
                    dataType:'json',
                    type:'POST',
                    success:function(data){
                        console.log('sansan',data);
                         $("#tire_count").html(data.tire_count);
                       $("#sennor_count").html(data.sensor_count);
                       if(data.sensor_count != 0){
                       $("#sennor_tire_count").progressbar({
                            value:parseInt(data.tire_count/data.sensor_count*100)
                       });
                        }else{
                            $("#sennor_tire_count").progressbar({
                            value:parseInt(0)
                       });
                        }
                       $("#kc_count").html(data.kc_tire_count);
                       if(data.tire_count != 0){
                       $("#kc_tire_count").progressbar({
                            value:parseInt(data.kc_tire_count/data.tire_count*100)
                       });
                   }else{
                         $("#kc_tire_count").progressbar({
                            value:parseInt(0)
                       });
                   }
                       $("#zc_count").html(data.zc_tire_count);
                       if(data.tire_count != 0){
                       $("#zc_tire_count").progressbar({
                            value:parseInt(data.zc_tire_count/data.tire_count*100)
                       });
                    }else{
                         $("#zc_tire_count").progressbar({
                            value:parseInt(0)
                       });
                    }
                        $("#bf_count").html(data.bf_tire_count);
                        if(data.tire_count != 0){
                        $("#bf_tire_count").progressbar({
                            value:parseInt(data.bf_tire_count/data.tire_count*100)
                       });
                    }else{
                        $("#bf_tire_count").progressbar({
                            value:parseInt(0)
                       });
                    }
                        $("#bus_count").html(data.bus_count);
                        $("#yy_count").html(data.yy_bus_count);
                        if(data.bus_count != 0){
                        $("#yy_bus_count").progressbar({
                            value:parseInt(data.yy_bus_count/data.bus_count*100)
                       });
                        }else{
                            $("#yy_bus_count").progressbar({
                                value:parseInt(0)
                           });
                        }
                         $("#bff_count").html(data.bf_bus_count);
                         if(data.bus_count != 0){
                        $("#bf_bus_count").progressbar({
                            value:parseInt(data.bf_bus_count/data.bus_count*100)
                       });
                    }else{
                         $("#bf_bus_count").progressbar({
                            value:parseInt(0)
                       });
                    }
                        $("#alarm_count").html(data.alarm_count);
                        $("#height_count").html(data.height_alarm_count);
                        if(data.alarm_count != 0){
                        $("#height_alarm_count").progressbar({
                            value:parseInt(data.height_alarm_count/data.alarm_count*100)
                       });
                    }else{
                        $("#height_alarm_count").progressbar({
                            value:parseInt(0)
                       });
                    }
                        $("#low_count").html(data.low_alarm_count);
                        if(data.alarm_count != 0){
                        $("#low_alarm_count").progressbar({
                            value:parseInt(data.low_alarm_count/data.alarm_count*100)
                       });
                    }else{
                        $("#low_alarm_count").progressbar({
                            value:parseInt(0)
                       });
                    }
                        $("#wendu_count").html(data.height_wendu_count);
                        if(data.alarm_count != 0){
                        $("#height_wendu_count").progressbar({
                            value:parseInt(data.height_wendu_count/data.alarm_count*100)
                       });
                    }else{
                         $("#height_wendu_count").progressbar({
                            value:parseInt(0)
                       });
                    }

                    }
                });
                //var url = './ajaction/v1/?menuid=0&cmd=get_index_data&store_id='+rec.store.id;
				console.log();
				/* $('#company').combobox('loadData',rec); */

            }
        });
		
        
        //获取修理厂列表
        $.ajax({
                url:'./ajaction/v1/?menuid=0&cmd=get_all_stores',
                dataType:'json',
                success:function(data){
                    var team=data.items;
                    $('#company').combobox('loadData',team);
                    console.log('msg',data);
                }
            });
        //获取首页数据
        $.ajax({
            url:'./ajaction/v1/?menuid=0&cmd=get_index_data',
            dataType:'json',
            success:function(data){
                console.log(data);
               $("#tire_count").html(data.tire_count);
                       $("#sennor_count").html(data.sensor_count);
                       if(data.sensor_count != 0){
                       $("#sennor_tire_count").progressbar({
                            value:parseInt(data.tire_count/data.sensor_count*100)
                       });
                        }else{
                            $("#sennor_tire_count").progressbar({
                            value:parseInt(0)
                       });
                        }
                       $("#kc_count").html(data.kc_tire_count);
                       if(data.tire_count != 0){
                       $("#kc_tire_count").progressbar({
                            value:parseInt(data.kc_tire_count/data.tire_count*100)
                       });
                   }else{
                         $("#kc_tire_count").progressbar({
                            value:parseInt(0)
                       });
                   }
                       $("#zc_count").html(data.zc_tire_count);
                       if(data.tire_count != 0){
                       $("#zc_tire_count").progressbar({
                            value:parseInt(data.zc_tire_count/data.tire_count*100)
                       });
                    }else{
                         $("#zc_tire_count").progressbar({
                            value:parseInt(0)
                       });
                    }
                        $("#bf_count").html(data.bf_tire_count);
                        if(data.tire_count != 0){
                        $("#bf_tire_count").progressbar({
                            value:parseInt(data.bf_tire_count/data.tire_count*100)
                       });
                    }else{
                        $("#bf_tire_count").progressbar({
                            value:parseInt(0)
                       });
                    }
                        $("#bus_count").html(data.bus_count);
                        $("#yy_count").html(data.yy_bus_count);
                        if(data.bus_count != 0){
                        $("#yy_bus_count").progressbar({
                            value:parseInt(data.yy_bus_count/data.bus_count*100)
                       });
                        }else{
                            $("#yy_bus_count").progressbar({
                                value:parseInt(0)
                           });
                        }
                         $("#bff_count").html(data.bf_bus_count);
                         if(data.bus_count != 0){
                        $("#bf_bus_count").progressbar({
                            value:parseInt(data.bf_bus_count/data.bus_count*100)
                       });
                    }else{
                         $("#bf_bus_count").progressbar({
                            value:parseInt(0)
                       });
                    }
                        $("#alarm_count").html(data.alarm_count);
                        $("#height_count").html(data.height_alarm_count);
                        if(data.alarm_count != 0){
                        $("#height_alarm_count").progressbar({
                            value:parseInt(data.height_alarm_count/data.alarm_count*100)
                       });
                    }else{
                        $("#height_alarm_count").progressbar({
                            value:parseInt(0)
                       });
                    }
                        $("#low_count").html(data.low_alarm_count);
                        if(data.alarm_count != 0){
                        $("#low_alarm_count").progressbar({
                            value:parseInt(data.low_alarm_count/data.alarm_count*100)
                       });
                    }else{
                        $("#low_alarm_count").progressbar({
                            value:parseInt(0)
                       });
                    }
                        $("#wendu_count").html(data.height_wendu_count);
                        if(data.alarm_count != 0){
                        $("#height_wendu_count").progressbar({
                            value:parseInt(data.height_wendu_count/data.alarm_count*100)
                       });
                    }else{
                         $("#height_wendu_count").progressbar({
                            value:parseInt(0)
                       });
                    }
            }
        });
        $('#jnkc').jclock({ withDate: true, withWeek: true });
		$("#dd").accordion('getSelected').panel('collapse');

        getuserinfo();

        //修改密码保存
        $('#save').bind('click', function() {
                var re_password = $('#re_password').textbox('getValue');
                var new_password = $('#new_password').passwordbox('getValue');
                var renew_password = $('#renew_password').passwordbox('getValue');
                console.log(re_password);
                $.ajax({
                url:'./ajaction/v1/?menuid=0&cmd=changepwd',
                data:{'T_oldpwd':re_password,'T_newpwd':new_password,'T_renewpwd':renew_password},
                success:function(data){
                   var res=eval("("+data+")");
                        if (res.status == "OK") {
                            $.messager.show({
                            title : '操作成功！',
                            msg:'密码修改成功！',
                            timeout:3000,
                            showType:'show',  
                            });

                            $('#changepass').dialog('close');
                        }else {
                            $.messager.alert('操作失败！',res.reason);
                        }
                }
                });
            });
        $('#close').bind('click',function(){
                $('#changepass').dialog('close');
            });
    });
    function addTab(title, url){
        if ($('#center_content').tabs('exists', title)){
            $('#center_content').tabs('select', title);
        } else {
            var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:99.8%;height:99%;background-color#f1f6fd"></iframe>';
            $('#center_content').tabs('add',{
                title:title,
                content:content,
                closable:true,
            });
        }
    };
  window.onload=function () {
    var wests = document.getElementById("west");
    var lis = wests.getElementsByTagName("li");
    for (var i = 0; i < lis.length; i++) {
        lis[i].onclick = function(){
            for(var i = 0; i < lis.length; i++){
                lis[i].className = "";
            }
            this.className = "current";
        }
    }
    $('#userManger').click(function () {
        $(this).parent().css('color','red');
    });
}

    //获取用户信息
   function getuserinfo() {
            $.getJSON("ajaction/sysaction/sys.getuserinfo.php?rnd=" + Math.random(), function (data, textStatus) {
                $("#Username").html(data.real_name);
            });
    }
    //退出登录
    function logout() {
        $.messager.confirm('退出登陆', '确认要退出登录？', function(r){
            if (r){
                 $.ajax({
                        type: 'post',
                        //dataType: 'json',
                        url: 'ajaction/v1/?menuid=0',
                        data: { cmd: 'logout'},
                        success: function (responseText) {
                            
                            if(typeof(responseText)=="undefined" || responseText=="" || responseText==null){
                            //服务器没有数据反回
                                top.$.dialog.error("未知错误");                            
                            }else{
                                var dataObj = eval("("+responseText+")");
                                    
                                if (dataObj.status == "OK") {
                                    
                                }else {
                                    top.$.dialog.error(dataObj.reason);                                    
                                }
                            }   
                            //管它成功失败，直接跳首页登陆去吧
                            javascript: location.replace("login.php");
                        },
                        error: function ()
                        { alert("未知错误") }

                    });
            }
        });
    }
    //修改密码
    function changepass(){
        $('#changepass').dialog('open').dialog('setTitle', '修改密码');
    }
    </script>
</head>
<body  class="easyui-layout">
    <div id="top" data-options="region:'north'">
        <div id="top_left">
        <!--logo图标-->
        </div>
         <div id="top_right">
            <div style="height: 77px;">
                <!--<p style="float:left"><a style="width:88xpheight:88px;text-align:center"><img src="css/img/icon01.png" width="">首页</a></p>
                <p style="float:left">31313</p>-->
                <p style="font-size: 12px;color: white;line-height: 74px;vertical-align:middle;" id="Username"></p>
                <p style="font-size: 12px;color: #ffffff;line-height: 74px;vertical-align:middle;">您好,欢迎回来！&nbsp;&nbsp;<span id="jnkc" style="text-align:right;color:white"></span></p>

               <a onclick="changepass()"> <img id="back" src="css/img/password_normal.png"  style="margin-left:50px;margin-right: 10px"></a>  <span style="color:#9f9f9f">|</span><a onclick="logout()"><img src="css/img/quit_normal.png" style="margin-left: 10px;"></a>
            </div>
        </div>

    </div>
    <div id="west" data-options="region:'west',title:''">
        <div id="dd" class="easyui-accordion" style="width:100%;height:99%;">
            <div title="系统管理" data-options="iconCls:'icon-ok'" style="padding:10px;background-color: #21262f;overflow: hidden">   
                        <ul>
                            <li><a onclick="addTab('角色管理','module_sys/sys.roles_show.php')">角色管理</a></li>
                            <li><a onclick="addTab('用户管理','module_sys/sys.users_show.php')" >用户管理</a></li>
                      
                            <li><a onclick="addTab('修理厂管理','module_sys/repairDepotManger.php')">修理厂管理</a></li>
                            <li><a onclick="addTab('轮胎基本参数管理','module_sys/tireParameter.php')">轮胎基本参数管理</a></li>
                            <li><a onclick="addTab('车载终端管理','module_sys/sys.vehicle_show.php')">车载终端管理</a></li>
                        </ul>
            </div>
			<div id="tireManger" title="轮胎管理" data-options="iconCls:'icon-help'" style="padding:10px;background-color: #21262f">
                <ul>
                    <li>
                        <a onclick="addTab('轮胎参数管理','module_11/sys.tireparam_show.php')">轮胎参数管理 </a>
                    </li>
                    <li>
                        <a onclick="addTab('传感器管理','module_11/sys.sensor_show.php')"> 传感器管理</a>
                    </li>
                    <li>
                        <a onclick="addTab('轮胎管理','module_11/sys.tireinfo_show.php')"> 轮胎管理</a>
                    </li>
                </ul>
            </div>
            <div title="车辆管理" data-options="iconCls:'icon-search'" style="padding:10px;background-color: #21262f">
                <ul>
                    <li>
                        <a onclick="addTab('车辆维护','module_12/vehicle.php')"> 车辆维护</a>
                    </li>
                </ul>
            </div>
            <div title="监测系统" data-options="iconCls:'icon-redo'" style="padding:10px;background-color: #21262f">
                <ul>
                    <li>
                        <a onclick="addTab('车辆轮胎状态','module_13/sys.real_show.php')"> 车辆轮胎状态</a>
                    </li>
                    <li>
                        <a onclick="addTab('车辆轮胎历史状态','module_13/sys.his_show.php')"> 车辆轮胎历史状态</a>
                    </li>
                    <li>
                        <a onclick="addTab('告警历史状态','module_13/sys.alarm_his131210_show.php')"> 告警历史状态</a>
                    </li>
                </ul>
            </div>
            <div title="统计分析" data-options="iconCls:'icon-undo'" style="padding:10px;background-color: #21262f">
                <ul>
                    <li>
                        <a style="font-size:13px" onclick="addTab('轮胎运行总时长总里程','module_13/sys.tire_runhis_show.php')"> 轮胎运行总时长总里程</a>
                    </li>
                    <li>
                        <a onclick="addTab('轮胎库存查询','module_13/sys.tirestore_charts_show.php')"> 轮胎库存查询</a>
                    </li>
                    <li>
                        <a onclick="addTab('轮胎历史曲线','module_13/sys.tirehis_charts_10.php')"> 轮胎历史曲线</a>
                    </li>
                    <li>
                        <a onclick="addTab('轮胎历史告警','module_13/sys.tirehis_charts_12.php')"> 轮胎历史告警</a>
                    </li>
                    <!--<li>
                        <a onclick="addTab('车辆车速分析','module_13/sys.carspeed_charts_show.php')"> 车辆车速分析</a>
                    </li>-->
                </ul>
            </div>
            <div title="报表分析" data-options="iconCls:'icon-filter'" style="padding:10px;background-color: #21262f">
                <ul>
                    <li>
                        <a onclick="addTab('轮胎里程报表','module_13/tirecourse.php')"> 轮胎里程报表</a>
                    </li>
                    <li>
                        <a onclick="addTab('轮胎保养记录报表','module_13/tireProtect.php')"> 轮胎保养记录报表</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
     <div  id="center_content" class="easyui-tabs"  style="width:90%;height: 100%;background-color: #bdc4d4;"  data-options="region:'center',width:'80%'" >

        <div id="center_page" title="首页">
            <div id="i-center">
                <div id="center_top" style="padding-top: 20px;padding-left: 1%">
                    <label for="company">修理厂：</label>
                    <input id="company" class="easyui-combobox" name="company" />
                    <!--<label for="carteam">车队：</label>
                    <input id="carteam" name="carteam" />-->
                </div>
                <div id="center_center">
                   <div id="c_top">
                       <span>信息综述：</span>
                   </div>
                    <div id="c_center">
                        <div id="c_center_top" style="height:50%">
                            <div style="float: left;width: 100px;height: 80px;text-align:center;margin-left:5%;margin-right: 5%; background: url('css/img/card1.png')">
                                <p style="font-size: 16px;font-weight: bold;color: #ffffff;margin: 0;padding: 10px 0 0 0 ;">轮胎总数

                                </p>
                                <p id="tire_count" style="font-size: 24px;color: #ffffff;margin: 0;padding: 0"></p>
                            </div>
                            <div style="margin-left: 150px; height: 80px; background-color: #ffffff">
                                <div style="height: 40px;">
                                    <span style="display:inline-block;font-size: 12px;font-weight: bold;line-height:40px;">注册轮胎数量：</span>
                                    <span id="sennor_count"></span>
                                    <span id="sennor_tire_count" style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd ;"></span>
                                    <span  style="display:inline-block;font-size: 12px;margin-left:5%;font-weight: bold;line-height:40px;">库存轮胎数量：</span>
                                    <span id="kc_count"></span>
                                    <span id="kc_tire_count" style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd "></span>
                                </div>
                                <div style="height: 40px;">
                                    <span style="display:inline-block;font-size: 12px;font-weight: bold;line-height:40px;">装车轮胎数量：</span>
                                    <span id="zc_count"></span>
                                    <span id="zc_tire_count" style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd "></span>
                                    <span style="display:inline-block;font-size: 12px;margin-left:5%;font-weight: bold;line-height:40px;">报废轮胎数量：</span>
                                    <span id="bf_count"></span>
                                    <span id="bf_tire_count" style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd "></span>

                                </div>
                            </div>
                        </div>
                        <div id="c_center_center" style="height: 20%;vertical-align: middle">
                            <div  style="float: left;text-align:center;width: 100px;height: 80px;margin-left:5%;margin-right: 5%; background: url('css/img/card2.png')">
                                <p style="font-size: 16px;font-weight: bold;color: #ffffff;margin: 0;padding: 10px 0 0 0 ;">车辆总数
                                </p>
                                <p id="bus_count" style="font-size: 24px;color: #ffffff;margin: 0;padding: 0"></p>
                            </div>
                            <div style="margin-left: 150px; height: 80px; background-color: #ffffff;">

                                <span style="display:inline-block;font-size: 12px;font-weight: bold;line-height:80px;">运营中车辆数：</span>
                                <span id="yy_count"></span>
                                <span id="yy_bus_count" style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd "></span>
                                <span style="display:inline-block;font-size: 12px;margin-left:5%;font-weight: bold;line-height:80px;">报废车辆数量：</span>
                                <span id="bff_count"></span>
                                <span id="bf_bus_count"style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd "></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="center_bottom">
                    <div id="b_top">
                        <span>胎温胎压报警信息：</span>
                    </div>
                    <div id="b_center">
                        <div  style="float: left;text-align:center;width: 100px;height: 80px;margin-left:5%;margin-right: 5%; background: url('css/img/card3.png')">
                            <p style="font-size: 16px;font-weight: bold;color: #ffffff;margin: 0;padding: 10px 0 0 0 ;">报警条数
                            </p>
                            <p id="alarm_count" style="font-size: 24px;color: #ffffff;margin: 0;padding: 0"></p>
                        </div>
                        <div style="margin-left: 150px; height: 80px; background-color: #ffffff">
                            <div style="height: 40px;">
                                <span style="display:inline-block;font-size: 12px;font-weight: bold;line-height:40px;">高压报警条数：</span>
                                <span id="height_count"></span>
                                <span id="height_alarm_count" style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd "></span>
                                <span style="display:inline-block;font-size: 12px;margin-left:5%;font-weight: bold;line-height:40px;">高温报警条数：</span>
                                <span id="wendu_count"></span>
                                <span id="height_wendu_count" style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd "></span>
                            </div>
                            <div style="height: 40px;">
                                <span style="display:inline-block;font-size: 12px;font-weight: bold;line-height:40px;">低压报警条数：</span>
                                <span id="low_count"></span>
                                <span id="low_alarm_count" style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd "></span>
                                

                            </div>
                        </div>
                    </div>
                </div>
                   <!--修改密码-->
            <div id="changepass" class="easyui-dialog" data-options="closed:true,modal:true,buttons:'#btn_dlg'" style="width:400px;height: 300px;background-color: #bdc4d4">
        <div style="background-color: #ffffff;height:240px;margin:10px;">   
               <span style=" display: inline-block; margin-left: 10px; font-size: 14px; margin-top: 10px; font-family: 微软雅黑;">基本信息</span>
            <table id="aa" style="width: 100%;height:30%;padding-right: 28px;padding-left: 24px;">
                <tr>
                    <td>
                        原始密码：
                    </td>
                    <td>
                        <input id="re_password" class="easyui-passwordbox" style="width: 150px;" />
                    </td>
                    
                </tr>
                <tr>
                    <td>
                        新密码：
                    </td>
                    <td>
                        <input id="new_password" class="easyui-passwordbox" style="width: 150px;" />
                    </td>
                </tr>
                <tr>
                    <td>
                        确认密码：
                    </td>
                    <td>
                        <input id="renew_password" class="easyui-passwordbox" style="width: 150px;" />
                    </td>
                </tr>
                <tr style="text-align:center">
                        
                        <td>
                            <button id='save' style="margin-top:10px;"><a style="text-decoration: none;" href="#"></a></button>
                        </td>
                        <td>
                            <button id='close' style="margin-top:10px;"><a style="text-decoration: none" href="#"></a></button>
                        </td>
                       
                </tr>
            </table>
        </div>
        </div>

            </div>
        </div>
    </div>
    <div id="south" data-options="region:'south'," style="height:48px;text-align:center;">
        <span> @2015 轮胎全生命管理周期系统 版权所有 v1.17</span>
    </div>

</body>
</html>