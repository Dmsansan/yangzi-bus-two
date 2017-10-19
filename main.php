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
    <script type="text/javascript">
    $(function () {
        $('#company').combobox({
            url:'../../css/homepagecss/tsconfig.json',
            valueField:'id',
            textField:'text',
            editable:false,
            onSelect:function (record) {
                console.log("record",record);
                var url='../../css/homepagecss/chedui.json? id='+record.id;
                console.
                console.log("recordid",record.id);
                $('#carteam').combobox('reload',url);
            }
        })
        $('#carteam').combobox({
            valueField:'id',
            textField:'text'
        })
    });
    function addTab(title, url){
        if ($('#center_content').tabs('exists', title)){
            $('#center_content').tabs('select', title);
        } else {
            var content = '<iframe scrolling="auto"  frameborder="0"  src="'+url+'" style="width:99.8%;height:99%;"></iframe>';
            $('#center_content').tabs('add',{
                title:title,
                content:content,
                closable:true
            });
        }
    };

    </script>
</head>
<body  class="easyui-layout">
    <div id="top" data-options="region:'north'">
        <div id="top_left">
              
        </div>
         <div id="top_right">
            <div style="height: 84px;  margin-right: 41px;padding-bottom: 40px;">
                <p style="font-size: 12px;color: #333333;line-height: 84px;vertical-align: middle;">你好，admin,欢迎回来！</p>

                <img id="back" src="css/img/Report_normal.png"  style="margin-left:50px;margin-right: 10px">  <span>|</span><img src="css/img/out_highlighted.png" style="margin-left: 10px;">
            </div>

        </div>

    </div>
    <div id="west" data-options="region:'west',title:'功能菜单'">
        <div  class="easyui-accordion" style="width:100%;height:99%;">
            <div title="系统管理" data-options="iconCls:'icon-ok'" style="background-color: #353c49;overflow: hidden">
                <div class="easyui-accordion" style="width:100%;height:99%;">

                    <div id="userManger" title="用户权限管理" style="background-color: #21262f" >
                        <ul>
                            <li><a onclick="addTab('角色管理','module_sys/sys.roles_show.php')" >角色管理</a></li>
                            <li><a onclick="addTab('用户管理','module_sys/sys.users_show.php')" >用户管理</a></li>
                        </ul>
                    </div>
                    <div id="dataManger" title="基本数据管理" style="background-color: #21262f">
                        <ul>
                            <li><a onclick="addTab('修理厂管理','module_sys/repairDepotManger.php')">修理厂管理</a></li>
                            <li><a onclick="addTab('轮胎基础参数管理','../systemmanger/TireParameter.html')">轮胎基础参数管理</a></li>
                            <li><a onclick="addTab('车载终端管理','module_sys/sys.vehicle_show.php')">车载终端管理</a></li>
                        </ul>

                    </div>
                </div>

            </div>
			<div id="tireManger" title="轮胎管理" data-options="iconCls:'icon-help'" style="padding:10px;background-color: #21262f">
                <ul>
                    <li>
                        <a onclick="addTab('轮胎参数管理','../tiremanger/tireParameterManger.html')">轮胎参数管理 </a>
                    </li>
                    <li>
                        <a onclick="addTab('传感器管理','../tiremanger/sensorManger.html')"> 传感器管理</a>
                    </li>
                    <li>
                        <a onclick="addTab('轮胎管理','../tiremanger/tireManger.html')"> 轮胎管理</a>
                    </li>
                </ul>
            </div>
            <div title="车辆管理" data-options="iconCls:'icon-search'" style="padding:10px;background-color: #21262f">
                <ul>
                    <li>
                        <a onclick="addTab('车辆维护','../carmanger/Vehicle.html')"> 车辆维护</a>
                    </li>
                </ul>
            </div>
            <div title="监测系统" data-options="iconCls:'icon-redo'" style="padding:10px;background-color: #21262f">
                <ul>
                    <li>
                        <a onclick="addTab('车辆轮胎状态','../monitorsystem/carTire.html')"> 车辆轮胎状态</a>
                    </li>
                    <li>
                        <a onclick="addTab('车辆轮胎历史状态','../monitorsystem/carTireHistory.html')"> 车辆轮胎历史状态</a>
                    </li>
                    <li>
                        <a onclick="addTab('告警历史状态','../monitorsystem/report.html')"> 告警历史状态</a>
                    </li>
                </ul>
            </div>
            <div title="统计分析" data-options="iconCls:'icon-undo'" style="padding:10px;background-color: #21262f">
                <ul>
                    <li>
                        <a onclick="addTab('轮胎运行总时长总里程','../statisticalanalysis/allTimeLong.html')"> 轮胎运行总时长总里程</a>
                    </li>
                    <li>
                        <a onclick="addTab('轮胎库存查询','../statisticalanalysis/TireStock.html')"> 轮胎库存查询</a>
                    </li>
                    <li>
                        <a onclick="addTab('轮胎历史曲线','../statisticalanalysis/TireHistoryCurve.html')"> 轮胎历史曲线</a>
                    </li>
                    <li>
                        <a onclick="addTab('轮胎历史告警','../statisticalanalysis/TireHistoryAlarm.html')"> 轮胎历史告警</a>
                    </li>
                    <li>
                        <a onclick="addTab('车辆车速分析','../statisticalanalysis/carSpeed.html')"> 车辆车速分析</a>
                    </li>
                </ul>
            </div>
            <div title="报表分析" data-options="iconCls:'icon-filter'" style="padding:10px;background-color: #21262f">
                <ul>
                    <li>
                        <a onclick="addTab('轮胎里程报表','../reportstatistics/TireCourse.html')"> 轮胎里程报表</a>
                    </li>
                    <li>
                        <a onclick="addTab('轮胎保养记录报表','../reportstatistics/TireMaintain.html')"> 轮胎保养记录报表</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
     <div  id="center_content" class="easyui-tabs" style="width:90%;height: 90%;background-color: #bdc4d4;margin-left: 6px;padding-bottom: 6px;padding-right: 6px;"  data-options="region:'center',width:'80%'" >

        <div id="center_page" title="首页">
            <div id="i-center">
                <div id="center_top" style="padding-top: 20px;padding-left: 1%">
                    <label for="company">公司：</label>
                    <input id="company" name="company" />
                    <label for="carteam">车队：</label>
                    <input id="carteam" name="carteam" />
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
                                <p style="font-size: 24px;color: #ffffff;margin: 0;padding: 0">22222</p>
                            </div>
                            <div style="margin-left: 150px; height: 80px; background-color: #ffffff">
                                <div style="height: 40px;">
                                    <span style="display:inline-block;font-size: 12px;font-weight: bold;line-height:40px;">注册轮胎数量：</span>
                                    <span style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd ">400</span>
                                    <span style="display:inline-block;font-size: 12px;margin-left:5%;font-weight: bold;line-height:40px;">库存轮胎数量：</span>
                                    <span style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd ">400</span>
                                </div>
                                <div style="height: 40px;">
                                    <span style="display:inline-block;font-size: 12px;font-weight: bold;line-height:40px;">装车轮胎数量：</span>
                                    <span style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd ">400</span>
                                    <span style="display:inline-block;font-size: 12px;margin-left:5%;font-weight: bold;line-height:40px;">报废轮胎数量：</span>
                                    <span style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd ">400</span>

                                </div>
                            </div>
                        </div>
                        <div id="c_center_center" style="height: 20%;vertical-align: middle">
                            <div  style="float: left;text-align:center;width: 100px;height: 80px;margin-left:5%;margin-right: 5%; background: url('css/img/card2.png')">
                                <p style="font-size: 16px;font-weight: bold;color: #ffffff;margin: 0;padding: 10px 0 0 0 ;">轮胎总数
                                </p>
                                <p style="font-size: 24px;color: #ffffff;margin: 0;padding: 0">22222</p>
                            </div>
                            <div style="margin-left: 150px; height: 80px; background-color: #ffffff;">

                                <span style="display:inline-block;font-size: 12px;font-weight: bold;line-height:80px;">运营中车辆数：</span>
                                <span style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd ">400</span>
                                <span style="display:inline-block;font-size: 12px;margin-left:5%;font-weight: bold;line-height:80px;">报废车辆数量：</span>
                                <span style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd ">400</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="center_bottom">
                    <div id="b_top">
                        <span>胎温胎压未读报警信息：</span>
                    </div>
                    <div id="b_center">
                        <div  style="float: left;text-align:center;width: 100px;height: 80px;margin-left:5%;margin-right: 5%; background: url('css/img/card3.png')">
                            <p style="font-size: 16px;font-weight: bold;color: #ffffff;margin: 0;padding: 10px 0 0 0 ;">未读条数
                            </p>
                            <p style="font-size: 24px;color: #ffffff;margin: 0;padding: 0">22222</p>
                        </div>
                        <div style="margin-left: 150px; height: 80px; background-color: #ffffff">
                            <div style="height: 40px;">
                                <span style="display:inline-block;font-size: 12px;font-weight: bold;line-height:40px;">高压报警条数：</span>
                                <span style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd ">400</span>
                                <span style="display:inline-block;font-size: 12px;margin-left:5%;font-weight: bold;line-height:40px;">高温报警条数：</span>
                                <span style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd ">400</span>
                            </div>
                            <div style="height: 40px;">
                                <span style="display:inline-block;font-size: 12px;font-weight: bold;line-height:40px;">低压报警条数：</span>
                                <span style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd ">400</span>
                                <span style="display:inline-block;font-size: 12px;margin-left:5%;font-weight: bold;line-height:40px;">漏气报警条数：</span>
                                <span style="display: inline-block;width: 25%;height: 25px;vertical-align: middle;border-radius: 5px; background-color:#3ab0fd ">400</span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div id="south" data-options="region:'south',split:'true'" style="height:50px">
        <span> @2015 轮胎全生命管理周期系统 版权所有 v1.17</span>
    </div>

</body>
</html>