<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>登录页面</title>
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/lib/jquery.js"></script>
    <script src="http://static.runoob.com/assets/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>
    <link href="./css/logincss/loginCss.css" rel="stylesheet" type="text/css">
	
	<script src="lib/jquery/jquery-1.9.0.min.js" type="text/javascript"></script>
	<script src="lib/jquery.md5.js" type="text/javascript"></script>
	<link href="lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />
	<!--<link href="lib/ligerUI/skins/ext/css/ligerui-fix.css" rel="stylesheet" type="text/css" />-->
	<script src="lib/json2.js" type="text/javascript"></script>
	<script src="lib/ligerUI/js/core/base.js" type="text/javascript"></script>   
	<script src="lib/ligerUI/js/core/inject.js" type="text/javascript"></script>   
	<script src="lib/ligerUI/js/ligerui.all.js" type="text/javascript"></script> 

	<script type="text/javascript">
function f_redirect()
{
	window.location.href="main.php";
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
					}else {
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
</script>

</head>
<body>
<div class="top">

</div><!--top结束 -->
<div class="main">
    <div class="left">

    </div>
    <div class="center">
        <div class="c_top"></div>
        <div class="c_center">

                      <div class="loginForm">
		   

           	<div >

                <p>
                    <label for="userid">用户名：</label>
                    <input  id="userid" name="userid" type="text" placeholder="请输入用户名" name="userName">
                </p><br>
                <p>
                    <label for="userkey">密&nbsp;码：</label>
                    <input id="userkey" name="userkey" type="password" placeholder="请输入密码" name="userPassword">
                </p><br>
                <p>
                    <input id="renamePassword" type="checkbox"> <span>记住密码</span>
                </p>
                <p><br>
                    <input id="login" type="submit" onclick="LoginSystem()" value="登录">
                    <input id="reset" type="reset" value="重置">
                </p>

			</div>
			</div>


			</div>

        <div class="c_bottom">
            <p>版权所有：南京泰晟科技实业有限公司</p>
        </div>
    </div>
    <div class="right">

    </div>
</div>
</body>
</html>