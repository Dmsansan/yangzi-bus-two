<?
//require_once("check_login.php");
require_once("../../config.inc.php");

$conn = new db(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS,true,SYSTEM_PATH.'log');

/*
  create table admins (
    admin_id        int auto_increment,
    admin_name      varchar(32)         comment '管理员用户名',
    password        varchar(32)         comment '登录密码',
    pass_key        varchar(32)         comment '密码重置标志',
    real_name       varchar(32)         comment '管理员真实姓名',
    email           varchar(100)        comment '邮箱地址，通常用邮箱登陆系统',
    tel             varchar(32)         comment '联系电话',
    mobile          varchar(32)         comment '联系人手机号',
    qq              varchar(16)         comment 'QQ号码',
    weixin          varchar(32)         comment '微信号码',
    remark          varchar(300)        comment '备注',
    roles_list      text                comment '角色列表，用逗号分隔',
    status          char(8)             comment '状态',
    last_ip         varchar(64)         comment '最后一次登录IP',
    last_stamp      timestamp default current_timestamp          comment '最后一次登录时间',
    login_times     int default 0       comment '登录次数',
    reg_ip          varchar(64)         comment '注册时使用的IP',
    reg_stamp       timestamp           comment '注册时间',
    primary key (admin_id),
    unique (admin_name),
    unique (email)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/

$admin_name=trim($_REQUEST["admin_name"]."");
$password=md5(trim($_REQUEST["password"].""));
$email=trim($_REQUEST["email"]."");
//$admin_name="丁海峰";

if($admin_name == "" || $password == "" || $email == ""){
//    ErrBack("参数不完整！");
    Alert("参数不完整！");
    die();
}

$sql="insert into admins (admin_name,password,email) values ";
$sql.=" ('$admin_name','$password','$email')";

$conn->query($sql);

//$id=$conn->insert_id();
//do_log($conn, "添加", "用户添加了广告：$id");
//ErrTo("添加成功！","test.php");
Alert("添加成功！");
?>
