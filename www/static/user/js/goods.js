/*! User端goods部分的JS代码 */

/**
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.5.18
 */


/**
 * 商店首页相关函数
 */
var firstLoadShop  = true;
var firstLoadGoods = true;
// 设置start全局参数
var start = 0;

function shop_info() {
	cart_badge();
	var community_id = 1;
	var shop_id      = 1;
	if (shop_id === null) {
		community_id = localStorage['community_id'];
		shop_id      = localStorage['shop_id'];
	}
	localStorage['shop_id']      = shop_id;
	localStorage['community_id'] = community_id;

	// 清除历史panel记录
	$.ui.clearHistory();

	if (firstLoadShop != true) {
		return;
	}

	load_mask();

	var get = {
		'shop_id' : shop_id
	};

	$.getJSON(url('/user/shop?callback=?'), get, function(data) {
		if (data.error == 0) {
			firstLoadShop = false;

			$('#shop_scrolling').html('<div id="body1_image"></div>');

			var low_price = data.low_price;
			// 将起送价本地存储
			localStorage['low_price'] = low_price;
			localStorage['shop_address'] = data.shop['address'];
			$("#low_price").text("订单满 " + low_price + " 元免费送货上门");

			// 显示小区名+店铺名
			$('#shop_name').text( data.community['name'] + ' - ' + data.shop['name'] );

			// 判断是否在营业时间
			if (data.time) {
				$("#shop_open").attr("class", "open");
				$('#shop_open').text('营业中');
			} else {
				$("#shop_open").attr("class", "close");
				$('#shop_open').text('已打烊');
			}

			// 显示店铺营业时间
			$('#shop_time').text( data.shop_hours['start_time'] + ' - ' + data.shop_hours['close_time']);

			// 将shop_ad字段中的html代码嵌入到指定的块中
			$('#body1_image').html(data.shop['shop_ad']);

			// 调用是刷新代码
//			shop_scrolling();
		} else {
			redirect('#position');
		}
		hide_mask();
	});
}

/**
 * 商品列表相关函数
 */
function goods_info() {
	// shop_info();
    // 清除历史panel记录
    $.ui.clearHistory();
    
	if (firstLoadGoods != true) {
		return;
	}
	var class_id = get_param("class_id");							// 取得分类id
	if (class_id == null) {
		class_id = 0;
	}
	var get = {
		'shop_id'  : localStorage['shop_id'],
		'class_id' : class_id
	};

	load_mask();
	$.getJSON( url('/user/shop/list_goods?&callback=?'), get, function(data) {
		firstLoadGoods = false;
		var html = template.render('goods_tab', data);				// JSON数据用模板渲染
		$('#goods_scrolling').html(html);							// 把渲染后的html代码加载到panel中
		
        // 将起送价本地存储
        localStorage['low_price'] = data.low_price;
        $("#low_price").text("订单满 " + data.low_price + " 元免费送货上门");
		
		goods_scrolling();
		hide_mask();
	});
}

/**
 * 商品分类切换
 */
function sort_change() {
	var class_id = get_param("class_id");
	if (class_id == null) {
		class_id = 0;
	}
	var get = {
		'shop_id'	: localStorage['shop_id'],
		'class_id'	: class_id
	};

	load_mask();

	$.getJSON( url('/user/shop/list_goods?callback=?'), get, function(data) {
		var html = template.render('goods_tab', data);				// JSON数据用模板渲染

		// 重建滚动层
		var myScroller = $('#goods_all').scroller();
		myScroller.disable();

		$('#goods_all').remove();									// 重新构建 goods_all 滚动层
		$('#goods_wrap').html('<div id="goods_all"><div id="goods_scrolling"></div></div>');

		$('#goods_scrolling').html(html);							// 把渲染后的html代码加载到panel中

		goods_scrolling();
		hide_mask();
	});
}

/**
 * 下拉刷新函数
 */
