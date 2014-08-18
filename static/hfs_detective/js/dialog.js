/**
 * 弹出框
 *
  */
Dialog = (function() {
    var win = window;

    function Dialog(s) {
        this.init(s);
    }

    Dialog.prototype = {
        constructor: Dialog,

        init: function(s) {
            this.initView(s);  
        },

        initView: function(s) {
            var html = [
                '<div class="dialog" id="dialog">',
                '<div class="dialog-head">',
                '{{ if (it.icon) { }}<a class="close">关闭</a>{{ } }}',
                '</div>',
                '<div class="dialog-content">{{=it.content}}</div>',
                '<div class="dialog-foot"></div>',
                '</div>',
                '<div class="mask" class="mask"></div>'
            ],

            tplFn,

            elem,

            mask,

            done;

            // 按钮事件回调函数
            done = s.done || function() {}; 

            tplFn = doT.template(html.join(''));
            $('body').append(tplFn(s));

            elem = $('#dialog');
            mask = $('#mask');

            // 设置居中样式
            elem.css({
                left: (win.innerWidth - elem.width()) / 2,
                top: (win.innerHeight - elem.height()) / 2
            });

            // 关闭事件 
            $('.close', elem).on('click', function(e) {
                elem.remove();
                mask.remove();  

                done();
            });

            // 点击确定按钮
            $('.button', elem).on('click', function(e) {
                elem.remove();
                mask.remove();     

                done();
            });
        }
    };

    return Dialog;
})();
