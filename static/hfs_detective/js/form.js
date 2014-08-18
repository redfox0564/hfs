$(function($) {
	var form = document.reg,

		nick = form.nick,

		mobile = form.mobile;

	$('.submit').on('click', function() {
		if (nick.value == '') {
			$(nick.parentNode).addClass('warning');
			$('.msg').html('请填写微信昵称！');
		} else {
			$(nick.parentNode).removeClass('warning');

			if (mobile.value === '') {
				$(mobile.parentNode).addClass('warning');
				$('.msg').html('请填写手机号码！');
			} else {
				$(mobile.parentNode).removeClass('warning');
				$('.msg').html('');
				
				$.ajax({
					url: '/hfs_detective/index.php?r=home/updateWinner', 
					type: 'POST',
					data: {
					name: nick.value,
					phone: mobile.value
					},
					success: function(data) {
					new Dialog({
					bg: '1',
					icon: false,
					content: '<h2 class="submit-succ">提交成功，感谢参与！</h2><div class="buttons back-index"><a class="button">返回活动首页</a></div>',
					done: function() {
						// TODO
						location.href = '/hfs_detective/index.php?r=home/wapIndex&source=local';
					}
				    });		
					}
				});
			}
		}
		
		
	});  
});