/*function shop_scrolling() {
	var trigger = false;			// 作为判断是否请求服务器数据的标志
	var myScroller;
	bind_scrolling();

    function bind_scrolling() {
    	myScroller = $('#body1_image').scroller();
	    myScroller.addPullToRefresh();

	    $.bind(myScroller, "scrollstart", scrollstart);
	    $.bind(myScroller, "scrollend", scrollend);
	    $.bind(myScroller, "refresh-trigger", refresh_trigger);
	    $.bind(myScroller, "refresh-release", refresh_release);
	    $.bind(myScroller, "refresh-cancel", refresh_cancel);

	    myScroller.enable();
    }

    function scrollstart() {
    	trigger = false;
        myScroller.setRefreshContent('下拉刷新');
    }

    function scrollend() {
    	myScroller.setRefreshContent('下拉刷新');
    	if (trigger == false) {
    		this.hideRefresh();
    	}
    }

    function refresh_trigger() {
    	// console.log("refresh_trigger");
    	trigger = true;
    	this.setRefreshContent('释放立即刷新');
    }

    var hideClose;
    function refresh_release() {
    	console.log("refresh_release");
    	this.setRefreshContent('下拉刷新');
        var that = this;
    	if (trigger == true) {
        	this.setRefreshContent('正在刷新……');
            clearTimeout(hideClose);
            hideClose = setTimeout(function () {
            	var get = {
            		'shop_id' : localStorage['shop_id']
            	};
    	        // 下拉刷新代码
            	$.getJSON(url('/user/shop?callback=?'), get, function(data) {
                	that.hideRefresh();
                	myScroller.disable();

                	// 重新构建body1_image滚动层
                	$('#body1_image').remove();
                	$('#shop_scrolling').html('<div id="body1_image"></div>');
            		// 将shop_ad字段中的html代码嵌入到指定的块中
            		$('#body1_image').html(data.shop['shop_ad']);

            		// 重新绑定事件
        			bind_scrolling();
            	});
            }, 500);
    	} else {
    		this.setRefreshContent('已取消');
    		clearTimeout(hideClose);
    		hideClose = setTimeout(function () {
    			that.hideRefresh();
            }, 350);
    	}

    	return false;
    }

    function refresh_cancel() {
    	console.log("refresh_cancel");
    	trigger = false;
        myScroller.setRefreshContent('下拉刷新');
        clearTimeout(hideClose);
    }

    function refresh_finish() {
        console.log("refresh-finish");
    }
}*/

/**
 * 上拉刷新函数
 */
function goods_scrolling() {
	var p = 1;
	var myScroller;
	var is_scrolling = false;
	bind_scrolling();
	// 绑定相关滑动事件
    function bind_scrolling() {
    	myScroller = $('#goods_all').scroller();
    	myScroller.addInfinite();

	    $.bind(myScroller, "infinite-scroll", infinite_scroll);
		$.bind(myScroller, "infinite-scroll-end", infinite_scroll_end);
	    myScroller.enable();

	    // 绑定添加购物车按钮
	    add2cart();
    }

    function infinite_scroll() {
    	// console.log("infinite-scroll");
    	// 判断需不需要下拉刷新，如果数据不够一个分页数据，直接返回
    	if ($('#goods_scrolling .goods').length < goods_page) {
    		this.clearInfinite();
    		return false;
    	}

    	if ($('.infinite').length < 1) {
    		$('#goods_scrolling').append('<div class="infinite" id="infinite" style="height:90px;line-height:60px;text-align:center;font-weight:bold">正在加载...</div>');
    	}
	};
	
	function infinite_scroll_end() {
		if (is_scrolling == true) {
        	return ;
        } else {
        	this.clearInfinite();
        	is_scrolling == true;
        }

		setTimeout(function() {
			myScroller.clearInfinite();
			var class_id = get_param("class_id");
			class_id = (class_id == null)? 0 : class_id;
			var get = {
				'shop_id'	: localStorage['shop_id'],
				'class_id'	: class_id,					// 获取链接中的分类id号
				'p'			: p + 1,
			};

			// 调用控制器获取数据
			$.getJSON( url('/user/shop/list_goods?callback=?'), get, function(data) {
				var html = template.render('goods_tab', data);			// 请求到的JSON数据用 html模板渲染

				$('#goods_scrolling').append(html);						// 把渲染后的html代码添加到div块中

				// 绑定添加购物车按钮
				add2cart();

				$('.infinite').remove();

				var goods_num = data.goods.length;
				if (goods_num < 1) {
					self.scrollToBottom(400);
				}

				if (goods_num < goods_page) {
					$.unbind(myScroller, "infinite-scroll-end");
					$.unbind(myScroller, "infinite-scroll");
				} else {
					p++;
				}
				is_scrolling = false;
			});
		}, 400);
    };
}

/**
 * 搜索框绑定事件
 */
$.ui.ready(function() {
	$('#search_form').submit(function() {
		var keyword = $('#search_input').val();
		var get		= {
			'shop_id'  : localStorage['shop_id'],
			'keyword' : keyword,
		};

		// 显示搜索层
		$("#search_content").addClass("search_change");
		$('#search_input')[0].blur();

		// 设置搜索历史
		set_keyword(keyword);
		update_keyowrd();

		load_mask();
		$.getJSON(url('/user/goods/search?callback=?'), get, function(data) {
			var html = template.render('goods_tab', data);				// JSON数据用模板渲染
			$('#search_results').html(html);							// 把渲染后的html代码加载到search_results块中

			search_scrolling();
			hide_mask();
		});

		return false;
	});
});

/**
 * 搜索页面
 */
function goods_search() {
	// 焦点放置于搜索框
	$('#search_input').val('');
	$('#search_input')[0].focus();
	$("#search_content").removeClass('search_change');

	// 更新搜索历史记录
	update_keyowrd();
}

/**
 * 设置搜索的关键词
 */
