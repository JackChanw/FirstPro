//提示
function warn(className, msg, statuss){
    var c;
    c = $('.' + className);
    c.css('width', '99%');
    c.css('line-height', '25px');
    c.css('padding-left', '15px');
    c.css('margin', '2px 2px');
    if(statuss){
	c.css('color', '#5F8D00');
	c.css('background', '#E7F9AD');
	c.show().delay(5000).hide(2000);
    }else{
	c.css('color', '#CB3D3D');
	c.css('background', '#FFCFCF');
	c.show();
    }
	
    c.html(msg);
}
page = '';
changes = false;

var CpaInfo = {
init:function(){
	 Ci = this;
	 Ci.noCloseWindow();
//	 Ci.Keyboard();
     },

     //防止关闭浏览器
noCloseWindow:function(){
		  //防止关闭浏览器
		  window.onbeforeunload = function(){     
		      var warning="确认关闭此页面？";         
		      //你的业务操作。。。。        
		      //return warning;
			if(page == "edit"){
			   return Ci.islawful();
			}
			if(changes == true){
			   return warning;
			}
		  },     
		  window.onunload = function(){     
		      var warning="谢谢光临";   
		      //你的业务操作。。。。    
		    //if(changes == true)
			//	alert(warning);     
		  }     
	      },

islawful:function(){
	var itunes = $('.itunes').eq(1).val();
	var appid = $('.appid').eq(1).val();
	var app_name = $('.app_name').eq(1).val();
	if(itunes == ''){
	   return 'itunes不合法';
	}
	if(appid == ''){ return 'appid不合法';}
	if(app_name == ''){return 'app名称不合法';}
},

//获取Cookie
getCookie:function(Name){
	      var search = Name + "=";
	      if(document.cookie.length > 0){
		  offset = document.cookie.indexOf(search) 
		      if(offset != -1){
			  offset += search.length 
			      end = document.cookie.indexOf(";", offset) 
			      if(end == -1) end = document.cookie.length 
				  return unescape(document.cookie.substring(offset, end)) 
		      }
		      else return "" 
	      }
	  },


	  //设置setCookie
setCookie:function (name, value){
	      var argv = setCookie.arguments; 
	      var argc = setCookie.arguments.length; 
	      var expires = (argc > 2) ? argv[2] : null; 
	      if(expires!=null){
		  var LargeExpDate = new Date (); 
		  LargeExpDate.setTime(LargeExpDate.getTime() + (expires*1000*3600*24));         
	      }
	      document.cookie = name + "=" + escape (value)+((expires == null) ? "" : ("; expires=" +LargeExpDate.toGMTString())); 
	  },


	      //获取mac
getMac:function(url, k, MacTypeClass){
	   // Ci.MacTypeClass = document.getElementsByClassName(MacTypeClass);
	   Ci.MacTypeClass = MacTypeClass;
	   var url = '?r='+url;
	   Ci.Cajax({'type':'GET', 'url':url, 'param':k});
       },

addOption:function(){
	      var arr = Ci.Mac.param;
	      var ifa = Ci.Mac.idfa;
	      for(var i in arr){
		  Ci.MacTypeClass[0].add(new Option(i, arr[i] + ','  + ifa));
	      }

	  },

	  //ajax提交
Cajax:function(ajaxP){
	  var type = ajaxP.type || 'GET';
	  var arr = new Array();
	  for(var i in ajaxP.param){
	      arr.push(i+'='+ajaxP.param[i]);
	  }
	  var param = arr.join('&');
	  var xhr = new XMLHttpRequest();
	  if(type=='GET'){
	      var url = param ? ajaxP.url+'&'+param : ajaxP.url; 
	      xhr.open(type, url, true);
	      xhr.send(null);
	  }else{
	      var url = ajaxP.url;
	      var param = ajaxP.param.link;
	      xhr.open(type, url, true);
	      xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	      xhr.send(param);
	  }
	  xhr.onreadystatechange = function(){
	      if(xhr.readyState == 4 && xhr.status == 200){
		  Ci.Mac = eval('('+xhr.responseText+')');
		  eval(Ci.Mac.callback+'()');
		  xhr = null;
	      }
	  }
      },


      //选择mac与idfa
/*changeMachine:function(){
		  machineChange(Ci.Mac.param);
	      },*/
FindDeviceInfo:function(){
    ShowDeviceInfo(Ci.Mac.param);
},

	      //生成appName
createAppName:function(){
		  AppNameCreate(Ci.Mac.param);
	      },


	      //对url参数中的（&,?）进行编码替换
UrlReplaceCode:function(url){
		   var arr = url.match(/[~]/g);

		   if(arr == null){
		       var chr = ['&'];
		       var rep = ['~'];
		       var newArr = [];

		       var len = chr.length;
		       for(var i=0; i<len; i++){
			   var reg =eval('/'+chr[i]+'/g');
			   newArr = url.replace(reg, '~');        
		       }
		       return newArr;

		   }else{
		       return 'ERROR: has special character ~ ';
		   }
	       },

	       //延迟几秒执行
Sleep:function(s){
	  var numberMillis = s * 1000;
	  var now = new Date();
	  var exitTime = now.getTime() + numberMillis;
	  while (true) {
	      now = new Date();
	      if (now.getTime() > exitTime)
		  return;
	  }
      },

      //弹出信息
AlertInfo:function(){
	      var inf = '';
	      var statuses =  Ci.Mac.param;
	      switch(statuses){
		  case 10000: inf = '数据保存成功';break;   
		  case 10001: inf = '不能重复提交';break;   
		  case 10002: inf = '参数不能为空';break;   
		  case 10003: inf = '数据提交失败';break;   
		  case 10004: inf = '数据提交成功';break;   
		  case 10005: inf = '更新数据失败';break;   
		  case 10006: inf = '至少得有一个占位符吧';break;   
		  case 10007: inf = '网络繁忙';break;
	      }
	      if(inf != ''){
			  if(inf == 10000 || inf == 10004){
				warn('warn', inf, true);
			  }else{
				warn('warn', inf, false);
			  }
				if(statuses == 10004){
					document.location.reload();//当前页面  
				}
	      }
	      return false;
	  },


//一键占位符
Keyboard:function(kobj){
     var key = function(evt){
      evt = window.event || evt;
	// if(evt.altKey && evt.ctrlKey){
	 if(evt.altKey){
	     switch(evt.keyCode){
		 case 48: var val = '<IDFA_LOWER>';break;
		 case 49: var val = '<DMAC_UPPER>';break;
		 case 50: var val = '<IDFA>';break;
		 case 51: var val = '<OPEN_UDID_LOWER>';break;
		 case 52: var val = '<MD5_MAC>';break;
		 case 53: var val = '<DMAC_PURE_NUM>';break;
		 case 54: var val = '<DMAC_PURE_NUM_LOWER>';break;
		 case 55: var val = '<DMAC_LOWER>';break;
		 case 56: var val = '<NOCOLONIDFA>';break;
		 case 57: var val = '<NOCOLONIDFA_LOWER>';break;
		 case 77: var val = '<MAC_OR_IDFA>';break;
		 case 83: var val = '<_SIGN>';break;
		 case 84: var val = '<TIMESTAMP>';break;
		 case 189: var val = '<OPEN_UDID>';break;
	     }
	     if(val != undefined)
		Ci.ReplaceKey(val, kobj);
	 }
    }
    window.document.onkeydown=key//当有键按下时执行函数
},

ReplaceKey:function(param, obj){
    var obj = obj.get(0);
    var initlen = obj.value.length;
    var selectText = window.getSelection();
    var mouseCoord = Ci.getPositionForInput(obj);
    obj.value = obj.value.replace(selectText, '');
    obj.value = obj.value.substr(0, mouseCoord) + param + obj.value.substr(mouseCoord);
    var position = mouseCoord + param.length;
    Ci.setCursorPosition(obj, position); 
},

//获取光标位置
//param ctrl dom对象
getPositionForInput:function(ctrl){ 
    var CaretPos = 0; 
    if (document.selection) { // IE Support 
	ctrl.focus(); 
	var Sel = document.selection.createRange(); 
	Sel.moveStart('character', -ctrl.value.length); 
	CaretPos = Sel.text.length; 
    }else if(ctrl.selectionStart || ctrl.selectionStart == '0'){// Firefox support 
	CaretPos = ctrl.selectionStart; 
    } 
    return (CaretPos); 
}, 

//设置光标位置函数 
setCursorPosition:function(ctrl, pos){ 
    if(ctrl.setSelectionRange){ 
	ctrl.focus(); 
	ctrl.setSelectionRange(pos,pos); 
    } 
    else if (ctrl.createTextRange) { 
	var range = ctrl.createTextRange(); 
	range.collapse(true); 
	range.moveEnd('character', pos); 
	range.moveStart('character', pos); 
	range.select(); 
    } 
},

//返回查询的回调结果
FindCallBack:function(){
	searchResult(Ci.Mac.param);
},

}

function in_array(stringToSearch, arrayToSearch) {
    var len = arrayToSearch.length; 
    for (s = 0; s < len; s++) {
	thisEntry = arrayToSearch[s].toString();
	if (thisEntry == stringToSearch) {
	    return true;
	}
    }
    return false;
}



