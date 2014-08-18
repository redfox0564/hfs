$(function($) {
    $('.play').on('click', 'a.real', function() {
        // 提交歌曲名
        var dialog = new Dialog({
	   bg: '1',
            icon: true,
            content: '<h2 class="submit-answer">真相已被我看透，歌名是：</h2><form name="answer"><div class="music-name"><input type="text" name="answer" id="answer" /></div><div class="buttons submit"><a class="button">提交</a></div>',
            done: function() {
		var ans = window.ans || '三寸天堂',

			value = $('#answer').val();

		dialog.hide();	
		if (value !== ans) {
			var dialog01 = new Dialog({
				bg: '2',
				icon: true,
			content: '<h2 class="wrong-answer">唔...歌名不是这个哦~</h2><div class="send-help">求助一下朋友圈里那些麦霸吧？</div><div class="buttons"><a class="button share">分享到朋友圈</p></div>',
			done: function() {
				dialog01.hide();	
				var div ;

				$('body').append(div = $('<div class="share-guide"><span class="desc"></span></div>'));
					wx_share();
			}
			});	
		} else {
		var dialog2 = new Dialog({
			bg: '1',
			icon: true,
			content: '<div class="victory"><h2><p>回答正确！</p><p>实力侦探就是你！</p></h2><div>向好友炫耀实力，领取海飞丝好礼！</div></div><div class="buttons"><a class="button share">分享到朋友圈</p></div>',
			done: function() {
				var div = $('<div class="share-guide"><span class="desc"></span></div>');
				dialog2.hide();
				wx_share();
				$('body').append(div);
			}
		    });	
		}
            }
        });  
    });  
});

function wx_share(){
	if (typeof WeixinJSBridge !=='undefined'){
		show_share();
	} else {
		document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
			show_share();
		},false);
	}
}

function show_share(){
                WeixinJSBridge.on('menu:share:appmessage', function(argv){
                    shareFriend();
                });
                WeixinJSBridge.on('menu:share:timeline', function(argv){
                    shareTimeline();
                });
}

function shareTimeline() {

                WeixinJSBridge.invoke('shareTimeline', shareData, function(res) {
                    wxcallback&&wxcallback();
                });
            }

            function shareFriend() {
                WeixinJSBridge.invoke('sendAppMessage', shareData, function(res) {
                   wxcallback && wxcallback();
                });
            }