function set_keyword(keyword) {
	var all = new Array;
	var ls = localStorage.getItem('keyword');
	if (ls !== null) {
		all = $.parseJSON(ls);

		// 防止相同的关键词被加入
		for (var i = 0; i < all.length; ++i) {
		    if (all[i] == keyword) {
		        all.splice(i, 1);
		    }
		}
		all.unshift(keyword);

		//  保持关键词的个数
		if (all.length > 5) {
			all.splice(5, 1);
		}
	} else {
		all[0] = keyword;
	}
	localStorage['keyword'] = JSON.stringify(all);
}

/**
 * 获取搜索关键词
 */
function get_keyword() {
	var all = new Array;
	var kw = localStorage.getItem('keyword');
	if (kw !== null) {
		all = $.parseJSON(kw);
	}
	return all;
}

/**
 * 清除关键字历史记录
 */
function clear_keyword() {
	localStorage.removeItem('keyword');
}

/**
 * 更新关键字列表
 */
function update_keyowrd() {
	var data = {
		'kws'	: get_keyword()
	};
	var html = template.render('tmp_search_hist', data);
	$('#search_history_list').html(html);

	// 绑定点击操作
	$('#search_history_list a').unbind('click');
	$('#search_history_list li').click(function() {
		keyword = $(this).text();
		$('#search_input').val(keyword);
		$('#search_form').trigger('submit');
	});
}

/**
 * 输入框的取消按钮
 */
function input_cancel(s_input) {
	document.getElementById(s_input).blur();
	$.ui.goBack();
}

/**
 * 搜索结果页面上拉刷新函数
 */
function search_scrolling() {
	var p = 1;
	var myScroller;
	bind_scrolling();

	// 绑定上拉滑动事件
    function bind_scrolling() {
    	myScroller = $('#search_wrap').scroller();
    	myScroller.addInfinite();

	    $.bind(myScroller, "infinite-scroll", infinite_scroll);
	    myScroller.enable();

		// 绑定添加购物车按钮
	    add2cart();
    }

    function infinite_scroll() {
    	console.log("infinite-scroll");
    	// 如果搜索结果不够一个分页数据10，直接返回
    	if ($('#search_results .goods').length < goods_page) {
    		this.clearInfinite();
    		return false;
    	}
    	if ($('#infinite').length > 0) {
    		return false;
    	}

    	var self = this;

    	$('#search_results').append('<div id="infinite" style="height:90px;line-height:60px;text-align:center;font-weight:bold">正在加载...</div>');
    	this.scrollToBottom();

    	$.bind(myScroller, "infinite-scroll-end", function () {
    		console.log("infinite-scroll-end");
    		$.unbind(myScroller, "infinite-scroll-end");

    		setTimeout(function() {
            	self.clearInfinite();
            	var get = {
					'shop_id'	: localStorage['shop_id'],
            		'keyword'	: $('#search_input').val(),						// 获取搜索框的输入内容
            		'p'			: p + 1,
            	};
            	$.getJSON(url('/user/goods/search?callback=?'), get, function(data) {
            		var html = template.render('goods_tab', data);				// JSON数据用模板渲染

            		$('#search_results').append(html);							// 把渲染后的html代码添加到search_results块中
            		$('#infinite').remove();

        			// 绑定添加购物车按钮
        		    add2cart();

            		var goods_num = data.goods.length;

            		if (goods_num < 1) {
            			self.scrollToBottom(400);
            		}

            		if (goods_num < goods_page) {
            			$.unbind(myScroller, "infinite-scroll");
            		} else {
            			p++;
            		}
            	});
    		}, 400);
    	});
    }
}

/**
 * 单品详情页面函数
 */
function load_goods_detail() {
	var goods_id = get_param("goods_id");		// 解析链接中的goods_id
	var get      = {
		'goods_id' : goods_id
	};

	if (goods_id > 0) {
		$('#wrap_goods_info').html('<div id="goods_info_scrolling"></div>');
		load_mask();

		$.getJSON(url('/user/goods/info?callback=?'), get, function(data) {
			var html = template.render('tmp_goods_index', data);
			$('#goods_info_scrolling').html(html);
			// 在add_cart标签中添加商品信息属性
			$(".add_cart").attr('goods_id', goods_id);
			$(".add_cart").attr('price', data.goods.price);
			$(".add_cart").attr('name', data.goods.name);
			// 当商品缺货时
			if (data.goods['stock'] == 0) {
				$("#goods_add_wrap").addClass('change_add_cart');
			} else {
				$("#goods_add_wrap").removeClass('change_add_cart');
			}

			// 启动滚动层
			$('#goods_info_scrolling').scroller();

			hide_mask();
		});
	}
}

/**
 * 商品列表页面添加到购物车
 */
