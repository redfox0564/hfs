;(function($) {
    $(document).on('click', 'a.real', function() {
        // 提交歌曲名
        new Dialog({
            icon: true,
            content: '<h2 class="submit-answer">真相已被我看透，歌名是：</h2><form name="answer"><div class="music-name"><input type="text" name="answer" id="answer" /></div><div class="buttons submit"><a class="button">提交</a></div>',
            done: function() {
                alert('答案填写正确');
            }
        });  
    });  
})(Zepto)
