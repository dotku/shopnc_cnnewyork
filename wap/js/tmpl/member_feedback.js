$(function(){
		var key = getcookie('key');
		if(key==''){
			location.href = 'login.html';
		}
    
    $('#feedbackbtn').click(function(){
        var feedback = $('#feedback').val();
        if (feedback == '') {
            $.sDialog({
                skin:"red",
                content:'请填写反馈内容',
                okBtn:false,
                cancelBtn:false
            });
            return false;
        }
        $.ajax({
            url:ApiUrl+"/index.php?act=member_feedback&op=feedback_add",
            type:"post",
            dataType:"json",
            data:{key:key, feedback:feedback},
            success:function (fData){
                if(checklogin(fData.login)){
                    if(!fData.datas.error){
						 $.sDialog({
							skin:"green",
							content:'提交成功',
							okBtn:false,
							cancelBtn:false
						});
                        setTimeout(function(){
                            window.location.href = WapSiteUrl + '/tmpl/member/member.html';
                        }, 3000);
                    }else{
						 $.sDialog({
							skin:"red",
							content:Data.datas.error,
							okBtn:false,
							cancelBtn:false
						});
                    }
                }
            }
        });
    });
});