function add2cart() {
	// 绑定添加按钮事件
	$(".add").unbind('click');
	$(".add").click(function(n) {
		n.stopPropagation();
		var goods_id   = $(this).attr('goods_id');
		var price      = $(this).attr('price');
		var name       = $(this).attr('name');
		var qty        = 1;	// 添加到购物车时默认为数量为 1
		var goods_info = {
			'goods_id' : goods_id,
       		'price'    : price,
  			'name'     : name,
       		'qty'      : qty
		};
		// 将商品添加到购物车，并存储到本地
		cart_add(goods_info);
		// 获取购物车中商品件数，在footer显示
		var total_items = cart_total_items();
		$.ui.updateBadge("#total_items", total_items, 'tr', '#FFF');
		// 总金额变化实时显示
		$(".total_price").text(cart_total_price() + " 元");

		return false;
	});
}

/**
 * 结算商品页面中载入购物车信息
 */
function load_cart() {

	$('#cart_goods_scrolling').html('<div id="cartgoods_all"></div>');

	var data = new Array;
	// 获取cart里全部商品，包括settle=0
	data['cart'] = cart_dejson(true);
	// 将本地存储的购物车信息渲染到HTML模版
	var html = template.render('tmp_my_cart', data);
	// 将购物车总额存储在本地
	localStorage['total_price'] = cart_total_price();

	$('#cartgoods_all').html(html);
	$('.total_price').text(localStorage['total_price'] + ' 元');
	cart_in_de();
	var low_price = localStorage['low_price'];
	// 给div层添加滚动效果
	var myScroller = $('#cartgoods_all').scroller();
}

/**
 * 点击“结算商品”按钮的操作
 */
$.ui.ready(function() {
	$('#settle_goods').click(function() {
	// 判断是否登录状态
	if (typeof(localStorage['phone']) == 'undefined') {
		localStorage['back2cart'] = 1;
		// 没检测到本地存储的Phone，跳转到注册页面
		redirect("#register");
	} else if ((typeof(localStorage['phone']) != 'undefined') && (typeof(localStorage['user_address']) == 'undefined')) {
		localStorage['back2cart'] = 1;
		// 检测到用户已注册但尚未填写配送地址，跳转到地址填写页
		redirect("#position_input");
	} else {
		// 用户已登录
		redirect("#cart");
	}
	});
});

/**
 * 提交订单
 * 1、cart_http_param()将localStorage['cart']提交到服务器，检查缺货下架并同步商品信息
 * 2、cart_update_all()将同步后的商品信息填充到购物车中，并覆盖localStorage['cart']
 * 3、请求优惠信息
 */
function cart_confirm() {
	// 从localStorage['cart']解析发送到服务器的购物车参数
	var get = {
		'cart'		  : decodeURI(cart_http_param()),	// [{"goods_id": ,"qty": }]
		'shop_id'	  : localStorage['shop_id'],
		'total_price' : localStorage['total_price']
	};

	load_mask();
	$.getJSON(url('/user/cart?callback=?'), get, function(data) {
		// 清除同步服务器之前的购物车本地存储
		// cart_destroy();
		//localStorage.removeItem('coupon');
		// 将同步后的cart信息重新本地存储
		var cart = cart_update_all(data.items);

		// TODO 异步请求的隐患

		$('#cart_goods_scrolling_2').html('<div id="cartgoods_all_2"></div>');
		// 将本地存储的cart信息解码成数组
		var cart_data = {
			'cart' : cart_dejson()
		};
		var html     = template.render('tmp_my_cart', cart_data);
		// 将购物车总额存储在本地
		localStorage['total_price'] = cart_total_price();

		$('#cartgoods_all_2').html(html);
		// 给商品列表层添加滚动效果
		var myScroller = $('#cartgoods_all_2').scroller();


		// TODO 后期需要将优惠信息请求合并到 cart/index中
		// cart_in_de();
		// 判断是否满足起送额
		if (localStorage['total_price'] * 10000 < localStorage['low_price'] * 10000) {
			// 不足额时
			$("#user_address").text(localStorage['user_address']);
			$("#user_phone").text(localStorage['phone']);
			$("#total_type").text('距离起送金额还差');
			// 确认订单按钮为灰色
			$("#confirm_type").attr('class', 'account_goods order_shortage');
			$("#confirm_type").html('<div class="unconfirm_order">确认订单</div>')
			var subtract = (localStorage['low_price'] * 10000 - localStorage['total_price'] * 10000) / 10000;
			// footer显示“距离起送金额还差xx元”
			$(".total_price").text(subtract + ' 元');
		} else {
			// 足额时
			$("#confirm_type").html('<div class="confirm_order">确认订单</div>')
			$("#user_address").text(localStorage['user_address']);
			$("#user_phone").text(localStorage['phone']);
			$("#total_type").text('总金额');
			$("#confirm_type").attr('class', 'account_goods');

			var get = {
				'shop_id'     : localStorage['shop_id'],
				'total_price' : localStorage['total_price']		// 总额用于判断是否满足优惠条件
			};

			/*$.getJSON(url('/user/coupon?callback=?'), get, function(data) {
				data['total_price'] = get.total_price;
				var html = template.render('available_coupons', data);
				$('#shop_cuopons').html(html);
			});*/
		}

		hide_mask();
	});
}

/**
 * 单品详情页面添加到购物车
 */
