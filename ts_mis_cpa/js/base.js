/* 可扩展的方法有
 * clickActFunc  可以添加扩展方法：base.expand.clickActFunc()，给方法传入当前点击的对象，方法必须返回一个布尔值来决定是否继续执行
 * 
        if(typeof baseObj.extend.clickActFunc !='undefined' && baseObj.extend.clickActFunc instanceof Function) {
            return baseObj.extend.clickActFunc($(this));
        }
 */
var basejs = {
    init:function(expand) {
        cybase = this;
        cybase.extend = expand || new Object;  // 如果没有定义扩展方法体，则生成默认对象
	cybase.extend.init && cybase.extend.init();  // 如果有定义默认初始化方法则调用
        cybase.warn();
    },
    // 提示框控制
    warn:function() {
        if($('#operateWarn').hasClass('success')) {
            setTimeout(function(){$('#operateWarn').animate({
                opacity:0,
                width:0,
                height:0,
                marginTop:0,
                fontSize:10
            }, 2000)}, 5000);
        }
    }

}

$(document).ready(function(){
    expand = expand || new Object();
    basejs.init(expand);
    /**
     *  监听所有的动作按钮
     *  所有属性中含有 action=true 的标签都会通过该方法验证，
     *  如果标签中含有 actType 属性时，会使用该属性做不同的处理，该属性类型可以根据需要自定义添加
     *  如果标签中含有 actFunc 属性时，会将该属性值作为方法调用，该方法可以return一个布尔值来决定是否继续执行脚本
     *
     *  可以添加扩展方法：base.extend.clickActFunc($(this))，给方法传入当前点击的对象，方法必须返回一个布尔值来决定是否继续执行
     *  扩展方法优先于基础验证动作类
     */
    $('[action=true]').click(function(){
        var status = undefined;
        // 是否有扩展验证方法
        if(basejs.extend.clickActFunc){
            var s = basejs.extend.clickActFunc($(this));
            if(s == false)
                return false;
            else if(s == true)
                status = true;
        }
	if(status == undefined) {
            switch($(this).attr('actType')) {
                // 删除动作
                case 'del':
                    if(!confirm('您确定删除该条数据么？'))
                        return false;   
                    else
                        status = true;
                    break;
            }
        }
        // 如果存在需要调用的方法则执行回调
        if($(this).attr('actFunc')){
            return eval($(this).attr('actFunc')+'()');
        }else{
            return status == undefined ? false : status;
        }
    });

/*
	//input框全选和反选
	$('#main').find('.con_list').find('input[type=checkbox]').eq(0).click(function(){
		if($(this).attr('checked')){
			$('#main').find('.con_list').find('input[type=checkbox]').attr('checked',true);
		}else{
			$('#main').find('.con_list').find('input[type=checkbox]').attr('checked',false);
		}
	});
	//span调用全选和反选
	$('#checkAll').click(function(){
		if($('#main').find('.con_list').find('input[type=checkbox]').eq(0).attr('checked')){
			$('#main').find('.con_list').find('input[type=checkbox]').attr('checked',false);
		}else{
			$('#main').find('.con_list').find('input[type=checkbox]').attr('checked',true);
		}
	});
	//获取所有选中项目的VALUE值
	function getValue(){
		var value = new Array();
		$('#main').find('.con_list').find('input[type=checkbox][checked][value!=""][value!=on]').each(function(i){
			value[i] = $(this).val();
		});
		return value.join('-');
	}
	//批量删除
	$('#delItem').click(function(){
		if(window.confirm('您是否确定删除所选的数据？')){
			window.location = url + '/'.$(this).attr('rel').'/id/' + getValue();
		}
	});
	//单项删除确认
	$('#main').find('.con_list').find('li[class=list]').find('a').click(function(){
		if($(this).attr('href') == 'javascript:void(0)'){
			if(window.confirm('您确定执行该操作？')){
				window.location = url + '/'.$(this).attr('rel').'/id/' + $(this).parents('li').find('input[type=checkbox]').val();
			}
		}	
	});
	

	//搜索
	$('#search').click(function(){
		if($('#keyword').val() == ''){
			return false;
		}
		window.location = url + '/search/k/' + encodeURI($('#keyword').val());	
	});
	//跳转到添加职位页面
	$('#addpos').click(function(){
		window.location = url + '/addpos';	
	})
*/
});
