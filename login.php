
<html>
<head>
    <meta charset="UTF-8" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>登录页面</title>
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/lib/jquery.js"></script>
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>
	
	<script src="lib/jquery/jquery-1.9.0.min.js" type="text/javascript"></script>
	<script src="lib/jquery.md5.js" type="text/javascript"></script>
	<link href="lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />
	<!--<link href="lib/ligerUI/skins/ext/css/ligerui-fix.css" rel="stylesheet" type="text/css" />-->
	<script src="lib/json2.js" type="text/javascript"></script>
	<script src="lib/ligerUI/js/core/base.js" type="text/javascript"></script>   
	<script src="lib/ligerUI/js/core/inject.js" type="text/javascript"></script>   
	<script src="lib/ligerUI/js/ligerui.all.js" type="text/javascript"></script> 
	<link href="css/homepagecss/loginCss.css" type="text/css" rel="stylesheet"/>
	<script type="text/javascript">
        $( function() {
          //获取cookie
          var cusername = getCookie('customername');
          var cpassword = getCookie('customerpass');
          if(cusername != "" && cpassword != ""){
            $("#userid").val(cusername);
            $("#userkey").val(cpassword);
          }
        })

        function f_redirect()
        {
            if($('#rememberpass').is(':checked')){
              setCookie('customername', $('#userid').val().trim(), 7)
              setCookie('customerpass', $('#userkey').val().trim(), 7)
            }else{
              setCookie('customername', '', 7)
              setCookie('customerpass', '', 7)
            }
        	window.location.href="main.php";
        }
        function reset(){
        	$('#userid').val("");
        	$('#userkey').val("");
        }
        function f_error()
        {
        	return;
        	$.ligerDialog.confirm("登陆失败，继续进入？", function (yes) {
                            if (yes){
        							window.location.href="main.php";
        					}
        	});	
        }
        function LoginSystem()
        {
        	//
        	var userid=document.getElementById("userid").value;
        	var userpass=document.getElementById("userkey").value;
        	userpass=$.md5(userpass);
        	if(userid==""){
        		//alert("ee");
        		top.$.ligerDialog.error(' 请输入用户名!');
        		//document.getElementById("userid").focus();
        		return;
        	}
        	
        	//这里开始登陆
        	$.ajax({
        		url: "ajaction/v1/?menuid=0", type: "POST",
                data: { cmd:"login",userid: userid,password:userpass ,rnd: Math.random() },
                success: function (responseText) {
        				//alert(responseText);
        			responseText=$.trim(responseText);
        			
        			if(typeof(responseText)=="undefined" || responseText=="" || responseText==null){
        				//服务器没有数据反回
        				top.$.ligerDialog.error("未知错误");
        				f_error();
        			}else{
        				var dataObj = eval("("+responseText+")");
        									
        					if (dataObj.status == "OK") {
        							f_redirect();
        					}else{
        						top.$.ligerDialog.error(dataObj.reason);
        						f_error();
        					}
        			}
                },
                error: function () {
        			top.$.ligerDialog.error('登陆失败!请检查网络');
        			f_error();
                }
            });
        	
        }
        //设置cookie
        //var passKey = '4c05c54d952b11e691d76c0b843ea7f9';
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + escape(cvalue) + "; " + expires;
        }
        //获取cookie
        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1);
                if (c.indexOf(name) != -1){
                  var cnameValue = unescape(c.substring(name.length, c.length));
                  return cnameValue;
                } 
            }
            return "";
        }
        //清除cookie  
        function clearCookie(cname) {  
            setCookie(cname, "", -1);  
        }

       
</script>
<style type="text/css">
    *{overflow:hidden; font-size:9pt;}
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
            background-image: url(images/bg.png);
            /*background-repeat: repeat-x;*/
        }
        #frmLogin table tr td table tr td table tr td h1 strong font {
            font-size: 30pt;
            color: #06F;
        }
</style>
</head>
<body>
<table width="100%"  height="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="172" style="backgroundurl:url(images/login02.png)"><table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="172" align="center" style="background:url(images/login01.png)"><div style="width: 650px; float: center; font-size:18px; font-family: Microsoft YaHei; color:white; padding-top: 119px;">
                                轮胎全生命周期管理系统
                            </div></td>
                        </tr>
                        <tr>
                            <td height="210">

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <!--<td width="208" height="190" style="background:url(../../images/login02.png)">&nbsp;</td>-->
                                        <td height="210" style="background:url(images/login03.png)"><table width="320" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="40" height="80"><img src="images/user.png" width="40" height="41"></td>
                                                <!--<td width="38" height="50">用户</td>-->
                                                <td width="280" height="80"><input type="text" name="userid" id="userid" placeholder="请输入管理员名称" style="width:261px; outline:none; font-size: 16px; height:41px; line-height:42px; background:url(images/inputbg.png) repeat-x; border:0; font-size:9pt; font-family:Verdana, Geneva, sans-serif;"></td>
                                            </tr>
                                            <tr>
                                                <td height="50"><img src="images/password.png" width="40" height="41"></td>
                                                <!--<td height="50">密码</td>-->
                                                <td height="50"><input type="password" name="userkey" id="userkey" placeholder="请输入管理员密码" style="width:261px;  outline:none; font-size: 16px; height:41px; line-height:42px; background:url(images/inputbg.png) repeat-x; border:0; font-size:9pt; "></td>
                                            </tr>
                                            <tr>
                                                <td height="40">&nbsp;</td>
                                                <td height="40" style="padding-left:160px;width: 30px; height: 30px; font-size: 16px;  color: grey;">
                                                   
                                                    记住密码：<input type="checkbox" id="rememberpass"  checked="checked" style="width: 18px; height: 18px;"></td>

                                            </tr>


                                        </table></td>
                                        <!--<td width="214" style="background:url(../../images/login04.png)" >&nbsp;</td>-->
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr height="133">
                            <td height="94" style="background:url(images/login05.png) no-repeat; padding-left: 168px; padding-bottom: 45px;">



                                <input name="imgbtn" type="image" style="cursor:hand; outline:none; padding-right: 39px;" src="images/login.png" width="131" height="40" border="0"  onclick="LoginSystem();">
                                <!--<img src="images/login.gif"  style="cursor:hand" width="95" height="34" onclick="document.frmLogin.submit;"/>-->
                                <input name="imgbtn" type="image" style="cursor:hand; outline:none;"  src="images/login1.png" width="131" height="40" border="0" onclick="reset();">
                                <!--<img src="images/login.gif"  style="cursor:hand" width="95" height="34" onclick="document.frmLogin.submit;"/>-->



                            </td>

                        </tr>
                    </table></td>
                </tr>
            </table></td>
    </tr>
</table>
</body>
</html>