$.ui.ready(function() {
	// 点击“加入购物车”按钮事件
	$(".add_cart").click(function(n) {
		n.stopPropagation();
		// 获取div标签里的商品信息属性
		var goods_id	= $(this).attr('goods_id');
		var price		= $(this).attr('price');
		var name		= $(this).attr('name');
		var qty			= 1;	// 添加到购物车时默认数量为 1
		var goods_info	= {
			'goods_id'  : goods_id,
       		'price'     : price,
  			'name'      : name,
       		'qty'       : qty,
		};
		// 将商品添加到购物车，并存储到本地
		cart_add(goods_info);
		// 更新购物车中商品件数，在footer显示
		var total_items = cart_total_items();
		$.ui.updateBadge("#total_items", total_items, 'tr', '#FFF');
		// 跳转到购物车页面
		redirect('#account_cart');

		return false;
	});
});

/**
 * 购物车商品数量改变时总额、优惠等信息实时更新
 */
/*function cart_num_update(id, qty, index) {
	// 获取本地存储的起送价
	var low_price = window.localStorage['low_price'];
	var get = {
		'id'	: id,
		'qty'	: qty,
	};
	$.getJSON(url('/user/cart/update?callback=?'), get, function(data){
		var t = $(".number");
		window.localStorage['total_price'] = data['total_prices'];		// 总金额本地存储
		$(t[index]).text(data['items'][index]['qty']);
		$('.total_price').text(window.localStorage['total_price'] + ' 元');
		$.ui.updateBadge("#total_items", data.total_items, 'tr', '#FFF');
		if (window.localStorage['total_price'] * 100 < low_price * 100) {
			// 差额
			var subtract = (low_price * 100 - window.localStorage['total_price'] * 100) / 100;
			// 不满额时footer为灰色不能点击
			$("#if_full").html('<div class="underfull">还差' + subtract + '元可送</div>');
			// $(".confirm_order").text("还差" + subtract + "元可送");
		} else {
			// 满额时footer可点击提交
			$("#if_full").html('<div class="confirm_order">结算商品</div>');
			var get = {
				'total_price'	: window.localStorage['total_price'],	// 传递订单总额
			};
			$.getJSON(url('/user/coupon?callback=?'), get, function(data) {
				data.total_price = window.localStorage['total_price'];
				var html = template.render('available_coupons', data);	// JSON数据用模板渲染
				$('#shop_cuopons').html(html);							// 嵌入到网页中
			});
			bind_confirm_order();
			// $(".confirm_order").text("结算商品");
		}
	});
}*/

/**
 * 实时获取用户选择的优惠券id
 */
$.ui.ready(function() {
	// 选定优惠券时实时改变总额
	$('#shop_cuopons').change(function() {
		var coupon_id   = $('#shop_cuopons').val();
		var total_price = localStorage['total_price'];
		var reduce      = 0;
		var present     = '';
		var discount    = 1;
		var get         = {
			'coupon_id'	: coupon_id,
		};
		$.getJSON(url('/user/coupon/get_coupon?callback=?'), get, function(data) {
			switch (get.coupon_id) {
				case '1':
					reduce = data['reduce'];
					var price_coupon = (total_price * 10000 - reduce * 10000) / 10000;
					$('.total_price').text(price_coupon + ' 元');
					break;
				case '2':
					present = data['present'];
					$('.total_price').text(total_price + ' 元');
					break;
				case '3':
					discount = data['discount'];
					var price_coupon = (total_price * 10000) * discount / 100000;
					$('.total_price').text(price_coupon + ' 元');
					break;
				default:
					$('.total_price').text(total_price + ' 元');
					break;
			}
		});
		// 优惠后的总价
		var price_coupon = (total_price * 100 - reduce * 10000) * discount / 10000;
		$('.total_price').text(price_coupon + ' 元');

		return false;
	});
});

/**
 * 购物车页面商品数量增减函数
 */
