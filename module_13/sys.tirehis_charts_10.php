<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>轮胎历史曲线</title>
<link href="../lib/ligerUI/skins/Aqua/css/ligerui-all.css" rel="stylesheet" type="text/css" />
<!--<link href="../lib/ligerUI/skins/ext/css/ligerui-fix.css" rel="stylesheet" type="text/css" />-->
<link href="../css/inputcharts.css" rel="stylesheet" />
<script src="../lib/jquery/jquery-1.9.0.min.js" type="text/javascript"></script> 
<script src="../lib/json2.js" type="text/javascript"></script>
<script src="../lib/ligerUI/js/core/base.js" type="text/javascript"></script>   
<script src="../lib/ligerUI/js/core/inject.js" type="text/javascript"></script>   
<script src="../lib/ligerUI/js/ligerui.all.js" type="text/javascript"></script>        
<script src="../lib/ligerUI/js/plugins/ligerGrid.js" type="text/javascript"></script> 
<script src="../lib/ligerUI/js/plugins/ligerLayout.js" type="text/javascript"> </script> 
<script src="../lib/ligerUI/js/plugins/ligerDateEditor.js" type="text/javascript"></script>
<script src="../lib/ligerUI/js/plugins/ligerPopupEdit.js" type="text/javascript"></script>
<script src="../lib/ligerUI/js/plugins/ligerComboBox.js" type="text/javascript"></script>
<script src="../lib/ligerUI/js/plugins/ligerCombobox_ex.js" type="text/javascript"></script>

<script src="../lib/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../lib/jquery-validation/jquery.metadata.js" type="text/javascript"></script>
<script src="../lib/jquery-validation/messages_cn.js" type="text/javascript"></script>
	
<script src="../js/XHD.js" type="text/javascript"> </script>
<script src="../lib/jquery.form.js" type="text/javascript"> </script>


<script src="../js/echarts/echarts.min.js"></script>
  
