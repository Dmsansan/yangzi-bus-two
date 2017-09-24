create database DBTTMS character set=utf8;

-- 1、管理员表
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
    role_id         int                 comment '用户角色',
    is_term         char(1)             comment '是否终端用户',
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

-- 3、管理员角色表
  create table roles (
    role_id         int auto_increment,
    role_name       varchar(32)         comment '角色英文名',
    title           varchar(64)         comment '角色中文名',
    modules_list    text                comment '模块列表，用逗号分隔',
    operlist        varchar(64)         comment '权限列表',
    remark          varchar(300)        comment '角色说明',
    primary key (role_id),
    unique (role_name)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 4、系统模块表
  create table modules (
    module_id       int auto_increment,
    module_code     varchar(16)         comment '模块代码',
    parent_id       int                 comment '上级模块ID',
    ico             varchar(256)        comment '模块图标',
    module_level    int                 comment '模块层级', 
    module_name     varchar(32)         comment '模块英文名',
    title           varchar(64)         comment '模块中文名',
    menu_name       varchar(64)         comment '模块对应的菜单名（备用）',
    menu_url        varchar(256)        comment '模块对应的菜单URL（备用）',
    remark          varchar(300)        comment '模块说明',
    primary key (module_id),
    unique (module_name)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 5、车队(仓库)表
  create table store (
    store_id        int auto_increment,
    admin_id        int                 comment '用户ID',
    store_no        varchar(20)         comment '仓库内部编号',
    store_name      varchar(60)         comment '仓库中文名',
    contact         varchar(32)         comment '联系人姓名',
    tel             varchar(32)         comment '联系电话',
    mobile          varchar(32)         comment '联系人手机号',
    fax             varchar(32)         comment '仓库传真',
    country         varchar(100)        comment '国家',
    province        varchar(60)         comment '省、直辖市',
    city            varchar(60)         comment '地级市',
    county          varchar(60)         comment '区、县',
    address         varchar(300)        comment '仓库地址',
    remark          varchar(300)        comment '仓库说明',
    primary key (store_id),
    unique (store_name),
    unique (store_no)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 6、手持终端表
  create table terminal (
    terminal_id     int auto_increment,
    admin_id        int                 comment '用户ID',
    terminal_ip     varchar(64)         comment '终端IP',
    store_id	    int					comment '终端归属车队',
    status          char(8)             comment '状态',
    last_admin_id   int                 comment '最后一次登录该设备的用户ID',
    last_stamp      timestamp default current_timestamp          comment '最后一次登录时间',
    remark          varchar(300)        comment '终端备注',
    primary key (terminal_id)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 7、轮胎品牌表
  create table brand (
    brand_id        int auto_increment,
    brand_no        varchar(20)         comment '品牌代码',
    brand_name      varchar(100)        comment '品牌名称',
    remark          varchar(200)        comment '备注',
    primary key (brand_id),
    unique (brand_no),
    unique (brand_name)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 8、轮胎规格表
  create table norms (
    norms_id        int auto_increment,
    norms_no        varchar(20)         comment '规格代码',
    norms_name      varchar(40)         comment '规格名称',
    remark          varchar(200)        comment '备注',
    primary key (norms_id),
    unique (norms_no),
    unique (norms_name)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 9、轮胎层级表
  create table class (
    class_id        int auto_increment,
    class_no        varchar(20)         comment '层级代码',
    class_name      varchar(40)         comment '层级名称',
    remark          varchar(200)        comment '备注',
    primary key (class_id),
    unique (class_no),
    unique (class_name)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- 10、车载终端表
  create table vehicle_term (
    v_term_id       int auto_increment,
    plate_no        varchar(20)         comment '车牌号码',
    v_term_no       varchar(20)         comment '车载终端编号',
    v_term_name     varchar(40)         comment '车载终端名称',
    renew_stamp     timestamp default current_timestamp          comment '里程更新时间',
    store_id        int                 comment '所属仓库车队',
    mile_count      int                 comment '累计里程',
    remark          varchar(200)        comment '备注',
    primary key (v_term_id),
    unique (v_term_no)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 11、轮胎参数表
  create table tire_info (
    tire_id         int auto_increment,
    tire_rfid       varchar(20)         comment '轮胎身份ID',
    factory_code    varchar(20)         comment '轮胎出厂编码',
    brand_id        int                 comment '轮胎品牌',
    norms_id        int                 comment '轮胎规格',
    class_id        int                 comment '轮胎层级',
    rated_mile      int                 comment '额定里程',
    status          char(8)             comment '状态',
    last_stamp      timestamp default current_timestamp           comment '最近操作时间',
    add_stamp       timestamp           comment '入库时间',
    store_id        int                 comment '仓库编号',
    plate_no        varchar(20)         comment '车牌号码',
    place           varchar(100)        comment '装车位置',
    place_stamp     timestamp           comment '装车时间',
    mile_count      int                 comment '累计里程',
    reason          varchar(256)        comment '报废理由',
    remark          varchar(200)        comment '备注',
    primary key (tire_id),
    unique (tire_rfid),
    unique (factory_code)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 12、汽车信息表
  create table bus_info (
    bus_id          int auto_increment,
    plate_no        varchar(20)         comment '车牌号码',
    store_id        int                 comment '仓库/车队编号',
    v_term_id       int                 comment '车载终端编号',
    remark          varchar(200)        comment '备注',
    primary key (bus_id),
    unique (plate_no)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