function cart_in_de() {
	// + 按钮事件
	$(".increase").click(function(n) {
		n.stopPropagation();	// 阻止冒泡

		// 获取购物车中各商品信息DOM对象
		var cart_goods = $(".cart_goods");
		// 获取购物车中各商品数量DOM对象
		var goods_num  = $(".number");
		// 查询是第几个increase按钮
		var i          = $(".increase").index($(this));
		// 获取该increase按钮所属的商品信息
		var goods_id   = $(cart_goods[i]).attr('goods_id');
		var price      = $(cart_goods[i]).attr('price');
		var name       = $(cart_goods[i]).attr('name');
		var goods_info = {
			'goods_id' : goods_id,
			'price'	   : price,
			'name'	   : name,
			'qty'	   : 1,
		};
		// 更新本地cart
		cart_add(goods_info);
		// 更新商品数量和总金额显示
		var n = cart_item(goods_id);
		$(goods_num[i]).text(($.parseJSON(localStorage['cart'])[n].qty));

		// 去掉下次购买阴影层
		unsettle_hide_mask(i);
		// 更新购物车
		cart_badge();
	});

	// - 按钮事件
	$(".decrease").click(function(n){
		n.stopPropagation();	// 阻止冒泡

		// 获取购物车中各商品信息DOM对象
		var cart_goods = $(".cart_goods");
		// 获取购物车中各商品数量DOM对象
		var goods_num  = $(".number");
		// 查询是第几个increase按钮
		var i          = $(".decrease").index($(this));

		// 判断数量是不是为1了，如果为1，应该滑出右边的删除部分
		var old_num	   = $(goods_num[i]).text();
		if (old_num == 1) {
			$('#account_cart .cart_goods').eq(i).css('margin-left','-146px');
			$('.swipe_left').eq(i).show();
			return ;
		}

		// 获取该increase按钮所属的商品信息
		var goods_id   = $(cart_goods[i]).attr('goods_id');
		var price      = $(cart_goods[i]).attr('price');
		var name       = $(cart_goods[i]).attr('name');
		var goods_info = {
			'goods_id' : goods_id,
			'price'	   : price,
			'name'	   : name,
			'qty'	   : -1,
		};
		// 更新本地cart
		cart_add(goods_info);
		// 更新商品数量和总金额显示
		var n = cart_item(goods_id);
		$(goods_num[i]).text(($.parseJSON(localStorage['cart'])[n].qty));

		// 去掉下次购买阴影层
		unsettle_hide_mask(i);
		// 更新购物车
		cart_badge();
	});
}

/**
 * 订单最终确认提交
 */
$.ui.ready(function() {
	$('#account_footer').delegate('.confirm_order', 'click', function() {
		var payment     = $('#pay').val();
		var final_price = $('.total_price').text();
		var coupon_id   = $('#shop_cuopons').val();

		var get = {
			'final_price' : final_price,
			'payment'     : payment,
			'coupon_id'	  : 0
		};

		// （选择优惠后）最终总额
		localStorage['total_price'] = get.final_price;


		load_mask();
		$.getJSON(url('/user/order/submit?callback=?'), get, function(data) {
			hide_mask();
			if (data.status == 0) {
				// 将“下次购买”商品设置settle=1
				cart_destroy();
				cart_set_settle();

				if (payment == 0) {
					redirect('#verify');
				} else if (payment == 1) {
					var get = {
						'order_id' : data.order_id,
						'flow_id'  : data.flow_id
					};
					load_mask();
					$.getJSON(url('/alipay?callback=?'), get, function(data) {
						hide_mask();
						// location.href = data.http_req;
						var ref = window.open(data.http_req, '_blank');
						ref.addEventListener('loadstop', function(event) {
							if (event.url == 'http://eco.te168.cn/alipay/close') {
								ref.close();
								redirect('#myorder');
							}
						});
						ref.addEventListener('exit', function(event) {
                            ref.close();
                            redirect('#myorder');
                        });
					});
				}
			} else if (data.status == 1){
				$.ui.popup({
                    message: data.msg,
                    cancelText: "取消",
                    doneText: "登录",
                    doneCallback: function () {
                        redirect('#sign');
                    },
                    cancelOnly: false
                });
			} else {
				$.ui.popup({
					message	: data.msg,
	                cancelText: "确认",
	                cancelOnly: true
				});
			}
		});
	});
});

function load_verify() {
	var flag = 0;
	// 订单提交成功后恢复购物车初始图标
	$.ui.removeBadge("#total_items");
	// $.ui.updateBadge("#total_items", 0, 'tr', '#FFF');
	// 添加返回主界面按钮
	$("#verify_click").click(function() {
		$.ui.loadContent('#index', false, false, 'fade');
		flag = 1;
	});
	setTimeout(function() {
		if (flag == 0) {
			$.ui.loadContent('#index', false, false, 'fade');
		}
	}, 5000);
}

/**
 * 用户登录成功提示页面
 */
function login_success() {
	// 如果是从购物车页面跳转进来
	if (localStorage['back2cart'] == 1) {
		localStorage['back2cart'] = 0;
		// 跳转回购物车页面
		setTimeout(function() {
			$.ui.loadContent('#account_cart', false, false, 'fade');
		}, 3000);
	} else {
		// 如果是从小区选择页面跳转进来
		// 跳转回商家首页
		setTimeout(function() {
			$.ui.loadContent('#index', false, false, 'fade');
		}, 3000);
	}

}

$.ui.ready(function() {
	$("#search_input").click(function(){
		$("#search_content").removeClass("search_change");
	});
});

/**
 * 手机注册步骤 1
 */
