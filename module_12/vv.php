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
	
        $(function () {
		
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
<body class="easyui-layout" style="width:100%;">

	

</body>
</html>