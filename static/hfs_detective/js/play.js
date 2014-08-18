/**
 * 播放页JS
 * 作者 蜗眼 <iceet@uoeye.com>
 */

(function($){
    /*
     * 云图片地址
     */
    var CLOUD_IMAGE_SRC ='./img/play-cloud.png';

    /*
     * 简单 MP3播放控件
     * play的时候就重头开始播放，不做播放进度的缓冲
     */
    function MP3Player(src){
        this.init(src);
    }
    MP3Player.prototype ={
        init: function(src){
            this.audio = new Audio;

            //标记是否播放
            this.playing = false;
            this.audio.src = src;
        },
        //播放以及重新赋值
        play: function( src){
            //重新赋值MP3路径,但是不自动播放
            if ( src ){
                this.playing && this.audio.pause();//暂停

                return this.audio.src = src;
            }

            //重头播放,在MP3没有下载完全的时候，该属性不存在
            if ( this.audio.currentTime ) {
                this.audio.currentTime = 0
            }

            this.playing = true;
            this.audio.play();
        },
        //停止播放
        stop: function(){
            this.playing = false;
            this.audio.pause()
        },
        //切换播放状态
        toggle: function(callback){

            var action = this.playing
                ? 'stop' : 'play';

            this[action]();

            callback && callback(action);
        }
    };


    /**
     * 呱呱卡
     */

    function Scratchcard(canvas,callback){
        this.init(canvas,callback);
    }

    Scratchcard.prototype = {
        init: function(canvas,callback){
            var self = this;

            self.canvas = canvas;
            self.offset = $(canvas).offset();
            self.ctx = canvas.getContext('2d');
            self.callback = callback;

            self.reset();

            // 在已有内容和新图形不重叠的地方，已有内容保留，所有其他内容成为透明。
            self.ctx.fillStyle = 'transparent';
            self.ctx.globalCompositeOperation = 'destination-out';

            self.bind();
        },
        bind: function(){

            var self = this,
                canvas = self.canvas;

            //简单处理事件，，并且全部一次性绑定
            canvas.addEventListener('touchstart', $.proxy(self.down,self));
            canvas.addEventListener('touchend', $.proxy(self.up,self));
            canvas.addEventListener('touchmove', $.proxy(self.move,self));
        },
        getXY: function(e){

            if (e.changedTouches){
                // 取得涉及当前事件中众多手指中的最后一个。
                e = e.changedTouches[e.changedTouches.length - 1];
            }

            return {
                x: (e.clientX + document.body.scrollLeft || e.pageX) - this.offset.left,
                y: (e.clientY + document.body.scrollTop || e.pageY) - this.offset.top
            }
        },
        down: function(e){
            var self = this,
                evt  = self.getXY(e);

            e.preventDefault();

            self.touchstart = true;
            self.ox = evt.x;
            self.oy = evt.y;
        },
        move: function(e){

            var self = this,
                ctx = self.ctx,
                evt = self.getXY(e);

            if ( this.touchstart ){

                e.preventDefault();

                ctx.beginPath();
                ctx.moveTo(self.ox,self.oy);
                ctx.lineWidth = 20;
                ctx.lineCap = "round";
                ctx.lineTo(self.ox = evt.x,self.oy = evt.y);
                ctx.stroke();
            }
            return false;
        },
        up: function(){

            var self = this,
                data ,total =0;

            if ( self.touchstart ) {

                self.touchstart = false;

                if ( self.redata ){

                    data = self.ctx.getImageData(self.redata.left,self.redata.top
                        ,self.redata.width,self.redata.height).data;

                    for (var i = 0, j = 0; i < data.length; i += 4) {
                        if (data[i] && data[i+1] && data[i+2] && data[i+3]){
                            total++;
                        }
                    }

                    //涂抹50%的时候触发
                    if ( total <= self.redata.width * self.redata.height * 0.5 ) {

                        self.callback.onUnlock && self.callback.onUnlock();
                    }
                }
            }
        },

        reset: function(si){

            if (typeof this.callback.onReset =='function'){

                //这里简单处理，用耦合的方式获得数据

                this.redata = this.callback.onReset(this.ctx,si);
            }

            this.ctx.globalCompositeOperation = 'destination-out';
        }
    }






    /**
     * 主程序
     */
    function Cloud (image){

        //当传入图片的时候
        if ( image ){

            this.init(this.cloudImage = image);
        } else {

            var image = new Image,
                self  = this;

            image.onload = function(){
                self.init(self.cloudImage = image);
            }

            image.src = CLOUD_IMAGE_SRC;
        }
    }
    Cloud.prototype ={
        init: function(){
            var self = this;

            //背景云层
            self.cloud      = $('.play_cloud');
            self.container  = $('.play_container');

            //判断是否有答案数据
            if ( typeof window.hfs_data !=='undefined' ) {
                self.data = hfs_data;
                self.nowtime = +new Date;

                //创建场景
                self.iboard();
                //刮刮卡
                self.icard();
                //tab切换
                self.itabswitch();
                self.icountdown();

            }
        },
        //初始化画板
        iboard: function(){

            var self = this,
                data = self.data;

            //放置线索的舞台节点
            self.board = $('.play_board');

            //存放线索节点
            self.clues =[];

            $.each( data,function(index,value,element,player){

                //图片线索
                if ( value.type=='image' ){

                    element = $('<div class="player-image"><img src="'+value.source+'"/></div>')
                    self.clues.push({
                        element : element.appendTo(self.board),
                        time : value.opentime
                    });

                    //音乐线索
                } else {
                    element = $('<div class="player-mp3"><div data-index="'
                        +index+'" class="mp3player-play"></div></div>').appendTo(self.board)

                    player = new MP3Player(value.source);

                    self.clues.push({
                        element : element,
                        player  : player,
                        time: value.opentime
                    });
                    //这里简单绑定下事件，不用代理处理
                    element.find('div').on('click',function(){
                        player. toggle(function(status){

                            element[status!='stop'
                                ?'addClass':'removeClass']('mp3player-stop')

                        });
                    });

                }
            });


            //初始化
            var start = parseInt(localStorage.getItem('start'),10),
                nows = self.clues[0].time;
            if ( start != nows){
                localStorage.setItem('open_0',0);
                localStorage.setItem('open_1',0);
                localStorage.setItem('open_2',0);
                localStorage.setItem('start',nows);
            }


        },
        //初始化选项卡，线索切换，以及线索定时切换
        itabswitch: function(){
            var tab = $('.play_tab li'),
                self = this,
                data = self.data,
            //记录当前时间
                nowtime = self.nowtime,
                step    = parseInt(localStorage.getItem('now')||0,10),
            //  urlstep = location.href.match(/step=(\d+)/),
                nopen   = -1;//当前没有解开的线索ID

            self.tab = tab;

            //遍历数据，初始化解锁状态
            data.forEach(function(item,index){
                var time = item.opentime,
                    wrap = tab.eq(index).find('.state');

                if ( time <= nowtime ) {
                    //当前线索已解锁
                    //localStorage.setItem('open_'+index,1);
                    wrap.html('（已解锁）')
                        .parent().addClass('unlock');

                } else {
                    //记录最近的没有解锁线索
                    if (nopen ==-1){
                        nopen = index;
                        //    localStorage.setItem('now',step = Math.max(0,index-1));
                    }
                    //localStorage.setItem('open_'+index,0);
                    wrap.html('（待解锁）');
                }
            });

            //判断URL里面是否有选中的参数
            //if ( urlstep ){

            //    localStorage.setItem('now',step=parseInt(urlstep[1],10))
            //}

            //线索选中状态以及绑定事件
            //console.log(nopen);
            //if (nopen!=-1) {
            if (!$('.next').length) {
                self.switchTab(self.step = step);
            } else {
                self.hideClues();


                self.card.hide();
                self.cloud.hide();
            }
            //}
            tab.on('click',function(){
                var me = $(this),
                    index = parseInt(me.attr('data-index'),10);
                if (me.hasClass('unlock')) {
                    self.switchTab(self.step=index);
                }
            });

            //存放lock索引
            self.lock = nopen;
        },
        //切换tab状态
        switchTab: function(index){
            var tab    = $('.play_tab li'),
                unlock = localStorage.getItem('open_'+index),
                self   = this;

            tab.removeClass('cur').eq(index).addClass('cur');
            localStorage.setItem('now',index);
            self.hideClues();
            self.container.addClass('active');

            //当前线索解锁的时候
            if ( unlock =='1') {
                //self.helper.hide();
                self.card.hide();
                self.cloud.hide();
                self.clues[index].element.show();
            } else {
                //self.helper.show();
                self.card.show();
                self.cloud.show();

                self.clues[index].element.show();
                self.reset();
            }
        },
        hideClues: function(){
            if (this.clues.length) {
                this.clues.forEach(function (item) {
                    item.element.hide();
                });
            }
        },

        //初始化线索解锁倒计时
        icountdown: function(){

            function res(o,num){
                var html =[];
                o.html('');

                num = num < 10
                    ? '0'+num : ''+num;

                num.split('').forEach(function(e){
                    html.push('<b>'+e+'</b>');
                });

                o.html(html.join(''));
            }

            return function(){
                var self = this,
                    clue ,
                    timerwrap = $('.play_timer'),
                    tspan = timerwrap.find('span'),
                    hwrap   = tspan.eq(0),
                    mwrap   = tspan.eq(1),
                    swrap   = tspan.eq(2),
                    nowtime = self.nowtime,
                    time =0,cf;


                if (clue = self.clues[self.lock]) {

                    time = clue.time - nowtime;
                }

                self.timer = setInterval( cf = function(){

                    if ( (time -= 1000)>=0 ) {
                        var kt =  time /1000;
                        var h   = Math.floor(kt /3600),//小时
                            mis = Math.floor(kt % 3600),//多少秒
                            m   = Math.floor(mis/60),
                            s   = Math.floor(mis%60);
                        if (timerwrap.length) {
                            res(hwrap, h);
                            res(mwrap, m);
                            res(swrap, s);
                        }

                        //倒计时结束
                    } else{
                        //
                        clearInterval(self.timer);
                        //修改tab状态，耦合了。。。。
                        self.tab.eq(self.lock).addClass('unlock')
                            .find('.state').html('（已解锁）');
                        //localStorage.setItem('open_'+self.lock,1);
                        //释放下一线索，
                        if ( ++self.lock<=2 ) {
                            self.icountdown();
                        } else {
                            timerwrap.remove();
                        }
                    }
                },1000);

                cf( time+=1000 );
                //}
            }

        }(),
        //初始化刮刮卡
        icard: function(){
            var self = this,
                card = $('<canvas class="card"></canvas>').appendTo(self.container)[0],
                cloud = $('<canvas></canvas>').appendTo(self.cloud)[0];

            self.card   = $(card);
            //self.helper   = $('<div class="player-helper"></div>').appendTo(self.container);

            self.cloudctx = cloud.getContext('2d');
            self.cardctx  = card.getContext('2d');

            card.width = cloud.width = self.cloud.width();
            card.height =cloud.height = self.cloud.height();

            self.scard = new Scratchcard(card,
                {
                    //当涂抹到50%的时候触发
                    onUnlock: function(ctx){
                        //云淡化
                        var clue = self.clues[self.step];


                        self.card.animate({opacity:.3},1000,function(){

                            clue.element.show();
                            self.card.css('opacity',1).hide();

                            //标记当前线索已解开
                            localStorage.setItem('open_'+self.step,1);

                            //触发unlock事件
                            self.onUnlock && self.onUnlock(self.step);
                        });

                        self.cloud.animate({opacity:.3},1000,function(){
                            self.cloud.css('opacity',1).hide();
                        })

                    },
                    //reset的时候调用事件
                    onReset: function(ctx,noback){

                        var context = self.cloudctx,
                            offset  = self.board.offset(),
                            coffset = self.cloud.offset(),
                            left    = offset.left-coffset.left,
                            top     = offset.top-coffset.top,
                            width   = self.board.width(),
                            height  = self.board.height();

                        ctx.globalCompositeOperation='source-over';
                        ctx.clearRect(left,top,width,height);
                        ctx.drawImage(self.cloudImage,0,0,card.width,card.height);
                        ctx.clearRect(0,0,card.width,top);
                        ctx.clearRect(0,0,left,card.height);
                        ctx.clearRect(left+width,top+height,left,top);
                        ctx.clearRect(left,top+height,card.width,top);
                        ctx.clearRect(left+width,top,left,card.height);

                        //画背景
                        context.clearRect(0,0,cloud.width,cloud.height);
                        context.drawImage(self.cloudImage, 0, 0, card.width, card.height);
                        //去掉中间区域
                        context.clearRect(left, top, width, height);

                        //返回坐标共card调用
                        //这里耦合了下。。减少代码
                        return {
                            width  : width,
                            height : height,
                            top    : top,
                            left   : left
                        }
                    }
                });
        },

        //重置reset
        reset: function(){
            this.scard.reset();
        }
    }

    $.Cloud = Cloud;
})(Zepto);