$.ui.ready(function() {
	bind_send_verify();

	// 验证码倒计时
	var cnt = 60;
	var curcnt;
	var timeobj;
	function set_Time() {
		// 计数
		curcnt--;
		$(".send_verifycode").text('重新获取(' + curcnt + ')');
		if (curcnt < 1 ) {
			clearInterval(timeobj); // 停止计时器
			$(".send_verifycode").text('重新获取');
			$(".send_verifycode").css('background-color','#6AAB37');
			bind_send_verify();
		}
	}

	function bind_send_verify() {
		$(".send_verifycode").click(function() {
			var phone	= $(".phone_left").val();
			var reg		= /^1[3|4|5|8]\d{9}$/;
			// 验证手机号格式
			if (!reg.test(phone)) {
				$("#phone_error").text("您输入的号码格式有误");
				return;
			}

			$(".send_verifycode").unbind('click');
			var get = {
				'phone'	: phone,
			};

			// 发送验证码
			$.getJSON(url('/user/phone/verify?callback=?'), get, function(data) {
				if (data.error != 0) {
					$("#phone_error").text("验证码发送失败");
				}
			});

			curcnt = 60;
			timeobj = setInterval(set_Time, 1000);

			$(".send_verifycode").css('background-color','#a1a7b2');
			$(".send_verifycode").text("重新获取(" + 60 + ")");
		});
	}

	// 接收验证码
	$("#verify1").click(function() {
		var verify = $(".verifycode_input").val();
		var get = {
			'verify' : verify,
		};

		if (get.verify == '') {
			$("#phone_error").text("您输入的验证码有误");
			return false;
		}
		$.getJSON(url('/user/phone/check_verify?callback=?'), get, function(data) {
			if (data.check_verify == false) {
				$("#phone_error").text("您输入的验证码有误");
			} else {
				// 跳转到后续验证步骤
				$.ui.loadContent('#verifyphone', false, false, 'fade');
			}
		});
	});

	$(".verifycode_input").focus(function(){
		$(".verify1").css('background-color','#6AAB37');
		$(".verify2").show();
	});

	// 点击X清空验证码栏
	$(".verify2").click(function() {
		$(".verifycode_input").empty();
	});
});

/**
 * 验证手机后输入密码
 */
$.ui.ready(function() {
	// 检查密码
	$(".confirm_code").click(function() {
		var pwd_1 = $("#pwd_1").val();			// 获取首次输入的密码
		var pwd_2 = $("#pwd_2").val();			// 获取重复输入的密码

		if (pwd_1 === pwd_2) {
			// 密码输入一致时，请求服务器
			var get = {
				'phone'		   : $(".phone_left").val(),
				'password'	   : pwd_1,
				'community_id' : localStorage['community_id']
			};
			$.getJSON(url('/user/user/add_user?callback=?'), get, function(data) {
				// 登录成功，跳转到首页
				if (data.error == 1) {
					$("#pwd_error").text("该手机用户已注册");
				} else {
					// 本地存储用户手机号和用户所在小区名
					localStorage['phone']          = data.phone;
					localStorage['community_name'] = data.community_name;
					// 设address_id是为了方便之后单独添加用户地址
					localStorage['address_id']     = data.address_id;
					// 新注册用户继续完成地址填写
					redirect("#position_input");
				}
			});
		} else {
			// 密码输入不一致，显示错误提示
			$("#pwd_error").text("两次输入的密码不一致");
		}
	});
});

function load_verifyphone() {
	// 填充手机号
	$(".phonenumber").text($(".phone_left").val());
}

/**
 * 手机验证步骤 2
 */
$.ui.ready(function() {
	$(".secretcode_input").focus(function(){
		$(".confirm_code").css('background-color','#e74c3c');
	});
});

/**
 * 登录页面
 */
$.ui.ready(function() {
	$(".signin").click(function() {
		var phone    = $("#phone").val();
		var password = $("#pwd").val();
		var get      = {
			'phone'    : phone,
			'password' : password,
		};
		$.getJSON(url('/user/login?callback=?'), get, function(data) {
			// 用户验证成功
			if (data.login == 1) {
				// 如果是从购物车页面登录
				if (localStorage['back2cart'] == 1) {
					localStorage['back2cart']    = 0;
					localStorage['shop_id']      = data.shop_id;
					localStorage['community_id'] = data.community_id;
					localStorage['user_address'] = data.address;		// 区别商家地址shop_address
					localStorage['phone']        = data.phone;
					localStorage['user_id']      = data.user_id;
					redirect('#verify_suc');
				} else {
					// 如果是从“我的账户”页面登录
					localStorage['shop_id']      = data.shop_id;
					localStorage['community_id'] = data.community_id;
					localStorage['user_address'] = data.address;		// 区别商家地址shop_address
					localStorage['phone']        = data.phone;
					localStorage['user_id']      = data.user_id;
					// 跳转到用户验证成功页面
					redirect('#verify_suc');
				}
			} else {
				$("#login_error").text("用户名或密码错误");
			}
		});
	});
});

/**
 * 我的优惠券列表相关函数
 */
function coupon_list() {
	// 读取本地存储的 shop_id
	var shop_id = localStorage['shop_id'];
	var get = {
		'shop_id' : shop_id
	};

	$.getJSON(url('/user/coupon?callback=?'), function(data) {
		var html = template.render('my_coupon_list', data);
		$('#all_coupons').html(html);
		coupon_details();
	});
}

