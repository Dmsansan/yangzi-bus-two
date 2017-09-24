   <title>弹出选择器</title>     
 <meta name="keywords" content="免费控件,免费UI控件,免费开源UI,免费开源UI控件,免费开源UI框架,弹出选择器,popupedit">
 <link href="lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css">
 <link href="lib/ligerUI/skins/Gray/css/all.css" rel="stylesheet"> 
 <script src="lib/jquery/jquery-1.9.0.min.js" type="text/javascript"></script>  
 <script src="lib/ligerUI/js/ligerui.all.js" type="text/javascript"></script> 
 <script src="grid/CustomersData.js" type="text/javascript"></script> 
 
 
 
<input id="popTxt" type="text"> 
 
 <br>
 
 <div class="l-button" id="btn1" style="width: 60px;" ligeruiid="btn1"><div class="l-button-l"></div><div class="l-button-r"></div><span>获取值</span></div>
 
     <script type="text/javascript">
          
         $("#btn1").ligerButton({
             text: '获取值',
             click: function () {
                 var value = $.ligerui.get("popTxt").getValue();
                 alert(value);
             }
         });
 
 
         $("#popTxt").ligerPopupEdit({
             condition: {
                 prefixID: 'condtion_',
                 fields: [{ name: 'CompanyName', type: 'text', label: '客户' }]
             },
             grid: getGridOptions(true),
             valueField: 'CustomerID',
             textField: 'CustomerID',
             width: 600
         });
 
         function getGridOptions(checkbox) {
             var options = {
                 columns: [
                 { display: '顾客', name: 'CustomerID', align: 'left', width: 100, minWidth: 60 },
                 { display: '公司名', name: 'CompanyName', minWidth: 120, width: 100 },
                 { display: '联系名', name: 'ContactName', minWidth: 140, width: 100 },
                 { display: '电话', name: 'Phone', width: 100 },
                 { display: '城市', name: 'City', width: 100 },
                 { display: '国家', name: 'Country', width: 100 }
                 ], switchPageSizeApplyComboBox: false,
                 data: $.extend({}, CustomersData),
                 pageSize: 10,
                 checkbox: checkbox
             };
             return options;
         }
     </script>
 



