<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <link href="jquery-easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
    <link href="jquery-easyui/themes/icon.css" rel="stylesheet" type="text/css">
    <script src="jquery-easyui/jquery.min.js" type="text/javascript"></script>
    <link href="jquery-easyui/demo.css" rel="stylesheet" type="text/css">
    <link href="css/homepagecss/usermanger.css" type="text/css" rel="stylesheet">
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
           <img src="jquery-easyui/themes/icons/back.png"> <p>你好，admin</p> <input type="button" onclick="addTab('首页','')" value="首页">
            <a href="javascript:0">修改密码</a> <span>|</span><a href="javascript:0">退出</a>
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
                            <li><a onclick="addTab('车载终端管理','../systemmanger/machine.html')">车载终端管理</a></li>
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
            <div title="监测系统" data-options="iconCls:'icon-search'" style="padding:10px;background-color: #21262f">
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
            <div title="统计分析" data-options="iconCls:'icon-search'" style="padding:10px;background-color: #21262f">
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
            <div title="报表分析" data-options="iconCls:'icon-search'" style="padding:10px;background-color: #21262f">
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
    <div  id="center_content" class="easyui-tabs" style="width:90%;height: 90%"  data-options="region:'center',width:'80%'" >

        <div id="center_page" title="首页">
            <div id="i-center">
                <div id="center_top">
                    <label for="company">公司：</label>
                    <input id="company" name="company" />
                    <label for="carteam">车队：</label>
                    <input id="carteam" name="carteam"  data-options="valueField:'id',textField:'text'"/>
                </div>
                <div id="center_center">
                    <table>
                        <th>信息综述:</th>
                        <tr>
                            <td>
                                注册轮胎数量：
                            </td>
                            <td>
                            999999999999999999999999999999999999999
                            </td>
                            <td>
                                库存轮胎数辆：
                            </td>
                            <td>
                            99999999999999999999999999999999999999999
                            </td>
                        </tr>
                        <tr>
                            <td>
                                装车轮胎数量：
                            </td>
                            <td>

                            </td>
                            <td>
                                报废轮胎数量：
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                运营中车辆数：
                            </td>
                            <td>

                            </td>
                            <td>
                                报废车辆数量：
                            </td>
                            <td>

                            </td>
                        </tr>

                    </table>

                </div>
                <div id="center_bottom">
                    <table>
                        <th>胎温胎压未读报警信息：</th>
                        <tr>
                            <td rowspan="3">
                                未报警条数：<a href="javaScript(0)">9条</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                高压报警条数：
                            </td>
                            <td>

                            </td>
                            <td>
                                高温报警条数：
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                低压报警条数：
                            </td>
                            <td>

                            </td>
                            <td>
                                快速漏气报警条数：
                            </td>
                            <td>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <div id="south" data-options="region:'south',split:'true'" style="height:50px">
        <span> @2015 轮胎全生命管理周期系统 版权所有 v1.17</span>
    </div>

</body>
</html>