/**
 * 优惠券详情展开
 */
function coupon_details() {
	$(".coupon_click").click(function() {
		var index = $(".coupon_click").index($(this));
		$('.coupon_hide').eq(index).toggle();
	});
}

/**
 * 将优惠券本地存储为JSON
 */
function coupon_local(data) {
	var item = new Array;

	for (var i = 0; i < data.coupon.length; i++) {
		item[i] = {
			'coupon_id' : '' + data.coupon[i]['coupon_id'],				// 优惠券id
			'full'		: '' + data.coupon[i]['content']['full'],		// 优惠最低金额
			'info'		: '' + data.coupon[i]['content']['info'],		// 优惠内容
			'reduce'	: '' + data.coupon[i]['content']['reduce'],		// 满减
			'present'	: '' + data.coupon[i]['content']['present'],		// 满送
			'discount'	: '' + data.coupon[i]['content']['discount']		// 折扣
		}
	};
	localStorage['coupon'] = JSON.stringify(item);
}

/**
 * 将本地存储的优惠信息JSON解码，并容错
 */
function coupon_dejson() {
    if (typeof(localStorage['coupon']) != 'undefined') {
        var coupon = $.parseJSON(localStorage['coupon']);
        return coupon;
    } else {
        var cart = new Array;
        return coupon;
    }
}

/**
 * 订单详情函数
 */
function load_detail() {
	var order_id = get_param('order_id');
	var get      = {
		'order_id' : order_id
	};

	if (get.order_id !== '') {
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
	};

}

/**
 * 近一个月订单和一个月前订单的切换
 */
$.ui.ready(function() {
	$('.order > div').click(function() {
		$(this).addClass("order_item").siblings().removeClass("order_item");
		$(".order_list > div").hide().eq($('.order > div').index(this)).show();
	});
});

/**
 * 重新处理订单（取消或在线支付）
 */
function order_cancel() {
	//是否取消订单的弹出框
	$(".order_status2").unbind('click');

	$(".order_status2").click(function(n) {
		n.stopPropagation(n);
		var text = $(this).text();

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
		} else if (text == '在线支付') {
			var get = {
				'order_id' : order_id
			};
			$.getJSON(url('/user/order/rebuild'), get, function(data) {
				if (data.status == 0) {
					var get = {
						'order_id' : data.order_id,
						'flow_id'  : data.flow_id,
					};
					
                    load_mask();
					$.getJSON(url('/alipay?callback=?'), get, function(data) {
						// location.href = data.http_req;
                        hide_mask();
						var ref = window.open(data.http_req, '_blank');
						ref.addEventListener('loadstop', function(event) {
							if (event.url == 'http://eco.te168.cn/alipay/close') {
								ref.close();
								load_myorder();
							}
						});
						
                        ref.addEventListener('exit', function(event) {
                            ref.close();
                            redirect('#myorder');
                        });
					});
				}
			});
		}
		return false;
	});
}

/**
 * 获取用户订单列表
 */
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
}

/**
 * 订单上拉刷新函数
 */
function orders_scrolling() {
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
}

/**
 * 购物车左滑删除
 */
$.ui.ready(function() {
	// 向左滑动
	$("#account_cart").delegate('.cart_goods', 'swipeLeft', function(data) {
		$(this).css('margin-left','-146px');
		$('.swipe_left', $(this)).show();
	});

	// 向右滑动
	$("#account_cart").delegate('.cart_goods', 'swipeRight', function(data) {
		$('.swipe_left', $(this)).hide();
		$(this).css('margin-left', '0');
	});

	// 下次购买
	$("#account_cart").delegate('.swipe_left1', 'click', function(data) {
		var goods_id = $(this).attr('goods_id');
		cart_unset_settle(goods_id);

		// 加上阴影层
		var index = $('.swipe_left1').index($(this));
		$('.swipe_left').eq(index).hide();
		$('.cart_goods').eq(index).css('margin-left', '0');
		unsettle_set_mask(index);

		// 更新购物车
		cart_badge();
	});

	$("#account_cart").delegate('.swipe_left2', 'click', function(data) {
		var goods_id = $(this).attr('goods_id');
		cart_delete(goods_id);
		// 删除节点
		var index = $('.swipe_left2').index($(this));
		$('#cartgoods_all a').eq(index).remove();
		// 更新购物车
		cart_badge();
	});
});

/**
 * 加上下次购买阴影层
 */
function unsettle_set_mask(index) {
	var shortage_pos = $('#cartgoods_all .goods_image').eq(index);
	$('.shortage2', shortage_pos).remove();
	shortage_pos.append('<div class="shortage2">下次<br />购买</div>');
}

/**
 * 去掉下次购买阴影层
 */
function unsettle_hide_mask(index) {
	var shortage_pos = $('#cartgoods_all .goods_image').eq(index);
	$('.shortage2', shortage_pos).remove();
}
