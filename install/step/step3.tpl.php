<?php include SYSTEM_PATH.'install/step/header.tpl.php';?>
	<div class="body_box">
        <div class="main_box">
            <div class="hd">
            	<div class="bz a3"><div class="jj_bg"></div></div>
            </div>
            <div class="ct">
            	<div class="bg_t"></div>
                <div class="clr">
                    <div class="l"></div>
                    <div class="ct_box nobrd i6v">
                    <div class="nr">
					<form id="install" action="install.php?" method="post">
					<input type="hidden" name="step" value="4">
<fieldset>
	<legend>必选模块</legend>
	<div class="content">
    	<label><input type="checkbox" name="sys_manage" value="sys_manage" checked disabled>系统管理</label>
        <label><input type="checkbox" name="tire_manage" value="tire_manage" checked disabled>轮胎管理</label>
        <label><input type="checkbox" name="bus_manage" value="bus_manage" checked  disabled>车辆管理</label>
       <label><input type="checkbox" name="sys_mon" value="sys_mon" checked  disabled>监测系统</label>
       <label><input type="checkbox" name="sys_log" value="sys_log" checked  disabled>系统日志</label>
    </div>
</fieldset>
					</form>
					</div>
                    </div>
                </div>
                <div class="bg_b"></div>
            </div>
            <div class="btn_box"><a href="javascript:history.go(-1);" class="s_btn pre">上一步</a><a href="javascript:void(0);"  onClick="$('#install').submit();return false;" class="x_btn">下一步</a></div>
        </div>
    </div>
</body>
</html>
