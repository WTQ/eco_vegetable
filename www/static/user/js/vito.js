/**
 * 主要的JS文件
 *
 * @author 风格独特
 * @vervion 1.0 2014-05-09
 */

/**
 * 获取用户订单列表
 */
// 设置start全局参数
/*var start = 0;

function load_myorder() {
	load_mask();
	var get = {
		'type' : 1,
	};
	$.getJSON(url('/user/order?callback=?'), get, function(data){
		hide_mask();

		if (data.status == 0) {
		    var html_im = template.render('my_order_list', data);
		    $($(".order_list > div")[0]).html(html_im);
		    var myScroller = $('#scrolling_order').scroller();
	    	if ($('.ordered', $($(".order_list > div")[0])).length < goods_page) {
	    		myScroller.clearInfinite();
	    	}
			order_cancel();
			orders_scrolling();

			// 更新start参数
			if(data.orders.length) {
				start = data.orders[data.orders.length - 1]['order_id'];
			}
		}
	});

	get.type = 2;
	$.getJSON(url('/user/order?callback=?'), get, function(data) {
		hide_mask();

		if (data.status == 0) {
		    var html_bm = template.render('my_order_list', data);
		    $($(".order_list > div")[1]).html(html_bm);
		    var myScroller = $('#scrolling_order').scroller();

	    	if ($('.ordered', $($(".order_list > div")[0])).length < goods_page) {
	    		myScroller.clearInfinite();
	    	}
			order_cancel();
			orders_scrolling();
		}
	});
}*/

/**
 * 订单详情函数
 */
/*function load_detail() {
	var order_id = get_param('order_id');
	var get = {
		'id' : order_id,
	};

	$('#wrap_ordered').html('<div id="scrolling_ordered"></div>');
	load_mask();

	$.getJSON(url('/user/order/detail?callback=?'), get, function(data) {
		var html_im = template.render('order_detail', data);
		$("#scrolling_ordered").html(html_im);

		// 设置滚动层
		var myScroller = $('#scrolling_ordered').scroller();

		order_cancel();
		hide_mask();
	});
}*/

// 近一个月订单和一个月前订单的切换
/*$.ui.ready(function() {
	$('.order > div').click(function() {
		$(this).addClass("order_item").siblings().removeClass("order_item");
		$(".order_list > div").hide().eq($('.order > div').index(this)).show();
	});
});*/

// 取消订单
/*function order_cancel() {
	//是否取消订单的弹出框
	$(".order_status2").unbind('click');

	$(".order_status2").click(function(n) {
		n.stopPropagation(n);
		var text = trim($(this).text());

		var order_id = $(this).attr('order_id');
		var that = this;

		if (text == '取消') {
			$.ui.popup({
				title: 'aaa',
				message: "确认取消订单",
				cancelText: "取消",
				cancelCallback: function () {
					// console.log("cancelled");
				},
				doneText: "确认",
				doneCallback: function () {
					var get = {
						'order_id' : order_id,
					};
					$.getJSON(url('/user/order/cancel?callback=?'), get, function(data) {
						// todo 需要改变状态的文本值
					});
				},
				cancelOnly: false
			});
		} else {
		}
		return false;
	});
}*/

/**
 * 订单上拉刷新函数
 */
/*function orders_scrolling() {
	var p = 1;
	var orders_page = 5;
	var myScroller;
	bind_scrolling();

	// 绑定相关滑动事件
    function bind_scrolling() {
    	myScroller = $('#scrolling_order').scroller();
    	myScroller.addInfinite();

	    $.bind(myScroller, "infinite-scroll", infinite_scroll);
	    myScroller.enable();
    }

    function infinite_scroll() {
    	if ($('#infinite').length > 0) {
    		return false;
    	}

        var self = this;

        $('#scrolling_order').append('<div id="infinite" style="height:90px;line-height:60px;text-align:center;font-weight:bold">正在加载...</div>');
        this.scrollToBottom();

        $.bind(myScroller, "infinite-scroll-end", function () {
            // console.log("infinite-scroll-end");
            $.unbind(myScroller, "infinite-scroll-end");

            setTimeout(function() {
            	self.clearInfinite();

            	var get = {
        			'type'	 : 1,					// 获取链接中的分类id号
        			'update' : 0,
        			'start'  : start,
            	};

            	// 调用控制器获取数据
            	$.getJSON( url('/user/order/?callback=?'), get, function(data) {
            		var html = template.render('my_order_list', data);

            		$($(".order_list > div")[0]).append(html);

            		// 更新start参数
            		if(data.orders.length) {
            			start = data.orders[data.orders.length - 1]['order_id'];
            		}

            		order_cancel();

					$('#infinite').remove();

					var orders_num = data.orders.length;
					if (orders_num < 1) {
						self.scrollToBottom(400);
					}

            		if (orders_num < orders_page) {
            			$.unbind(myScroller, "infinite-scroll");
            		}
            	});
            }, 400);
        });
    };
}*/