</head>

 <script type="text/javascript">
 
	/*require.config({
        paths: {
            echarts: '../js'
        }
    });*/
	var manager;
	var menu;
	var com_type;
	var com_place;
	var tirecount=6;
	var lastType=0;
	var com_plate;
	
	var optionarr =[{
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[				
						
					]
					
				}
		},
		{
            name:'压力值1',
            type:'line',            
			itemStyle:{normal:{color:'#0066CC'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限1',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#fff000'}},
					data:[						
					]
					
				}
		}
		]     
	},{
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[				
						
					]
					
				}
		},
		{
            name:'压力值1',
            type:'line',            
			itemStyle:{normal:{color:'#0066CC'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限1',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#fff000'}},
					data:[						
					]
					
				}
		}
		]     
	},{
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[				
						
					]
					
				}
		},
		{
            name:'压力值1',
            type:'line',            
			itemStyle:{normal:{color:'#0066CC'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限1',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#fff000'}},
					data:[						
					]
					
				}
		}
		]     
	},{
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[				
						
					]
					
				}
		},
		{
            name:'压力值1',
            type:'line',            
			itemStyle:{normal:{color:'#0066CC'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限1',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#fff000'}},
					data:[						
					]
					
				}
		}
		]     
	},{
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[				
						
					]
					
				}
		},
		{
            name:'压力值1',
            type:'line',            
			itemStyle:{normal:{color:'#0066CC'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限1',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#fff000'}},
					data:[						
					]
					
				}
		}
		]     
	},{
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[				
						
					]
					
				}
		},
		{
            name:'压力值1',
            type:'line',            
			itemStyle:{normal:{color:'#0066CC'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限1',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#fff000'}},
					data:[						
					]
					
				}
		}
		]     
	},{
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[				
						
					]
					
				}
		},
		{
            name:'压力值1',
            type:'line',            
			itemStyle:{normal:{color:'#0066CC'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限1',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#fff000'}},
					data:[						
					]
					
				}
		}
		]     
	},{
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[				
						
					]
					
				}
		},
		{
            name:'压力值1',
            type:'line',            
			itemStyle:{normal:{color:'#0066CC'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限1',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#fff000'}},
					data:[						
					]
					
				}
		}
		]     
	},{
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[				
						
					]
					
				}
		},
		{
            name:'压力值1',
            type:'line',            
			itemStyle:{normal:{color:'#0066CC'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限1',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#fff000'}},
					data:[						
					]
					
				}
		}
		]     
	},{
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[				
						
					]
					
				}
		},
		{
            name:'压力值1',
            type:'line',            
			itemStyle:{normal:{color:'#0066CC'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限1',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#fff000'}},
					data:[						
					]
					
				}
		}
		]     
	},{
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[				
						
					]
					
				}
		},
		{
            name:'压力值1',
            type:'line',            
			itemStyle:{normal:{color:'#0066CC'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限1',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#fff000'}},
					data:[						
					]
					
				}
		}
		]     
	},{
    title : {
        text: '',
		  x:'center'
    },
    tooltip : {
        trigger: 'axis'
    },    
    toolbox: {
        show : true,
        feature : {
            //mark : {show: true},
            dataView : {show: true, readOnly: true},
            //magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
			data:[]
            
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
            }
        }
    ],
    series : [
        {
            name:'压力值',
            type:'line',            
			itemStyle:{normal:{color:'#3D7878'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[				
						
					]
					
				}
		},
		{
            name:'压力值1',
            type:'line',            
			itemStyle:{normal:{color:'#0066CC'}},
			data:[],
            markLine : {
					itemStyle:{normal:{color:'#ff0000'}},
					data:[
						/*[{name:'压力阀值小',value:10, xAxis: -1, yAxis:10},{xAxis:"2015-01-02",yAxis:10}]*/
						
					]
					
				}
					
		},
		{
            name:'上限1',
            type:'line',		
			data:[],
			markLine : {
					itemStyle:{normal:{color:'#fff000'}},
					data:[						
					]
					
				}
		}
		]     
	}];
	

	var ootype=[0,0,0,0,0,0,0,0,0,0,0,0];
	
	function LoadCharts(oc,type,place,index,ec,isn){
		//if(option)
		var option=optionarr[place];
		if(isn==0 || ootype[place]!=type){
			option.xAxis[0].data=[];
			option.series[0].data=[];
			option.series[1].data=[];
			option.series[2].data=[];
			option.series[3].data=[];
			
			option.series[0].name="";
			option.series[1].name="";
			option.series[2].name="";
			option.series[3].name="";
			
			
			
		}
		if(ootype[place]!=type){
			isn=0;
		}
		ootype[place]=type;
		if(type==0){
			//option.title.text=place+"号位压力曲线";
			option.title.text=gettirename(place)+"-压力曲线";
			plate=com_plate.getText();
			if(isn==0){
				option.series[0].name=plate+" 压力值";
				option.series[1].name=plate+" 上限";
				
				
				
				
			}else{
				option.series[2].name=plate+" 压力值";	
				option.series[3].name=plate+" 上限";	
			}
		}else{
			//option.title.text=place+"号位温度曲线";
			option.title.text=gettirename(place)+"-湿度曲线";
			plate=com_plate.getText();
			if(isn==0){
				option.series[0].name=plate+" 温度值";
				option.series[1].name=plate+" 上限";
			}else{
				option.series[2].name=plate+" 温度值";
				option.series[3].name=plate+" 上限";
			}
		}		
		if(isn==0){
			option.xAxis[0].data=oc.xdata;   //5月6号
			option.series[0].data=oc.ydata;
			//option.xAxis[0].data.unshift(-1);
			option.series[1].data.push(oc.max);
		}else{
			option.series[2].data=oc.ydata;
			//option.xAxis[0].data.unshift(-1);
			option.series[3].data.push(oc.max);
		}
		if(type==0){
			//给出压力区间
			
			if(isn==0){
				var xm=oc.xdata[oc.xdata.length-1];	
				var xb=oc.xdata[0];	
				option.series[0].markLine.data.push([{name:'压力下限',value:oc.min, xAxis: xb, yAxis:oc.min},{xAxis:xm,yAxis:oc.min}]);
				option.series[0].markLine.data.push([{name:'压力上限',value:oc.max, xAxis: xb, yAxis:oc.max},{xAxis:xm,yAxis:oc.max}]);
			}else{
				var xm=option.xAxis[0].data[option.xAxis[0].data.length-1];
				var xb=option.xAxis[0].data[0];
				option.series[2].markLine.data.push([{name:'压力下限',value:oc.min, xAxis: xb, yAxis:oc.min},{xAxis:xm,yAxis:oc.min}]);
				option.series[2].markLine.data.push([{name:'压力上限',value:oc.max, xAxis: xb, yAxis:oc.max},{xAxis:xm,yAxis:oc.max}]);
			}
			
		
		
		}else
		{
			var xm=oc.xdata[oc.xdata.length-1];			
			var xb=oc.xdata[0];
			if(isn==0){
				option.series[0].markLine.data.push([{name:'温度上限',value:oc.max, xAxis: xb, yAxis:oc.max},{xAxis:xm,yAxis:oc.max}]);
			}else{
				option.series[2].markLine.data.push([{name:'温度上限',value:oc.max, xAxis: xb, yAxis:oc.max},{xAxis:xm,yAxis:oc.max}]);
			}
		}
		
		/*for(var i=0;i<oc.ydata.length;i++){
			option.series.push({name:oc.ydata[i].name,
								type:'bar',
								stack:'品牌',
								data:oc.ydata[i].data});
		
		}
	*/
	
		    var chartid="chart"+index;
			$("#chart"+index).css("display","inline");
            var myChart = ec.init(document.getElementById(chartid));
			myChart.setOption(option);
			
		/*require(
			[
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line',
            'echarts/chart/map'
			],
        function (ec) {
            //--- 折柱 ---
			//alert("bbbb");
			//alert(index);
			var chartid="chart"+index;
			$("#chart"+index).css("display","inline");
            var myChart = ec.init(document.getElementById(chartid));
			myChart.setOption(option);
		
			
		}
	
		);*/
	}
	
	 function trim(str){ //删除左右两端的空格
　　     return str.replace(/(^\s*)|(\s*$)/g, "");
　　 }
　　 function ltrim(str){ //删除左边的空格
　　     return str.replace(/(^\s*)/g,"");
　　 }
　　 function rtrim(str){ //删除右边的空格
　　     return str.replace(/(\s*$)/g,"");
　　 }

 		      //工具条事件
		function itemclick(item) {
			switch (item.id) {
				case "searchbtn":
					serchpanel();
                  break;
 
          }
      }
	  function f_reload() {
            //var manager = $("#maingrid4").ligerGetGridManager();
            //manager.loadData(true);
        };
		
		function doclear() {
            $("input:hidden", "#serchform").val("");
            $("input:text", "#serchform").val("");
            $(".l-selected").removeClass("l-selected");
        }
		function Search(surl,type,place,index,isn){
				//
				
			/*require(
			[
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line',
            'echarts/chart/map'
			],
			function (ec) {*/
				//--- 折柱 ---
				//alert("bbbb");
				//alert(index);
				//var chartid="chart"+index;
				//$("#chart"+index).css("display","inline");
				//var myChart = ec.init(document.getElementById(chartid));
				//myChart.setOption(option);
		
			
			
				var ec=echarts;
				
				$.ajax({                             
				url:surl,
				type: "POST",
				async:false,
				success:function (result) {					
					var obj = eval("("+result+")");
					if(obj.status!="OK"){
						//top.$.ligerDialog.error(obj.ERROR);						
						return;
					}					
					LoadCharts(obj,type,place,index,ec,isn);
					
				},
				error:function(){
					//alert("获取列表失败");
					//top.$.ligerDialog.error("获取数据失败");
				}
			});
			//});
				
		}		
		
		function clearallcharts()
		{
			//
			for(var i=1;i<=20;i++){
				$("#chart"+i).css("height","300px");
				$("#chart"+i).css("width","475px");
				
				$("#chart"+i).css("display","none");
			}
		}
		
		function doserch1() {
			
			if (! $(serchform).valid()){
				return;
			}	
			
            var sendtxt = "&rnd=" + Math.random();
            var serchtxt = $("#serchform :input").fieldSerialize()+sendtxt;
			var surl="../ajaction/v1/?menuid=131610&cmdx=qry&"+serchtxt;
			//测试用
			//surl="../test_ltyl.php?t=1";
			
			
			var type=com_type.getValue();
			var svalue=com_place.getValue().toString();
			//surl=surl+"&type=0";
			var targetdata = svalue.split(";");
			clearallcharts();
			if(targetdata.length>=1 && targetdata[0]==0){
				//选中了所有
				//alert("获取所有,轮胎数");
				//alert(tirecount);
				var ji=0;
				for(var i=1;i<=tirecount;i++){
					//加载轮胎数据
					ji++;
					Search(surl+"&place_no_v="+i,type,i,ji,1);
					//Search(surl,function(data){CallBack(data,0,(i),(ji));});
					
				}
			}else{
				//
				//alert("获取部分");
				var targetdata = svalue.split(";");
				var ji=0;
				for (var i = 0; i < targetdata.length; i++) {
					//这里加载对应轮胎数据
					
					ji++;
					Search(surl+"&place_no_v="+targetdata[i],type,targetdata[i],ji,1);
					//Search(surl+"&index="+ji+"&place="+targetdata[i]);
				}
			}			
        }
		
		function doserch() {
			
			if (! $(serchform).valid()){
				return;
			}			
            var sendtxt = "&rnd=" + Math.random();
            var serchtxt = $("#serchform :input").fieldSerialize()+sendtxt;
			var surl="../ajaction/v1/?menuid=131610&cmdx=qry&"+serchtxt;
			//测试用
			//surl="../test_ltyl.php?t=1";
			
			
			var type=com_type.getValue();
			var svalue=com_place.getValue().toString();
			//surl=surl+"&type=0";
			var targetdata = svalue.split(";");
			clearallcharts();
			if(targetdata.length>=1 && targetdata[0]==0){
				//选中了所有
				//alert("获取所有,轮胎数");
				//alert(tirecount);
				var ji=0;
				for(var i=1;i<=tirecount;i++){
					//加载轮胎数据
					ji++;
					Search(surl+"&place_no_v="+i,type,i,ji,0);
					//Search(surl,function(data){CallBack(data,0,(i),(ji));});
					
				}
			}else{
				//
				//alert("获取部分");
				var targetdata = svalue.split(";");
				var ji=0;
				for (var i = 0; i < targetdata.length; i++) {
					//这里加载对应轮胎数据
					//targetdata[i]
					ji++;
					Search(surl+"&place_no_v="+targetdata[i],type,targetdata[i],ji,0);
					//Search(surl+"&index="+ji+"&place="+targetdata[i]);
				}
			}
			/*$.ajax({                             
				url:surl,
				type: "POST",				
				success:function (result) {					
					var obj = eval("("+result+")");
					if(obj.status!="OK"){
						top.$.ligerDialog.error(obj.reason);						
						return;
					}
					
					LoadCharts(obj);
					
				},
				error:function(){
					//alert("获取列表失败");
					top.$.ligerDialog.error("获取数据失败");
				}
			});*/
			
			//Search('../ajaction/v1/?menuid=131510&cmd=qry&'+serchtxt);
			//manager.set({url:'../ajaction/v1/?menuid=131510&cmd=qry&'+serchtxt});
			//131110
			//manager.loadData(true);
        }
		
        $(function () {
				
				  
                //$("#grid").height(document.documentElement.clientHeight - $(".toolbar").height());
				$.metadata.setType("attr", "validate");
				XHD.validate($(serchform));
				$('serchform').ligerForm();
				//toolbar();
				//
				serchpanel();
				clearallcharts();
				var oc={"xdata":["2015-01-01","2015-01-02"],"ydata":[30.1,40.5],"max":50,"min":10}; 
				//LoadCharts(oc,0,1);
				//LoadCharts(null);
				
        });		
		function getGridOptions(checkbox) {
             var options = {
                 columns: [
                 { display: '车牌号码', name: 'plate_no', align: 'left', width: 350, minWidth: 60 },
                 { display: '车载编码', name: 'v_term_no', minWidth: 350, width: 100 },								 
                 ], switchPageSizeApplyComboBox: false,
                 /*data: $.extend({}, CustomersData),*/
				 url:'../ajaction/v1/?menuid=121010&cmd=qry&t=1',
                 pageSize: 10,
				 dataAction:'server',
				 allowUnSelectRow:true
				
             };
             return options;
         }

		
		//表单搜索
		 function initSerchForm() {
            //$('#title').ligerComboBox({ width: 97, emptyText: '（空）'});         
 			 $("#begin_date").ligerDateEditor({ showTime: false, labelWidth: 100, labelAlign: 'left' });
			$("#end_date").ligerDateEditor({ showTime: false, labelWidth: 100, labelAlign: 'left' });
			com_place=$("#place_no").ligerComboBox({
						width:196,
						//checkbox:true,
						valueField:'id',
						textField:'name',
						/*data:obj,
						url: "../ajaction/sysaction/get_all_roles.php?rnd=" + Math.random(),*/
						isMultiSelect: true ,
						isShowCheckBox:true						
			
			});
			com_type=$("#charts_no").ligerComboBox({
						width:196,
						//checkbox:true,
						valueField:'id',
						textField:'name',
						data:[{'id':0,'name':'压力'},
							{'id':1,'name':'温度'}],
						/*data:obj,
						url: "../ajaction/sysaction/get_all_roles.php?rnd=" + Math.random(),*/
						isMultiSelect: false ,
						isShowCheckBox:false						
			
			});
			
			 com_plate=$("#plate_no").ligerPopupEdit({
             condition: {
                 prefixID:'plate_no',
                 fields: [{name:'plate_no',type:'text',label:'车牌号'}],
				 
             },
             grid: getGridOptions(true),
				valueField: 'bus_id',
				textField: 'plate_no',
				width: 100,
				searchClick:function(obj){
					/*
						obj 
						grid: grid,
                        rules: rules   {"op":"like","field":"plate_no","value":"苏1","type":"text"}
					*/
					var s="";
					for(var i=0;i<obj.rules.length;i++){
						s=s+obj.rules[i].field+"="+encodeURI(obj.rules[i].value);
					}
					if(s!="") s="&"+s;
					$('.pcontrol input', obj.grid.toolbar).val(1);
					obj.grid.changePage('input');
					obj.grid.set({url:'../ajaction/v1/?menuid=121010&cmd=qry&t=1'+s});
					obj.grid.loadData(true);
					
				},
				dlgWidth:800,
				dlgHeight:300,
				onSelect:function(x){
					//按了选择按钮
					/*
					value: value.join(p.split),
                text: text.join(p.split),
                data: data,
					*/
					
					if(x.data.length==1){
						//alert(x.data.length);
						//alert(x.data[0].wheel_count);  //选择了这个ID ,这个车子轮数
						var data=[{'id':0,'name':'所有'}];
						for(var i=1;i<=x.data[0].wheel_count;i++){
							data.push({'id':i,'name':gettirename(i)});
						}
						tirecount=x.data[0].wheel_count;
						com_place.setData(data);
						com_place.setMultiSelect(0,0);  //默认选中0
					}
				}
			});
		
		}
		
		
		
		
		function serchpanel() {
            initSerchForm();
            if ($(".az").css("display") == "none") {
                $("#grid").css("margin-top", $(".az").height() + "px");
                //$("#maingrid4").ligerGetGridManager().onResize();
                //$("#maingrid5").ligerGetGridManager().onResize();
				$(".az").css("display","inline");
				$(".az").css("position","absolute");
				$(".az").css("left","5px");
				$(".az").css("top","0px");
				
				//alert("1");
            } else {
                $("#grid").css("margin-top", "0px");
				$(".az").css("display","none");
				
                //$("#maingrid4").ligerGetGridManager().onResize();
                //$("#maingrid5").ligerGetGridManager().onResize();
				//alert("2");
            }
            //$("#company").focus();
        }		
		//serchpanel();
    </script>
