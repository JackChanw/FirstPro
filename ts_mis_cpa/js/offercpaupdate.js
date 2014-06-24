var expand = {
    init:function(){
        check.init();
        // 所有input对象
        var inputObj = $('.app').children().find('input[class="need"],select[class="need"]');
		inputObj.blur(function(){
			if($(this).attr('id') != 'active_mode_other' &&  $(this).attr('id') != 'OfferCpaUpdateForm_online_time' &&  $(this).attr('id') != 'OfferCpaUpdateForm_company_name'){
				eval('check.'+$(this).attr('id')+'($(this))');
				}
		});
		$('#OfferCpaUpdateForm_active_mode_4').click(function(){
					$(".mode_other").show();
		})
		for (var i = 1; i < 4; i++){
			$('#OfferCpaUpdateForm_active_mode_'+i).click(function(){
			$(".mode_other").hide();
			$(".mode_other").children('input').attr('value','');
		})
			
		}
		if(info == 1){
			for (var i = 1; i < 7; i++){
			    $("#OfferCpaUpdateForm_system_version_"+i).hide();
			    $("#OfferCpaUpdateForm_system_version_"+i).next('label').hide();
                	}
		}
		$("#OfferCpaUpdateForm_system_version_0").bind("click", function () {
			if(info%2==1){
				for (var i = 1; i < 7; i++){
					$("#OfferCpaUpdateForm_system_version_"+i).show();
					$("#OfferCpaUpdateForm_system_version_"+i).next('label').show();
				}
				info++;
			}else{
				for (var i = 1; i < 7; i++){
					$("#OfferCpaUpdateForm_system_version_"+i).hide();
					$("#OfferCpaUpdateForm_system_version_"+i).attr('checked',false);
					$("#OfferCpaUpdateForm_system_version_"+i).next('label').hide();
				}
				info++;
			}
		});
        // 表单提交时验证
        $('#myform').submit(function(){
            // 遍历数组是否存在false,如果有则提示用户
            for(i in check.status){
                if(check.status[i] == false){
                    inputObj.eq(i).next('em').show();
                    inputObj.eq(i).next('em').css('color','red');
                    return false;
                }
            }
            // 判断权限选择
			/*
            if($('.powergr').val() == null && !confirm('您还没有给该用户分配权限组，是否继续提交？')) {
                return false;
            }
			*/
        });
    }
}

// 表单数据验证
check={
    init:function(){
        // 声明一个数组存储所有的input数据录入状态，默认为false
        this.status = new Array(true,true,true,true);
    },
    // 用户名验证
   OfferCpaUpdateForm_offer_title :function(inpObj){
        var inpValue = inpObj.val();
        var color;
        //var reg = new RegExp("^[a-z0-9]+$","i");
        if(inpValue != ''){
            this.status[0] = true;
            color = '';
			inpObj.next('em').hide();  
			inpObj.next('em').css('color',color);  
        }else{
            this.status[0] = false;
            color = 'red';
			inpObj.next('em').show();  
			inpObj.next('em').css('color',color);  
        }
        //如果填写错误的时候字体显示为红色
    },
   OfferCpaUpdateForm_sale :function(inpObj){
        var inpValue = inpObj.val();
        var color;
        //var reg = new RegExp("^[a-z0-9]+$","i");
        if(inpValue != 0){
            this.status[1] = true;
            color = '';
			inpObj.next('em').hide();  
			inpObj.next('em').css('color',color);  
        }else{
            this.status[1] = false;
            color = 'red';
			inpObj.next('em').show();  
			inpObj.next('em').css('color',color);  
        }
        //如果填写错误的时候字体显示为红色
    },
   OfferCpaUpdateForm_ae :function(inpObj){
        var inpValue = inpObj.val();
        var color;
        //var reg = new RegExp("^[a-z0-9]+$","i");
        if(inpValue != 0){
            this.status[2] = true;
            color = '';
			inpObj.next('em').hide();  
			inpObj.next('em').css('color',color);  
        }else{
            this.status[2] = false;
            color = 'red';
			inpObj.next('em').show();  
			inpObj.next('em').css('color',color);  
        }
        //如果填写错误的时候字体显示为红色
    },
   OfferCpaUpdateForm_app_name:function(inpObj){
        var inpValue = inpObj.val();
        var color;
        //var reg = new RegExp("^[a-z0-9]+$","i");
        if(inpValue.trim() != ''){
            this.status[3] = true;
            color = '';
			inpObj.next('em').hide();  
			inpObj.next('em').css('color',color);  
        }else{
            this.status[3] = false;
            color = 'red';
			inpObj.next('em').show();  
			inpObj.next('em').css('color',color);  
        }
        //如果填写错误的时候字体显示为红色
    },
   OfferCpaUpdateForm_callback_period:function(inpObj){
        var inpValue = inpObj.val();
        var color;
        //var reg = new RegExp("^[a-z0-9]+$","i");
        if(inpValue != 0){
            this.status[4] = true;
            color = '';
			inpObj.next('em').hide();  
			inpObj.next('em').css('color',color);  
        }else{
            this.status[4] = false;
            color = 'red';
			inpObj.next('em').show();  
			inpObj.next('em').css('color',color);  
        }
        //如果填写错误的时候字体显示为红色
    },
   OfferCpaUpdateForm_itunesurl:function(inpObj){
        var inpValue = inpObj.val();
        var color;
        //var reg = new RegExp("^[a-z0-9]+$","i");
        if(inpValue.trim() != ''){
            this.status[5] = true;
            color = '';
			inpObj.next('em').hide();  
			inpObj.next('em').css('color',color);  
        }else{
            this.status[5] = false;
            color = 'red';
			inpObj.next('em').show();  
			inpObj.next('em').css('color',color);  
        }
        //如果填写错误的时候字体显示为红色
    },
   OfferCpaUpdateForm_clk_link:function(inpObj){
        var inpValue = inpObj.val();
        var color;
        //var reg = new RegExp("^[a-z0-9]+$","i");
        if(inpValue.trim() != ''){
            this.status[6] = true;
            color = '';
			inpObj.next('em').hide();  
			inpObj.next('em').css('color',color);  
        }else{
            this.status[6] = false;
            color = 'red';
			inpObj.next('em').show();  
			inpObj.next('em').css('color',color);  
        }
        //如果填写错误的时候字体显示为红色
    },
}
