
Toolbar = function (config) {
    //承载容器
    this.renderTo = config.renderTo;
    //边框显示在哪里
    this.border = config.border || 'bottom';
    //子组件
    this.items = config.items || [];
    this.gitems = [];
    //过滤组件
    this.filters = config.filters || [];
    //初始化激活哪个按钮
    this.active = config.active;
    //是否有AZ组件
    this.azable = config.azable;
    //AZ隐藏变量
    this.azparam = $('#' + config.azparam);
    //承载容器
    this.renderContent = typeof this.renderTo == 'string' ? $('#' + this.renderTo) : this.renderTo;
    //AZ集合
    this.azs = ['ALL', '0~9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
};
Toolbar.prototype = {
    init: function () {
        //工具按钮层
        this.toolbar = $('<DIV></DIV>');
        this.toolbar.addClass('toolbar');
        if (this.border != 'none') {
            this.toolbar.css('border-' + this.border, 'solid 1px #8DB2E3');
        }
        this.toolbar.appendTo(this.renderContent);
        this.toolbar_table = $('<TABLE></TABLE>');
        this.toolbar_table.appendTo(this.toolbar);
        this.toolbar_table_row = $('<TR></TR>');
        this.toolbar_table_row.appendTo(this.toolbar_table);

        //距离左边有空
        var paddingTd = $('<TD></TD>');
        paddingTd.css('width', 2);
        paddingTd.appendTo(this.toolbar_table_row);

        //过滤组件
        this.filterTable = $('<TABLE></TABLE>');
        this.filterTable.attr('cellPadding', 0);
        this.filterTable.attr('cellSpacing', 0);
        this.filterTable.attr('id', 'filterTable');
        this.filterTable.addClass('filterTable');
        this.filterTable.appendTo(this.toolbar);
        this.filterTr = $('<TR></TR>');
        this.filterTr.appendTo(filterTable);

        //循环子组件
        for (var i = 0; i < this.items.length; i++) {
            this.add(this.items[i]);
        }

        //循环过滤组件
        for (var i = 0; i < this.filters.length; i++) {
            this.addFilter(this.filters[i]);
        }
    }, render: function () {
        this.init();
        return this;
    }, genAZ: function () {
        //如果有az控件
        if (this.azable) {
            this.createAZFix();
            this.createAZButton();
        }
    },
    add: function (t) {
        var toolbarEntity = this;
        if (t == '-') {
            var it = $('<TD></TD>');
            it.appendTo(this.toolbar_table_row);
            var spacer = $('<SPAN></SPAN>');
            spacer.addClass('spacer');
            spacer.appendTo(it);
        } else {
            if (t.type == 'button' || t.type == 'az') {
                var it = $('<TD></TD>');
                it.appendTo(this.toolbar_table_row);
                var itemTable = $('<TABLE></TABLE>');
                itemTable.addClass('button_table');
                itemTable.attr('cellPadding', 0);
                itemTable.attr('cellSpacing', 0);
                itemTable.appendTo(it);
                var itemTable_tr = $('<TR></TR>');
                itemTable_tr.appendTo(itemTable);
                var b_left = $('<TD></TD>');
                b_left.addClass('b_left');

                var b_center = $('<TD ></TD>');

                var button = $('<A></A>');
                this.gitems.push({ table: itemTable_tr, itemTable: itemTable, button: button, handler: t.handler });
                button.text(t.text);
                if (t.bodyStyle) {
                    button.addClass(t.bodyStyle);
                }
                b_center.css("padding-left", "18px");
                b_center.addClass('b_center');
                if (t.btnicon) {
                    
                    b_center.css("background", "url(" + t.btnicon + ") no-repeat 0 2px")
                };

                button.appendTo(b_center);
                if (t.title) {
                    button.attr('title', t.title);
                }

                var b_right = $('<TD></TD>');
                b_right.addClass('b_right');
                itemTable_tr.append(b_left);
                itemTable_tr.append(b_center);
                itemTable_tr.append(b_right);
                if (t.type == 'button') {
                    //是否有权限
                    if (t.useable != 'F') {
                        if (t.handler) {
                            button.bind('click', t.handler);                           
                        }
                        itemTable_tr.bind('mouseover', function () {
                            var b = $(this);
                            b.addClass('over');
                            b.bind('mouseout', function () {
                                b.removeClass('over');
                                b.removeClass('down');
                            });
                        });
                        itemTable_tr.bind('mousedown', function () {
                            var b = $(this);
                            b.addClass('down');
                            b.bind('mouseup', function () {
                                b.removeClass('down');
                                b.unbind('mouseup');
                            });
                        });
                    } else {
                        button.attr('disabled', true);
                        itemTable.addClass('toolbar_disabled');
                    }
                } else {
                    itemTable_tr.bind('mouseover', function () {
                        var b = $(this);
                        b.addClass('over');
                        b.bind('mouseout', function () {
                            b.removeClass('over');
                            b.removeClass('down');
                        });
                    });
                    itemTable_tr.bind('mousedown', function () {
                        var b = $(this);
                        b.addClass('down');
                        b.bind('mouseup', function () {
                            b.removeClass('down');
                            b.unbind('mouseup');
                        });
                    });
                    itemTable.attr('title', '\u70b9\u51fb\u5c55\u5f00\u641c\u7d22\u9879');
                    this.azTrigger = itemTable;
                    button.bind('click', function () {
                        toolbarEntity.showAZ(toolbarEntity);
                    });
                }
            } else {
                if (t.type == 'textfield') {
                    var it = $('<TD></TD>');
                    var txt = $('<td>' + t.text + '</td>');
                    txt.appendTo(this.toolbar_table_row);
                    it.appendTo(this.toolbar_table_row);
                    var cop = $('<INPUT/>');
                    cop.attr('id', t.id);
                    cop.attr('name', t.id);
                    cop.attr('type', 'text');
                    cop.addClass('textfield');
                    cop.appendTo(it);
                    if (t.bodyStyle) {
                        cop.addClass(t.bodyStyle);
                    }
                    if (t.handler) {
                        cop.bind('click', t.handler);
                    }
                } else {
                    var it = $('<TD></TD>');
                    it.appendTo(this.toolbar_table_row);
                    var itemTable = $('<TABLE></TABLE>');
                    itemTable.attr('cellPadding', 0);
                    itemTable.attr('cellSpacing', 0);
                    itemTable.appendTo(it);
                    var itemTable_tr = $('<TR></TR>');
                    itemTable_tr.appendTo(itemTable);
                    var itemTable_tr_td = $('<TD></TD>');
                    itemTable_tr_td.appendTo(itemTable_tr);
                    if (typeof t.html == 'string') {
                        itemTable_tr_td.html(t.html);
                    } else {
                        itemTable_tr_td.append(t.html);
                    }
                }
            }
        }
    },
    addFilter: function (t) {
        var toolbarEntity = this;

        var it = $('<TD></TD>');
        it.appendTo(this.filterTr);
        var itemTable = $('<TABLE></TABLE>');
        itemTable.addClass('button_table');
        itemTable.attr('cellPadding', 0);
        itemTable.attr('cellSpacing', 0);
        itemTable.appendTo(it);
        var itemTable_tr = $('<TR></TR>');
        itemTable_tr.appendTo(itemTable);
        var b_left = $('<TD></TD>');
        b_left.addClass('b_left');
        var b_center = $('<TD></TD>');
        b_center.addClass('b_center');
        var button = $('<A></A>');
        this.gitems.push({ table: itemTable_tr, itemTable: itemTable, button: button, handler: t.handler });
        button.text(t.text);
        if (t.bodyStyle) {
            button.addClass(t.bodyStyle);
        }
        button.appendTo(b_center);
        if (t.title) {
            button.attr('title', t.title);
        }

        var b_right = $('<TD></TD>');
        b_right.addClass('b_right');
        itemTable_tr.append(b_left);
        itemTable_tr.append(b_center);
        itemTable_tr.append(b_right);

        if (t.handler) {
            button.bind('click', t.handler);
        }
        itemTable_tr.bind('mouseover', function () {
            var b = $(this);
            b.addClass('over');
            b.bind('mouseout', function () {
                b.removeClass('over');
                b.removeClass('down');
            });
        });
        itemTable_tr.bind('mousedown', function () {
            var b = $(this);
            b.addClass('down');
            b.bind('mouseup', function () {
                b.removeClass('down');
                b.unbind('mouseup');
            });
        });


    },
    createAZFix: function () {
        var az_trigger = this.azTrigger;
        this.az_fix = $('<TABLE></TABLE>');
        ////原本是左右边框各4像素，但是按钮有2px的左右margin，因此只-2
        //this.az_fix.css('left', (az_trigger.offset().left - 2));
        ////-2的原因是：1为边框，1为边框上面的1像素白色
        //if (this.border == 'bottom') {
        //    this.az_fix.addClass('az-fix');
        //    this.az_fix.css('top', (az_trigger.offset().top + az_trigger.get(0).offsetHeight - 2));
        //} else {
        //    this.az_fix.addClass('az-fix-2');
        //    this.az_fix.css('top', (az_trigger.offset().top - 3));
        //}
        //this.az_fix.attr('cellSpacing', 0);
        //this.az_fix.attr('cellPadding', 0);
        //this.az_fix.appendTo($(document.body));
        //var az_fix_tr = $('<TR></TR>');
        //az_fix_tr.appendTo(this.az_fix);
        //var az_fix_tr_left = $('<TD></TD>');
        //az_fix_tr_left.addClass('left');
        //var az_fix_tr_center = $('<TD></TD>');
        //az_fix_tr_center.css('width', (az_trigger.get(0).offsetWidth - 4));
        //az_fix_tr_center.addClass('center');
        //var az_fix_tr_right = $('<TD></TD>');
        //az_fix_tr_right.addClass('right');
        //az_fix_tr_left.appendTo(az_fix_tr);
        //az_fix_tr_center.appendTo(az_fix_tr);
        //az_fix_tr_right.appendTo(az_fix_tr);
    },
    createAZButton: function () {
        var toolbarEntity = this;
        //创建az层
        //  this.azbar = $('<DIV></DIV>');
        //  this.azbar.addClass('az');
        this.azbar = $('.az');
        //设置border
        this.azbar.css('border-' + this.border, 'solid 1px #8DB2E3');
        //判断是位移方向
        if (this.border == 'bottom') {
            this.azbar.css('top', this.toolbar.offset().top + this.toolbar.height() + 1);
        } else {
            this.azbar.css('top', (this.toolbar.offset().top - this.toolbar.height() - 2));
        }

        //添加到toolbar中
        this.azbar.appendTo($(document.body));

        //  //创建aztable
        //  var aztable = $('<TABLE></TABLE>');
        //  aztable.appendTo(this.azbar);
        //  aztable.attr('cellSpacing', 0);
        //  aztable.attr('cellPadding', 0);
        //    
        //  //创建tr
        //  var aztable_tr = $('<TR></TR>');
        //  aztable_tr.appendTo(aztable);


    },
    showAZ: function (toolbarEntity) {
        if (toolbarEntity.azbar.css('display') == 'none') {
            this.azTrigger.addClass('over');
            toolbarEntity.az_fix.fadeIn(100, function () {
                toolbarEntity.azbar.fadeIn(100);
            });
        }
        else {
            this.azTrigger.removeClass('over');
            toolbarEntity.azbar.fadeOut(100, function () {
                toolbarEntity.az_fix.fadeOut(100);
            });
        }
        serchpanel()
    }
    , setText: function (position, str) {
        this.gitems[position].button.text(str);
    }, getText: function (position) {
        return this.gitems[position].button.text();
    }, setDisabled: function (position, dis) {
        var it = this.gitems[position];
        if (it) {
            if (dis) {
                it.button.attr('disabled', dis);
                it.table.unbind('mouseover');
                it.table.unbind('mousedown');
                it.button.unbind('click');
                it.itemTable.addClass('toolbar_disabled');
            } else {
                it.button.removeAttr('disabled');
                it.itemTable.removeClass('toolbar_disabled');
                it.table.bind('mouseover', function () {
                    var b = $(this);
                    b.addClass('over');
                    b.bind('mouseout', function () {
                        b.removeClass('over');
                        b.removeClass('down');
                    });
                });
                it.table.bind('mousedown', function () {
                    var b = $(this);
                    b.addClass('down');
                    b.bind('mouseup', function () {
                        b.removeClass('down');
                        b.unbind('mouseup');
                    });
                });
                it.button.bind('click', it.handler);
            }
        }
    }, getDisabled: function (position) {
        return this.gitems[position].button.attr('disabled');
    }
};