<style>
#shezhi input{
	border: 1px solid #1c66dc;
			height: 25px;
			line-height: 2px;
			width: 100px;
			background-color: white;
			border-radius: 20px;
			vertical-align: middle;
			color: #1c66dc;
}
#shezhi input:active,#shezhi input:hover{
	background-color:#1c66dc;
	color:#ffffff;
}


</style>

<body style="margin-top:0px">
 <div id="message" style="width:800px"></div>
<div class="l-loading" style="display:none" id="pageloading"></div> 
  <form id="form1" onsubmit=" return false ">
    <div id="toolbar" ></div>	
	<div id="grid" style="align:center">
		<div id="main" style="margin:0px;width:960px">
			<div id="chart1" style="width:450px;height:300px;float:left;display:inline"></div>
			<div id="chart2" style="width:450px;height:300px;float:left;display:inline"></div>
			<div id="chart3" style="width:450px;height:300px;float:left;"></div>
			<div id="chart4" style="width:450px;height:300px;float:left;"></div>
			<div id="chart5" style="width:450px;height:300px;float:left;"></div>
			<div id="chart6" style="width:450px;height:300px;float:left;"></div>
			<div id="chart7" style="width:450px;height:300px;float:left;"></div>
			<div id="chart8" style="width:450px;height:300px;float:left;"></div>
			<div id="chart9" style="width:450px;height:400px;float:left;"></div>
			<div id="chart10" style="width:450px;height:400px;float:left;"></div>
			<div id="chart11" style="width:450px;height:400px;float:left;"></div>
			<div id="chart12" style="width:450px;height:400px;float:left;"></div>
			<div id="chart13" style="width:450px;height:400px;float:left;"></div>
			<div id="chart14" style="width:450px;height:400px;float:left;"></div>
			<div id="chart15" style="width:450px;height:400px;float:left;"></div>
			<div id="chart16" style="width:450px;height:400px;float:left;"></div>
			<div id="chart17" style="width:450px;height:400px;float:left;"></div>
			<div id="chart18" style="width:450px;height:400px;float:left;"></div>
			<div id="chart19" style="width:450px;height:400px;float:left;"></div>
			<div id="chart20" style="width:450px;height:400px;float:left;"></div>
		</div>
		<!--<div id="toolbar1"></div>-->		
	</div>
  </form>
  <div class="az" style="display:none;">
        <form id='serchform'>
            <table style='width: 960px' class="bodytable1">
                <tr>
                    <td>
                        <div style='float: left; text-align: left; width: 60px;'>起始日期：</div>
					</td>
					<td>
						<div style='float: left;'>
						<input type='text' id='begin_date' name='begin_date'  ligerui='{width:120}' validate="{required:true}" />
						</div>
                    </td>
					<td>
                        <div style='float: left; text-align: left; width: 60px;'>终止日期：</div>
					</td>
					<td>
						<div style='float: left;'>
						<input type='text' id='end_date' name='end_date'  ligerui='{width:120}' validate="{required:true}" />
						</div>
                    </td>
					<td>
                        <div style='float: left; text-align: left; width: 60px;'>车辆号码：</div>
					</td>
					<td>
						<div style='float: left;'>
						<!--<input type='text' id='plate_no' name='plate_no'  ligerui='{width:120}' />-->
						<input id="plate_no"  name='plate_no' type="text" readonly="" style="width: 120px;" validate="{required:true}"  />
						</div>
                    </td>
					<td>
                        <div style='float: left; text-align: left; width: 60px;'>轮胎号位：</div>
					</td>
					<td>					
						<input type='text' id='place_no' name='place_no'  ligerui='{width:120}' style="display:none" validate="{required:true}" />						
                    </td>
					<td>
                        <div style='float: left; text-align: left; width: 60px;'>曲线参数：</div>
					</td>
					<td>					
						<input type='text' id='charts_no' name='charts_no'  ligerui='{width:120}' style="display:none" validate="{required:true}" />						
                    </td>
                </tr>
				<tr style='height:50px;'>
				<td colspan="10" style='align:center'>
				 <div id="shezhi" style='float: left; text-align: center; width: 100%;'>
                        <input  id='Button2' type='button' value='重置' style='height: 24px; width: 80px;'
                            onclick=" doclear() " />						
                        <input  id='Button1' type='button' value='搜索' style='height: 24px; width: 80px;' onclick=" doserch() " />
						<input  id='Button2' type='button' value='比对' style='height: 24px; width: 80px;' onclick=" doserch1() " />
						
				</div>
				</td>
				
				</tr>
            </table>
        </form>
    </div>
</body>
</html>
