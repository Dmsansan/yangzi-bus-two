

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>轮胎全生命周期管理系统</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge chrome=1" />

    <link href="lib/ligerUI/skins/ext/css/ligerui-all.css" rel="stylesheet" type="text/css" />
    <link href="lib/ligerUI/skins/ext/css/ligerui-fix.css" rel="stylesheet" type="text/css" />
	<!--<link href="lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />-->
    <script src="lib/jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="lib/ligerUI/js/ligerui.all.js" type="text/javascript"></script>
    <script src="lib/ligerUI/js/plugins/ligerDrag.js" type="text/javascript"></script>
    <script src="lib/ligerUI/js/plugins/ligerResizable.js" type="text/javascript"></script>
    <script src="lib/ligerUI/js/plugins/ligerLayout.js" type="text/javascript"></script>
    <script src="lib/ligerUI/js/plugins/ligerTab.js" type="text/javascript"></script>
    <script src="lib/ligerUI/js/plugins/ligerAccordion.js" type="text/javascript"></script>
    <script src="lib/ligerUI/js/plugins/ligerDialog.js" type="text/javascript"></script>
    <script src="lib/ligerUI/js/plugins/ligerGrid.js" type="text/javascript"></script>
    <script src="lib/ligerUI/js/plugins/ligerMenu.js" type="text/javascript"></script>
    <script src="lib/ligerUI/js/plugins/ligerTree.js" type="text/javascript"></script>
    <script src="lib/ligerUI/js/plugins/ligerToolBar.js" type="text/javascript"></script>
    <script src="js/jquery.jclock.js" type="text/javascript"></script>

    <script src="js/XHD.js" type="text/javascript"></script>
    <script type="text/javascript">
        var tab = null;
        var accordion = null;
        var accordion2 = null;
        var tree = null;
        var manager = null;
        $(function () {
            setInterval("getUser()", 30000);
            $("#pageloading").height($(window).height());
            //布局
            $("#layout1").ligerLayout({ leftWidth: 190, bottomHeight: 25, allowBottomResize: false, allowLeftResize: false, allowRightResize: true, height: '100%', onHeightChanged: f_heightChanged
						
			});
            var height = $(".l-layout-center").height();
            //Tab
            tab = $("#framecenter").ligerTab({
                height: height,
                dblClickToClose: true,
                showSwitch: true,       //显示切换窗口按钮
                showSwitchInTab: true //切换窗口按钮显示在最后一项 
            });

            //面板              
            accordion = $("#accordion1").ligerAccordion({ height: height - 25 });
            //accordion2 = $("#accordion2").ligerAccordion({ height: height - 25 });
            //f_according();

            //时间日期
            $('#jnkc').jclock({ withDate: true, withWeek: true });

            initLayout();
            $(window).resize(function () {
                initLayout();
            });

            getsysinfo();
            getuserinfo();
            toolbar();
            remind();
            show_welcome();
            $("#mainframe").attr("src", "welcome.html");           
                        
        });
        function getsysinfo() {
            /*$.ajax({
                type: "GET",
                url: "ajdata/sys/sys_info.grid.php", 
                data: { rnd: Math.random() },
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (result) {
                    var obj = eval(result);
                    var rows = obj.Rows;

                    var sysinfo = {};
                    for (var i = 0; i < rows.length; i++) {
                        if (rows[i].sys_value == "null" || rows[i].sys_value == null) {
                            rows[i].sys_value = " ";
                        }
                        sysinfo[rows[i].sys_key] = rows[i].sys_value;
                    }
                    document.title = sysinfo["sys_name"] + "CRM客户关系管理系统-小黄豆CRM";
                    //$("#logo").attr("src", sysinfo["sys_logo"]);
                }
            });*/
        }
        function getuserinfo() {
            $.getJSON("ajaction/sysaction/sys.getuserinfo.php?rnd=" + Math.random(), function (data, textStatus) {
                //alert(data);
				//alert(textStatus);
                $("#Username").html("<div onclick='personalinfoupdate()' style='cursor:pointer'>" + data.real_name+"</div>");
                /*if (data.title)
                    $("#userheader").attr("src", "/images/upload/portrait/" + data.title);
                else
                    $("#userheader").attr("src", "/images/icons/function_icon_set/user_48.png");
				*/
            });
        }

        function getUser() {
            
            remind();
        }
        function remind() {
            var now = new Date(), hour = now.getHours();
            if (hour > 4 && hour < 6) { $("#labelwelcome").html("凌晨好！") }
            else if (hour < 9) { $("#labelwelcome").html("早上好！") }
            else if (hour < 12) { $("#labelwelcome").html("上午好！") }
            else if (hour < 14) { $("#labelwelcome").html("中午好！") }
            else if (hour < 17) { $("#labelwelcome").html("下午好！") }
            else if (hour < 19) { $("#labelwelcome").html("傍晚好！") }
            else if (hour < 22) { $("#labelwelcome").html("晚上好！") }
            else { $("#labelwelcome").html("夜深了，注意休息！") }
        }

        function f_heightChanged(options) {
            if (tab)
                tab.addHeight(options.diff);
            if (accordion && options.middleHeight - 25 > 0)
                accordion.setHeight(options.middleHeight - 25);
            /*if (accordion2 && options.middleHeight - 25 > 0)
                accordion2.setHeight(options.middleHeight - 25);*/
        }
        function f_addTab(tabid, text, url) {
            tab.addTabItem({ tabid: tabid, text: text, url: url });
        }

        function onSelect(node) {
            if (!node.data.url) return;
            var tabid = $(node.target).attr("tabid");
            if (!tabid) {
                //tabid = new Date().getTime();
                tabid = node.data.id;
                $(node.target).attr("tabid", tabid)
            }
            f_addTab(tabid, node.data.text, node.data.url);
        }
        function changepwd() {
            var dialog = $.ligerDialog.open({
                url: "module_sys/sys.changepwd.php", width: 480, height: 250, title: "修改密码", buttons: [
                        {
                            text: '保存', onclick: function (item, dialog) {
                                dialog.frame.f_save();
                            }
                        },
                        {
                            text: '关闭', onclick: function (item, dialog) {
                                dialog.close();
                            }
                        }
                ], isResize: true, timeParmName: 'a'
            });
        }

        function logout() {
            $.ligerDialog.confirm('您确认要退出系统？', function (yes) {
                if (yes) {
                    $.ajax({
                        type: 'post',
                        //dataType: 'json',
                        url: 'ajaction/v1/?menuid=0',
                        data: { cmd: 'logout'},
                        success: function (responseText) {
							
							if(typeof(responseText)=="undefined" || responseText=="" || responseText==null){
							//服务器没有数据反回
								top.$.ligerDialog.error("未知错误");							
							}else{
								var dataObj = eval("("+responseText+")");
									
								if (dataObj.status == "OK") {
									
								}else {
									top.$.ligerDialog.error(dataObj.reason);									
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
        function toolbar() {
            $.getJSON("ajaction/sysaction/sys.getmodules.php?rnd=" + Math.random(), function (data, textStatus) {

                var items = data.Items;
				var bacc=false;
				for(var i=0;i<items.length;i++){
					if (items[i].id==13){
						f_according(13);  //默认显示这个菜单
						bacc=true;
						break;
					}
				}
				if(!bacc && items.length>=1){
					f_according(items[0].id);
				}				
                //items.push({ type: "filter", icon: 'images/icon/61.png', title: "系统信息", click: function () { f_addTab('home'); } });
               // items.push({ type: "filter", icon: 'images/icon/37.png', title: "个人设置", click: function () { personalinfoupdate(); } });
                items.push({ type: "filter", icon: 'images/icon/77.png', title: "修改密码", click: function () { changepwd(); } });
                //items.push({ type: "filter", icon: 'images/icon/51.png', title: "版权信息", click: function () { show_copyright(); } });
                //items.push({ type: "filter", icon: 'images/icon/68.png', title: "系统信息", click: function () { show_welcome(1); } });
                items.push({ type: "filter", icon: 'images/icon/1.png', title: "退出系统", click: function () { logout(); } });
   
                $("#toolbar").ligerToolBar({
                    background: false,
                    items: items
                });checkcr();
                
                $("#pageloading").fadeOut(800);
                //unView();
				
				
				
				
            });
        }
		//tabid计数器，保证tabid不会重复
            var tabidcounter = 0;
            //菜单初始化
			
		
        function f_according(appid) {
            if (!appid) appid = 10;

            var mainmenu = $("#accordion1");
            mainmenu.empty();
			var tabid="";
			var url="";
			var txt="";
			$.ajaxSettings.async = false; 
            $.getJSON("ajaction/sysaction/sys.getmodules.accordionmenu.php?module_id=" + appid + "&rnd=" + Math.random(), function (menus) {
                $(menus).each(function (i, menu) {
                    var item = $('<div title="' + menu.Menu_name + '"><ul class="menulist"></ul></div>');

                    $(menu.children).each(function (j, submenu) {
                        var subitem = $('<li><img/><span></span><div class="menuitem-l"></div><div class="menuitem-r"></div></li>');
                        subitem.attr({
                            url: submenu.Menu_url,
                            tabid: "tabid" + submenu.Menu_id,
                            menuno: submenu.Menu_id
                        });
                        $("img", subitem).attr("src", submenu.Menu_icon || submenu.icon);
                        $("span", subitem).html(submenu.Menu_name || submenu.text);

                        $("ul:first", item).append(subitem);
						if(submenu.Menu_id==131010){
							//
							//alert("默认打开车辆时实监控");
							//OpenDefaultMenu(submenu);
							
							tabid="tabid" + submenu.Menu_id;
							url=submenu.Menu_url;
							if (url && tabid){
							
								//tabidcounter++;
								tabid = "tabid0";
								
								if (url.indexOf('?') > -1) url += "&";
								else url += "?";
								url += "MenuNo=" + subitem.attr("menuno");
								txt=submenu.Menu_name;
								
								subitem.attr("tabid", tabid);
								subitem.attr("url", url);
								//f_addTab(tabid,submenu.Menu_name, url);
								
								
							}
							
							//var tabid="";
							//var url="";
							//var txt="";
							
						}
						
                    });
                    mainmenu.append(item);
                });
				
                accordion.render();
                accordion.setHeight($(".l-layout-center").height() - 25);
				
				//
				if(tabid!=""){
					
					f_addTab(tabid,txt, url);
				}
								
				
            });

            
			function OpenDefaultMenu(menu)
			{
					/*function f_addTab(tabid, text, url) {
						tab.addTabItem({ tabid: tabid, text: text, url: url });
					}*/
					
					
					
			}
			
            $("ul.menulist li").live('click', function () {
                var jitem = $(this);
                var tabid = jitem.attr("tabid");
                var url = jitem.attr("url");
                if (!url) return;
                if (!tabid) {
                    tabidcounter++;
                    tabid = "tabid" + tabidcounter;
                    jitem.attr("tabid", tabid);

                    //给url附加menuno
                    if (url.indexOf('?') > -1) url += "&";
                    else url += "?";
                    url += "MenuNo=" + jitem.attr("menuno");
                    jitem.attr("url", url);
                }
                //$("#mainframe").attr("src", url);                

                f_addTab(tabid, $("span:first", jitem).html(), url); 
				if ($(this).hasClass("selected")) {
                    return;
                }
                else {
                    $(".selected").removeClass("selected");
                    $(this).addClass("selected");
                }

            }).live('mouseover', function () {
                var jitem = $(this);
                jitem.addClass("over");
            }).live('mouseout', function () {
                var jitem = $(this);
                jitem.removeClass("over");
            });

        }
        function show_welcome(item) {
            if (getCookie("ttms_crm_show_wellcome") == 1 || item == 1) {
                var dialog = $.ligerDialog.open({
                    url: "welcome.html", width: 800, height: 500, title: "欢迎使用xxxx系统", buttons: [
                            {
                                text: '关闭', onclick: function (item, dialog) {
                                    dialog.close();
                                }
                            }
                    ], isResize: true, timeParmName: 'a'
                });
                SetCookie("ttms_crm_show_wellcome", "2");
            }
        }
        function show_copyright() {
            var dialog = $.ligerDialog.open({
                url: "License.html", width: 800, height: 500, title: "License", buttons: [
                        {
                            text: '关闭', onclick: function (item, dialog) {
                                dialog.close();
                            }
                        }
                ], isResize: true, timeParmName: 'a'
            });
        }
        function personalinfoupdate() {
			return;
            var dialog = $.ligerDialog.open({
                url: "hr/emp_personal_update.php", width: 760, height: 300, title: "个人信息", buttons: [
                        {
                            text: '保存', onclick: function (item, dialog) {
                                dialog.frame.f_save();
                            }
                        },
                        {
                            text: '关闭', onclick: function (item, dialog) {
                                dialog.close();
                            }
                        }
                ], isResize: true, timeParmName: 'a'
            });
        }
        //function flushiframegrid(tabid) {
        //    tab.flushiframegrid(tabid);
        //}
    </script>
    <style type="text/css">
        /* 菜单列表 */
        .menulist { margin-left: 2px; margin-right: 2px; margin-top: 2px; text-align: left; color: #000; padding: 0; }
            .menulist li { height: 24px; line-height: 24px; padding-left: 24px; display: block; position: relative; cursor: pointer; text-align: left; }
                .menulist li img { position: absolute; left: 4px; top: 4px; width: 16px; height: 16px; }
                .menulist li.over, .menulist li.selected { background: url('images/index/menuitem.gif') repeat-x 0px 0px; }
                    .menulist li.over .menuitem-l, .menulist li.selected .menuitem-l { background: url('images/index/menuitem.gif') repeat-x 0px -24px; width: 2px; height: 24px; position: absolute; left: 0; top: 0; }
                    .menulist li.over .menuitem-r, .menulist li.selected .menuitem-r { background: url('images/index/menuitem.gif') repeat-x -1px -24px; width: 2px; height: 24px; position: absolute; right: 0; top: 0; }
        <!--#portrait { border-radius: 4px; box-shadow: 1px 1px 1px #111; position: absolute; width: 48px; height: 48px; right: 7px; top: 10px; background: #d2d2f2 /*url(images/icons/32X32/user.gif) no-repeat center center*/; border: 3px solid #fff; behavior: url(css/pie.htc); text-align: center; }-->
    </style>
</head>
<body>
    <form id="form1" onsubmit="return false">
        <div id="pageloading"></div>
        <div style="background: #d2e2f2; height: 56px; overflow: hidden;">
            <div style="height: 47px; margin: 0; padding: 0;">
                <div style="width: 25%; float: left;">
                    <!--<a href="" target="_blank">-->
                        <img id="logo" alt="" src="images/logo/xhd.png" style="height: 42px; margin-left: 5px; margin-top: 2px;" />
                    <!--</a>-->
                </div>
				<div style="width:50%; float: left; font-size:38px; color:#06F">
                    <div style="font-size:38px; color:#06F" align="center">
					轮胎全生命周期管理系统
					</div>
                </div>					
                <div style="float: right; width: 220px; height: 47px; margin-right: 20px;">
                    <div style="width: 100%; height: 25px; text-align: right;">
                        <table style="width: 100%;">
                            <tr>
                                <td>
                                    <div id="jnkc" style="font-size: 12px; color: black; text-align: right;"></div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div style="width: 100%; height: 22px; line-height: 22px; vertical-align: bottom;">
                        <div id="labelwelcome" style="font-size: 12px; padding-right: 5px; width: 115px; margin-right: 80px; position: absolute; text-align: right;"></div>
                        <div id="Username" style="font-size: 12px; color: Red; padding-left: 18px; background: url(images/icon/37.png) no-repeat left center; width: 80px; float: right;"></div>

                    </div>
                </div>

                <!--<div id="portrait">
                    
                    <img id="userheader" width="48px" />
                </div>
				-->
				
            </div>           
            
        </div>
		
		<div style="margin: 0; padding: 0; background: url(images/headbg.gif); height: 28px; overflow: hidden; border-bottom: 1px solid #8db2e3; width: 100%;">
                <div id="toolbar" style="height: 27px; margin-top: 1px; padding-right: 70px;"></div>                
        </div>


        <div id="layout1" style="width: 100%">

            <div position="left" title="功能菜单" id="accordion1">
            </div>
            <div position="center" id="framecenter" >
                <!--<div tabid="home" title="系统信息" style="height: 300px;display:none">
                    <iframe frameborder="0" name="home" id="mainframe" ></iframe>
                </div>-->
            </div>            
            <div position="bottom">
                ©2015  轮胎全生命周期管理系统  版权所有 v1.17    
           
            </div>
        </div>
    </form>
</body>
</html>
