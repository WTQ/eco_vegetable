/*! User��goods���ֵ�JS���� */

/**
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. �Ʒ�������.
 * @version		Version 1.0
 * @since		2014.5.18
 */


/**
 * �̵���ҳ��غ���
 */
var firstLoadShop  = true;
var firstLoadGoods = true;
// ����startȫ�ֲ���
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

	// �����ʷpanel��¼
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
			// �����ͼ۱��ش洢
			localStorage['low_price'] = low_price;
			localStorage['shop_address'] = data.shop['address'];
			//$("#low_price").text("������ " + low_price + " Ԫ����ͻ�����");
			$("#low_price").text("������60����300Ԫ�;�Ʒů��");
			
			// ��ʾС����+������
			$('#shop_name').text(data.shop['name'] );
			
			// �ж��Ƿ���Ӫҵʱ��
			if (data.time) {
				$("#shop_open").attr("class", "open");
				$('#shop_open').text('Ӫҵ��');
			} else {
				$("#shop_open").attr("class", "close");
				$('#shop_open').text('�Ѵ���');
			}
			
			// ��ʾ����Ӫҵʱ��
			$('#shop_time').text( data.shop_hours['start_time'] + ' - ' + data.shop_hours['close_time']);

			// ��shop_ad�ֶ��е�html����Ƕ�뵽ָ���Ŀ���
			$('#body1_image').html(data.shop['shop_ad']);

			// ������ˢ�´���
			shop_scrolling();
		} else {
			redirect('#position');
		}
		hide_mask();
	});
}

/**
 * �����һ���ع���
 */
$.ui.ready(function() {
	// ��֤�뵹��ʱ
	var cnt = 180;
	var curcnt;
	var timeobj;
	function set_Time1() {
		// ����
		curcnt--;
		$(".get-code").text('�ط�(' + curcnt + 's)');
		if (curcnt < 1 ) {
			clearInterval(timeobj); // ֹͣ��ʱ��
			$(".get-code").text('��ȡȷ����');
			$(".get-code").removeClass('get-code-wait');
		}
	}

	$(".get-code").click(function() {
		if ($(this).hasClass('get-code-wait')) {
			return ;
		}

		// ��֤�ֻ������ʽ
		var phone	= $('#pw-phone').val();
		var reg		= /^1[3|4|5|8]\d{9}$/;
		// ��֤�ֻ��Ÿ�ʽ
		if (!reg.test(phone)) {
			$('#pw-error').text("������ĺ����ʽ����");
			return;
		}


		var get = {
			'phone'	: phone
		};

		$(".get-code").text('������...');
		$('.get-code').addClass('get-code-wait');
		$.getJSON(url('/user/password/code?callback=?'), get, function(data) {
			if (data.error != 0) {
				$.ui.popup({
					message: data.msg,
	                cancelText: "ȷ��",
	                cancelOnly: true
				});
				$(".get-code").text('��ȡ��֤��');
				$(".get-code").removeClass('get-code-wait');
			} else {
				// ������ʱ��
				curcnt = cnt;
				timeobj = setInterval(set_Time1, 1000);
			}
		});
	});

	$('#pw-edit').click(function() {
		var pwd1 = $('#pw-pwd').val();
		var pwd2 = $('#pw-re-pwd').val();

		// ����Ϊ�յ��ж�
		if (pwd1 == '') {
			$('#pw-error').text('�����벻��Ϊ��');
			return;
		}

		// �������벻��ͬ�ж�
		if (pwd1 != pwd2) {
			$('#pw-error').text('�����������벻ͬ');
			return ;
		}

		// ���볤��Ϊ6-15λ�ж�
		if (pwd1.length < 6 || pwd1.length > 15) {
			$('#pw-error').text('���볤��Ϊ6-15λ');
			return ;
		}

		var get = {
			'phone'		: $('#pw-phone').val(),
			'password'	: $('#pw-pwd').val(),
			'code'		: $('#pw-code').val()
		};

		// ֹͣ��ʱ��
		clearInterval(timeobj);

		load_mask();
		$.getJSON(url('/user/password/find?callback=?'), get, function(data) {
			hide_mask();

			if (data.error != 0) {
				$(".get-code").text('��ȡ��֤��');
				$(".get-code").removeClass('get-code-wait');
				$.ui.popup({
					message: data.msg,
	                cancelText: 'ȷ��',
	                cancelOnly: true
				});
			} else {
				$.ui.popup({
					message: '�޸�����ɹ�',
	                cancelText: 'ȷ��',
	                cancelOnly: true,
	                cancelCallback: function () {
	    				redirect('#sign');
                    }
				});
			}
		});
	});
});

/**
 * unload�һ�����ҳ��
 */
function unload_re_regeister() {
	$('#pw-error').text('');
	$('#pw-phone').val('');
	$('#pw-code').val('');
	$('#pw-pwd').val('');
	$('#pw-re-pwd').val('');
	$(".get-code").text('��ȡ��֤��');
	$(".get-code").removeClass('get-code-wait');
}

/**
 * ��ȡ��Ʒ�б���
 */
function goods_info() {
    var class_id = get_param("class_id");
	if (firstLoadGoods != true && class_id == null) {
		return;
	}

	goods_sort_change();
	$.ui.toggleSideMenu();
}

/**
 * ��Ʒ�б���غ���
 */
function goods_sort_change() {
    // shop_info();
    cart_badge();
    localStorage['shop_id']      = 1;
    localStorage['community_id'] = 1;
    // �����ʷpanel��¼
//    $.ui.clearHistory();
	var class_id = get_param("class_id");							// ȡ�÷���id
	if (class_id == null) {
		class_id = 0;
	}
	var get = {
		'shop_id'  : localStorage['shop_id'],
		'class_id' : class_id
	};

	// �ؽ�������
	$('#goods_wrap').html('<div id="goods_all"><div id="goods_scrolling"></div></div>');
	
	load_mask();
	$.getJSON( url('/user/shop/list_goods?&callback=?'), get, function(data) {
		hide_mask();
		
		var html = template.render('goods_tab', data);				// JSON������ģ����Ⱦ
		$('#goods_scrolling').html(html);							// ����Ⱦ���html������ص�panel��
        // �����ͼ۱��ش洢
        localStorage['low_price'] = data.low_price;
        //$("#low_price").text("������ " + data.low_price + " Ԫ����ͻ�����");
        $("#low_price").text("������60����300Ԫ�;�Ʒů��");
		goods_scrolling();
		
		firstLoadGoods = false;
	});
}

/**
 * ��Ʒ�����л�
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
		var html = template.render('goods_tab', data);				// JSON������ģ����Ⱦ

		// �ؽ�������
		var myScroller = $('#goods_all').scroller();
		myScroller.disable();

		$('#goods_all').remove();									// ���¹��� goods_all ������
		$('#goods_wrap').html('<div id="goods_all"><div id="goods_scrolling"></div></div>');

		$('#goods_scrolling').html(html);							// ����Ⱦ���html������ص�panel��

		goods_scrolling();
		hide_mask();
	});
}

/**
 * ����ˢ�º���
 */
function shop_scrolling() {
	var trigger = false;			// ��Ϊ�ж��Ƿ�������������ݵı�־
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
        myScroller.setRefreshContent('����ˢ��');
    }

    function scrollend() {
    	myScroller.setRefreshContent('����ˢ��');
    	if (trigger == false) {
    		this.hideRefresh();
    	}
    }

    function refresh_trigger() {
    	// console.log("refresh_trigger");
    	trigger = true;
    	this.setRefreshContent('�ͷ�����ˢ��');
    }

    var hideClose;
    function refresh_release() {
    	console.log("refresh_release");
    	this.setRefreshContent('����ˢ��');
        var that = this;
    	if (trigger == true) {
        	this.setRefreshContent('����ˢ�¡���');
            clearTimeout(hideClose);
            hideClose = setTimeout(function () {
            	var get = {
            		'shop_id' : localStorage['shop_id']
            	};
    	        // ����ˢ�´���
            	$.getJSON(url('/user/shop?callback=?'), get, function(data) {
                	that.hideRefresh();
                	myScroller.disable();

                	// ���¹���body1_image������
                	$('#body1_image').remove();
                	$('#shop_scrolling').html('<div id="body1_image"></div>');
            		// ��shop_ad�ֶ��е�html����Ƕ�뵽ָ���Ŀ���
            		$('#body1_image').html(data.shop['shop_ad']);

            		// ���°��¼�
        			bind_scrolling();
            	});
            }, 500);
    	} else {
    		this.setRefreshContent('��ȡ��');
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
        myScroller.setRefreshContent('����ˢ��');
        clearTimeout(hideClose);
    }

    function refresh_finish() {
        console.log("refresh-finish");
    }
}

/**
 * ����ˢ�º���
 */
function goods_scrolling() {
	var p = 1;
	var myScroller;
	var is_scrolling = false;
	bind_scrolling();
	// ����ػ����¼�
    function bind_scrolling() {
    	myScroller = $('#goods_all').scroller();
    	myScroller.addInfinite();

	    $.bind(myScroller, "infinite-scroll", infinite_scroll);
		$.bind(myScroller, "infinite-scroll-end", infinite_scroll_end);
	    myScroller.enable();

	    // ����ӹ��ﳵ��ť
	    add2cart();
    }

    function infinite_scroll() {
    	// console.log("infinite-scroll");
    	// �ж��費��Ҫ����ˢ�£�������ݲ���һ����ҳ���ݣ�ֱ�ӷ���
    	if ($('#goods_scrolling .goods').length < goods_page) {
    		this.clearInfinite();
    		return false;
    	}

    	if ($('.infinite').length < 1) {
    		$('#goods_scrolling').append('<div class="infinite" id="infinite" style="height:90px;line-height:60px;text-align:center;font-weight:bold">���ڼ���...</div>');
    		myScroller.scrollToBottom();
    	}
	};
	
	function infinite_scroll_end() {
		if (is_scrolling == true) {
			this.clearInfinite();
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
				'class_id'	: class_id,					// ��ȡ�����еķ���id��
				'p'			: p + 1,
			};

			// ���ÿ�������ȡ����
			$.getJSON( url('/user/shop/list_goods?callback=?'), get, function(data) {
				var html = template.render('goods_tab', data);			// ���󵽵�JSON������ htmlģ����Ⱦ

				$('#goods_scrolling').append(html);						// ����Ⱦ���html������ӵ�div����

				// ����ӹ��ﳵ��ť
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
 * ��������¼�
 */
$.ui.ready(function() {
	$('#search_form').submit(function() {
		var keyword = $('#search_input').val();
		var get		= {
			'shop_id'  : localStorage['shop_id'],
			'keyword' : keyword,
		};

		// ��ʾ������
		$("#search_content").addClass("search_change");
		$('#search_input')[0].blur();

		// ����������ʷ
		set_keyword(keyword);
		update_keyowrd();

		load_mask();
		$.getJSON(url('/user/goods/search?callback=?'), get, function(data) {
			var html = template.render('goods_tab', data);				// JSON������ģ����Ⱦ
			$('#search_results').html(html);							// ����Ⱦ���html������ص�search_results����

			search_scrolling();
			hide_mask();
		});

		return false;
	});
});

/**
 * ����ҳ��
 */
function goods_search() {
	// ���������������
	$('#search_input').val('');
	$('#search_input')[0].focus();
	$("#search_content").removeClass('search_change');

	// ����������ʷ��¼
	update_keyowrd();
}

/**
 * ���������Ĺؼ���
 */
function set_keyword(keyword) {
	var all = new Array;
	var ls = localStorage.getItem('keyword');
	if (ls !== null) {
		all = $.parseJSON(ls);

		// ��ֹ��ͬ�Ĺؼ��ʱ�����
		for (var i = 0; i < all.length; ++i) {
		    if (all[i] == keyword) {
		        all.splice(i, 1);
		    }
		}
		all.unshift(keyword);

		//  ���ֹؼ��ʵĸ���
		if (all.length > 5) {
			all.splice(5, 1);
		}
	} else {
		all[0] = keyword;
	}
	localStorage['keyword'] = JSON.stringify(all);
}

/**
 * ��ȡ�����ؼ���
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
 * ����ؼ�����ʷ��¼
 */
function clear_keyword() {
	localStorage.removeItem('keyword');
}

/**
 * ���¹ؼ����б�
 */
function update_keyowrd() {
	var data = {
		'kws'	: get_keyword()
	};
	var html = template.render('tmp_search_hist', data);
	$('#search_history_list').html(html);

	// �󶨵������
	$('#search_history_list a').unbind('click');
	$('#search_history_list li').click(function() {
		keyword = $(this).text();
		$('#search_input').val(keyword);
		$('#search_form').trigger('submit');
	});
}

/**
 * ������ȡ����ť
 */
function input_cancel(s_input) {
	document.getElementById(s_input).blur();
	$.ui.goBack();
}

/**
 * �������ҳ������ˢ�º���
 */
function search_scrolling() {
	var p = 1;
	var myScroller;
	bind_scrolling();

	// �����������¼�
    function bind_scrolling() {
    	myScroller = $('#search_wrap').scroller();
    	myScroller.addInfinite();

	    $.bind(myScroller, "infinite-scroll", infinite_scroll);
	    myScroller.enable();

		// ����ӹ��ﳵ��ť
	    add2cart();
    }

    function infinite_scroll() {
    	console.log("infinite-scroll");
    	// ��������������һ����ҳ����10��ֱ�ӷ���
    	if ($('#search_results .goods').length < goods_page) {
    		this.clearInfinite();
    		return false;
    	}
    	if ($('#infinite').length > 0) {
    		return false;
    	}

    	var self = this;

    	$('#search_results').append('<div id="infinite" style="height:90px;line-height:60px;text-align:center;font-weight:bold">���ڼ���...</div>');
    	this.scrollToBottom();

    	$.bind(myScroller, "infinite-scroll-end", function () {
    		console.log("infinite-scroll-end");
    		$.unbind(myScroller, "infinite-scroll-end");

    		setTimeout(function() {
            	self.clearInfinite();
            	var get = {
					'shop_id'	: localStorage['shop_id'],
            		'keyword'	: $('#search_input').val(),						// ��ȡ���������������
            		'p'			: p + 1,
            	};
            	$.getJSON(url('/user/goods/search?callback=?'), get, function(data) {
            		var html = template.render('goods_tab', data);				// JSON������ģ����Ⱦ

            		$('#search_results').append(html);							// ����Ⱦ���html������ӵ�search_results����
            		$('#infinite').remove();

        			// ����ӹ��ﳵ��ť
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
 * ��Ʒ����ҳ�溯��
 */
function load_goods_detail() {
	var goods_id = get_param("goods_id");		// ���������е�goods_id
	var get      = {
		'goods_id' : goods_id
	};

	if (goods_id > 0) {
		$('#wrap_goods_info').html('<div id="goods_info_scrolling"></div>');
		load_mask();

		$.getJSON(url('/user/goods/info?callback=?'), get, function(data) {
			var html = template.render('tmp_goods_index', data);
			$('#goods_info_scrolling').html(html);
			// ��add_cart��ǩ�������Ʒ��Ϣ����
			$(".add_cart").attr('goods_id', goods_id);
			$(".add_cart").attr('price', data.goods.price);
			$(".add_cart").attr('name', data.goods.name);
			// ����Ʒȱ��ʱ
			if (data.goods['stock'] == 0) {
				$("#goods_add_wrap").addClass('change_add_cart');
			} else {
				$("#goods_add_wrap").removeClass('change_add_cart');
			}

			// ����������
			$('#goods_info_scrolling').scroller();

			hide_mask();
		});
	}
}

/**
 * ��Ʒ�б�ҳ����ӵ����ﳵ
 */
function add2cart() {
	// ����Ӱ�ť�¼�
	$(".add").unbind('click');
	$(".add").click(function(n) {
		n.stopPropagation();
		var goods_id   = $(this).attr('goods_id');
		var price      = $(this).attr('price');
		var name       = $(this).attr('name');
		var qty        = 1;	// ��ӵ����ﳵʱĬ��Ϊ����Ϊ 1
		var goods_info = {
			'goods_id' : goods_id,
       		'price'    : price,
  			'name'     : name,
       		'qty'      : qty
		};
		// ����Ʒ��ӵ����ﳵ�����洢������
		cart_add(goods_info);
		// ��ȡ���ﳵ����Ʒ��������footer��ʾ
		var total_items = cart_total_items();
		$.ui.updateBadge("#total_items", total_items, 'tr', '#FFF');
		// �ܽ��仯ʵʱ��ʾ
		$(".total_price").text(cart_total_price() + " Ԫ");

		return false;
	});
}

/**
 * ������Ʒҳ�������빺�ﳵ��Ϣ
 */
function load_cart() {

	$('#cart_goods_scrolling').html('<div id="cartgoods_all"></div>');

	var data = new Array;
	// ��ȡcart��ȫ����Ʒ������settle=0
	data['cart'] = cart_dejson(true);
	// �����ش洢�Ĺ��ﳵ��Ϣ��Ⱦ��HTMLģ��
	var html = template.render('tmp_my_cart', data);
	// �����ﳵ�ܶ�洢�ڱ���
	localStorage['total_price'] = cart_total_price();

	$('#cartgoods_all').html(html);
	$('.total_price').text(localStorage['total_price'] + ' Ԫ');
	cart_in_de();
	var low_price = localStorage['low_price'];
	// ��div����ӹ���Ч��
	var myScroller = $('#cartgoods_all').scroller();
}

/**
 * �����������Ʒ����ť�Ĳ���
 */
$.ui.ready(function() {
	$('#settle_goods').click(function() {
	// �ж��Ƿ��¼״̬
	if (typeof(localStorage['phone']) == 'undefined') {
		localStorage['back2cart'] = 1;
		// û��⵽���ش洢��Phone����ת��ע��ҳ��
		redirect("#register");
	} else if ((typeof(localStorage['phone']) != 'undefined') && (typeof(localStorage['user_address']) == 'undefined')) {
		localStorage['back2cart'] = 1;
		// ��⵽�û���ע�ᵫ��δ��д���͵�ַ����ת����ַ��дҳ
		redirect("#position_input");
	} else {
		// �û��ѵ�¼
		redirect("#cart");
	}
	});
});

function cart_confirm() {
	// ��localStorage['cart']�������͵��������Ĺ��ﳵ����
	var get = {
		'cart'		  : decodeURI(cart_http_param()),	// [{"goods_id": ,"qty": }]
		'shop_id'	  : localStorage['shop_id'],
		'total_price' : localStorage['total_price']
	};

	load_mask();
	$.getJSON(url('/user/cart?callback=?'), get, function(data) {
		if(data.shop_close != 1) {
			redirect('#shop_close_notice');
		}

		// ���ͬ��������֮ǰ�Ĺ��ﳵ���ش洢
		// cart_destroy();
		//localStorage.removeItem('coupon');
		// ��ͬ�����cart��Ϣ���±��ش洢
		var cart = cart_update_all(data.items);

		// TODO �첽���������

		$('#cart_goods_scrolling_2').html('<div id="cartgoods_all_2"></div>');
		// �����ش洢��cart��Ϣ���������
		var cart_data = {
			'cart' : cart_dejson()
		};
		var html     = template.render('tmp_my_cart', cart_data);
		// �����ﳵ�ܶ�洢�ڱ���
		localStorage['total_price'] = cart_total_price();

		$('#cartgoods_all_2').html(html);
		// ����Ʒ�б����ӹ���Ч��
		var myScroller = $('#cartgoods_all_2').scroller();


		// TODO ������Ҫ���Ż���Ϣ����ϲ��� cart/index��
		// cart_in_de();
		// �ж��Ƿ��������Ͷ�
		if (localStorage['total_price'] * 10000 < localStorage['low_price'] * 10000) {
			// �����ʱ
			$("#user_address").text(localStorage['user_address']);
			$("#user_phone").text(localStorage['phone']);
			$("#total_type").text('�������ͽ���');
			// ȷ�϶�����ťΪ��ɫ
			$("#confirm_type").attr('class', 'account_goods order_shortage');
			$("#confirm_type").html('<div class="unconfirm_order">ȷ�϶���</div>')
			var subtract = (localStorage['low_price'] * 10000 - localStorage['total_price'] * 10000) / 10000;
			// footer��ʾ���������ͽ���xxԪ��
			$(".total_price").text(subtract + ' Ԫ');
		} else {
			// ���ʱ
			$("#confirm_type").html('<div class="confirm_order">ȷ�϶���</div>')
			$("#user_address").text(localStorage['user_address']);
			$("#user_phone").text(localStorage['phone']);
			$("#total_type").text('�ܽ��:');
			$("#confirm_type").attr('class', 'account_goods');

			var get = {
				'shop_id'     : localStorage['shop_id'],
				'total_price' : localStorage['total_price']		// �ܶ������ж��Ƿ������Ż�����
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
 * ��Ʒ����ҳ����ӵ����ﳵ
 */
$.ui.ready(function() {
	// ��������빺�ﳵ����ť�¼�
	$(".add_cart").click(function(n) {
		n.stopPropagation();
		// ��ȡdiv��ǩ�����Ʒ��Ϣ����
		var goods_id	= $(this).attr('goods_id');
		var price		= $(this).attr('price');
		var name		= $(this).attr('name');
		var qty			= 1;	// ��ӵ����ﳵʱĬ������Ϊ 1
		var goods_info	= {
			'goods_id'  : goods_id,
       		'price'     : price,
  			'name'      : name,
       		'qty'       : qty,
		};
		// ����Ʒ��ӵ����ﳵ�����洢������
		cart_add(goods_info);
		// ���¹��ﳵ����Ʒ��������footer��ʾ
		var total_items = cart_total_items();
		$.ui.updateBadge("#total_items", total_items, 'tr', '#FFF');
		// ��ת�����ﳵҳ��
		redirect('#account_cart');

		return false;
	});
});

/**
 * ���ﳵ��Ʒ�����ı�ʱ�ܶ�Żݵ���Ϣʵʱ����
 */
/*function cart_num_update(id, qty, index) {
	// ��ȡ���ش洢�����ͼ�
	var low_price = window.localStorage['low_price'];
	var get = {
		'id'	: id,
		'qty'	: qty,
	};
	$.getJSON(url('/user/cart/update?callback=?'), get, function(data){
		var t = $(".number");
		window.localStorage['total_price'] = data['total_prices'];		// �ܽ��ش洢
		$(t[index]).text(data['items'][index]['qty']);
		$('.total_price').text(window.localStorage['total_price'] + ' Ԫ');
		$.ui.updateBadge("#total_items", data.total_items, 'tr', '#FFF');
		if (window.localStorage['total_price'] * 100 < low_price * 100) {
			// ���
			var subtract = (low_price * 100 - window.localStorage['total_price'] * 100) / 100;
			// ������ʱfooterΪ��ɫ���ܵ��
			$("#if_full").html('<div class="underfull">����' + subtract + 'Ԫ����</div>');
			// $(".confirm_order").text("����" + subtract + "Ԫ����");
		} else {
			// ����ʱfooter�ɵ���ύ
			$("#if_full").html('<div class="confirm_order">������Ʒ</div>');
			var get = {
				'total_price'	: window.localStorage['total_price'],	// ���ݶ����ܶ�
			};
			$.getJSON(url('/user/coupon?callback=?'), get, function(data) {
				data.total_price = window.localStorage['total_price'];
				var html = template.render('available_coupons', data);	// JSON������ģ����Ⱦ
				$('#shop_cuopons').html(html);							// Ƕ�뵽��ҳ��
			});
			bind_confirm_order();
			// $(".confirm_order").text("������Ʒ");
		}
	});
}*/

/**
 * ʵʱ��ȡ�û�ѡ����Ż�ȯid
 */
$.ui.ready(function() {
	// ѡ���Ż�ȯʱʵʱ�ı��ܶ�
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
					$('.total_price').text(price_coupon + ' Ԫ');
					break;
				case '2':
					present = data['present'];
					$('.total_price').text(total_price + ' Ԫ');
					break;
				case '3':
					discount = data['discount'];
					var price_coupon = (total_price * 10000) * discount / 100000;
					$('.total_price').text(price_coupon + ' Ԫ');
					break;
				default:
					$('.total_price').text(total_price + ' Ԫ');
					break;
			}
		});
		// �Żݺ���ܼ�
		var price_coupon = (total_price * 100 - reduce * 10000) * discount / 10000;
		$('.total_price').text(price_coupon + ' Ԫ');

		return false;
	});
});

/**
 * ���ﳵҳ����Ʒ������������
 */
function cart_in_de() {
	// + ��ť�¼�
	$(".increase").click(function(n) {
		n.stopPropagation();	// ��ֹð��

		// ��ȡ���ﳵ�и���Ʒ��ϢDOM����
		var cart_goods = $(".cart_goods");
		// ��ȡ���ﳵ�и���Ʒ����DOM����
		var goods_num  = $(".number");
		// ��ѯ�ǵڼ���increase��ť
		var i          = $(".increase").index($(this));
		// ��ȡ��increase��ť��������Ʒ��Ϣ
		var goods_id   = $(cart_goods[i]).attr('goods_id');
		var price      = $(cart_goods[i]).attr('price');
		var name       = $(cart_goods[i]).attr('name');
		var goods_info = {
			'goods_id' : goods_id,
			'price'	   : price,
			'name'	   : name,
			'qty'	   : 1,
		};
		// ���±���cart
		cart_add(goods_info);
		// ������Ʒ�������ܽ����ʾ
		var n = cart_item(goods_id);
		$(goods_num[i]).text(($.parseJSON(localStorage['cart'])[n].qty));

		// ȥ���´ι�����Ӱ��
		unsettle_hide_mask(i);
		// ���¹��ﳵ
		cart_badge();
	});

	// - ��ť�¼�
	$(".decrease").click(function(n){
		n.stopPropagation();	// ��ֹð��

		// ��ȡ���ﳵ�и���Ʒ��ϢDOM����
		var cart_goods = $(".cart_goods");
		// ��ȡ���ﳵ�и���Ʒ����DOM����
		var goods_num  = $(".number");
		// ��ѯ�ǵڼ���increase��ť
		var i          = $(".decrease").index($(this));

		// �ж������ǲ���Ϊ1�ˣ����Ϊ1��Ӧ�û����ұߵ�ɾ������
		var old_num	   = $(goods_num[i]).text();
		if (old_num == 1) {
			$('#account_cart .cart_goods').eq(i).css('margin-left','-146px');
			$('.swipe_left').eq(i).show();
			return ;
		}

		// ��ȡ��increase��ť��������Ʒ��Ϣ
		var goods_id   = $(cart_goods[i]).attr('goods_id');
		var price      = $(cart_goods[i]).attr('price');
		var name       = $(cart_goods[i]).attr('name');
		var goods_info = {
			'goods_id' : goods_id,
			'price'	   : price,
			'name'	   : name,
			'qty'	   : -1,
		};
		// ���±���cart
		cart_add(goods_info);
		// ������Ʒ�������ܽ����ʾ
		var n = cart_item(goods_id);
		$(goods_num[i]).text(($.parseJSON(localStorage['cart'])[n].qty));

		// ȥ���´ι�����Ӱ��
		unsettle_hide_mask(i);
		// ���¹��ﳵ
		cart_badge();
	});
}

/**
 * ��������ȷ���ύ
 */
$.ui.ready(function() {
	$('#account_footer').delegate('.confirm_order', 'click', function() {
		var payment       = $('#pay').val();
		var final_price   = $('.total_price').text();
		var coupon_id     = $('#shop_cuopons').val();
		var delivery_time = $('#delivery').val();
		var total_items = cart_total_items();
		var get = {
			'final_price'   : final_price,
			'payment'       : payment,
			'delivery_time' : delivery_time,
			'coupon_id'	    : 0,
			'total_items'   :total_items
		};

		// ��ѡ���Żݺ������ܶ�
		localStorage['total_price'] = get.final_price;


		load_mask();
		$.getJSON(url('/user/order/submit?callback=?'), get, function(data) {
			hide_mask();
			if (data.status == 0) {
				// �����´ι�����Ʒ����settle=1
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
                    cancelText: "ȡ��",
                    doneText: "��¼",
                    doneCallback: function () {
                        redirect('#sign');
                    },
                    cancelOnly: false
                });
			} else {
				$.ui.popup({
					message	: data.msg,
	                cancelText: "ȷ��",
	                cancelOnly: true
				});
			}
		});
	});
});

function load_verify() {
	var flag = 0;
	// �����ύ�ɹ���ָ����ﳵ��ʼͼ��
	$.ui.removeBadge("#total_items");
	// $.ui.updateBadge("#total_items", 0, 'tr', '#FFF');
	// ��ӷ��������水ť
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
 * �û���¼�ɹ���ʾҳ��
 */
function login_success() {
	// ����Ǵӹ��ﳵҳ����ת����
	if (localStorage['back2cart'] == 1) {
		localStorage['back2cart'] = 0;
		// ��ת�ع��ﳵҳ��
		setTimeout(function() {
			$.ui.loadContent('#account_cart', false, false, 'fade');
		}, 3000);
	} else {
		// ����Ǵ�С��ѡ��ҳ����ת����
		// ��ת���̼���ҳ
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
 * �ֻ�ע�Ჽ�� 1
 */
$.ui.ready(function() {
	bind_send_verify();

	// ��֤�뵹��ʱ
	var cnt = 60;
	var curcnt;
	var timeobj;
	function set_Time() {
		// ����
		curcnt--;
		$(".send_verifycode").text('���»�ȡ(' + curcnt + ')');
		if (curcnt < 1 ) {
			clearInterval(timeobj); // ֹͣ��ʱ��
			$(".send_verifycode").text('���»�ȡ');
			$(".send_verifycode").css('background-color','#6AAB37');
			bind_send_verify();
		}
	}

	function bind_send_verify() {
		$(".send_verifycode").click(function() {
			var phone	= $(".phone_left").val();
			var reg		= /^1[3|4|5|8]\d{9}$/;
			// ��֤�ֻ��Ÿ�ʽ
			if (!reg.test(phone)) {
				$("#phone_error").text("������ĺ����ʽ����");
				return;
			}

			$(".send_verifycode").unbind('click');
			var get = {
				'phone'	: phone,
			};

			// ������֤��
			$.getJSON(url('/user/phone/verify?callback=?'), get, function(data) {
				if (data.error != 0) {
					$("#phone_error").text("��֤�뷢��ʧ��");
				}
			});

			curcnt = 60;
			timeobj = setInterval(set_Time, 1000);

			$(".send_verifycode").css('background-color','#a1a7b2');
			$(".send_verifycode").text("���»�ȡ(" + 60 + ")");
		});
	}

	// ������֤��
	$("#verify1").click(function() {
		var verify = $(".verifycode_input").val();
		var get = {
			'verify' : verify,
		};

		if (get.verify == '') {
			$("#phone_error").text("���������֤������");
			return false;
		}
		$.getJSON(url('/user/phone/check_verify?callback=?'), get, function(data) {
			if (data.check_verify == false) {
				$("#phone_error").text("���������֤������");
			} else {
				// ��ת��������֤����
				$.ui.loadContent('#verifyphone', false, false, 'fade');
			}
		});
	});

	$(".verifycode_input").focus(function(){
		$(".verify1").css('background-color','#6AAB37');
		$(".verify2").show();
	});

	// ���X�����֤����
	$(".verify2").click(function() {
		$(".verifycode_input").empty();
	});
});

/**
 * ��֤�ֻ�����������
 */
$.ui.ready(function() {
	// �������
	$(".confirm_code").click(function() {
		var pwd_1 = $("#pwd_1").val();			// ��ȡ�״����������
		var pwd_2 = $("#pwd_2").val();			// ��ȡ�ظ����������

		if (pwd_1 === pwd_2) {
			// ��������һ��ʱ�����������
			var get = {
				'phone'		   : $(".phone_left").val(),
				'password'	   : pwd_1,
				'community_id' : localStorage['community_id']
			};
			$.getJSON(url('/user/user/add_user?callback=?'), get, function(data) {
				// ��¼�ɹ�����ת����ҳ
				if (data.error == 1) {
					$("#pwd_error").text("���ֻ��û���ע��");
				} else {
					// ���ش洢�û��ֻ��ź��û�����С����
					localStorage['phone']          = data.phone;
					localStorage['community_name'] = data.community_name;
					// ��address_id��Ϊ�˷���֮�󵥶�����û���ַ
					localStorage['address_id']     = data.address_id;
					// ��ע���û�������ɵ�ַ��д
					redirect("#position_input");
				}
			});
		} else {
			// �������벻һ�£���ʾ������ʾ
			$("#pwd_error").text("������������벻һ��");
		}
	});
});

function load_verifyphone() {
	// ����ֻ���
	$(".phonenumber").text($(".phone_left").val());
}

/**
 * �ֻ���֤���� 2
 */
$.ui.ready(function() {
	$(".secretcode_input").focus(function(){
		$(".confirm_code").css('background-color','#e74c3c');
	});
});

/**
 * ��¼ҳ��
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
			// �û���֤�ɹ�
			if (data.login == 1) {
				// ����Ǵӹ��ﳵҳ���¼
				if (localStorage['back2cart'] == 1) {
					localStorage['back2cart']    = 0;
					localStorage['shop_id']      = data.shop_id;
					localStorage['community_id'] = data.community_id;
					localStorage['user_address'] = data.address;		// �����̼ҵ�ַshop_address
					localStorage['phone']        = data.phone;
					localStorage['user_id']      = data.user_id;
					redirect('#verify_suc');
				} else {
					// ����Ǵӡ��ҵ��˻���ҳ���¼
					localStorage['shop_id']      = data.shop_id;
					localStorage['community_id'] = data.community_id;
					localStorage['user_address'] = data.address;		// �����̼ҵ�ַshop_address
					localStorage['phone']        = data.phone;
					localStorage['user_id']      = data.user_id;
					// ��ת���û���֤�ɹ�ҳ��
					redirect('#verify_suc');
				}
			} else {
				$("#login_error").text("�û������������");
			}
		});
	});
});

/**
 * �ҵ��Ż�ȯ�б���غ���
 */
function coupon_list() {
	// ��ȡ���ش洢�� shop_id
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
 * �Ż�ȯ����չ��
 */
function coupon_details() {
	$(".coupon_click").click(function() {
		var index = $(".coupon_click").index($(this));
		$('.coupon_hide').eq(index).toggle();
	});
}

/**
 * ���Ż�ȯ���ش洢ΪJSON
 */
function coupon_local(data) {
	var item = new Array;

	for (var i = 0; i < data.coupon.length; i++) {
		item[i] = {
			'coupon_id' : '' + data.coupon[i]['coupon_id'],				// �Ż�ȯid
			'full'		: '' + data.coupon[i]['content']['full'],		// �Ż���ͽ��
			'info'		: '' + data.coupon[i]['content']['info'],		// �Ż�����
			'reduce'	: '' + data.coupon[i]['content']['reduce'],		// ����
			'present'	: '' + data.coupon[i]['content']['present'],		// ����
			'discount'	: '' + data.coupon[i]['content']['discount']		// �ۿ�
		}
	};
	localStorage['coupon'] = JSON.stringify(item);
}

/**
 * �����ش洢���Ż���ϢJSON���룬���ݴ�
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
 * �������麯��
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

			// ���ù�����
			var myScroller = $('#scrolling_ordered').scroller();

			order_cancel();
			hide_mask();
		});
	};

}

/**
 * ��һ���¶�����һ����ǰ�������л�
 */
$.ui.ready(function() {
	$('.order > div').click(function() {
		$(this).addClass("order_item").siblings().removeClass("order_item");
		$(".order_list > div").hide().eq($('.order > div').index(this)).show();
	});
});

/**
 * ���´�������ȡ��������֧����
 */
function order_cancel() {
	//�Ƿ�ȡ�������ĵ�����
	$(".order_status2").unbind('click');

	$(".order_status2").click(function(n) {
		n.stopPropagation(n);
		var text = $(this).text();

		var order_id = $(this).attr('order_id');
		var that = this;

		if (text == 'ȡ��') {
			$.ui.popup({
				title: 'aaa',
				message: "ȷ��ȡ������",
				cancelText: "ȡ��",
				cancelCallback: function () {
					// console.log("cancelled");
				},
				doneText: "ȷ��",
				doneCallback: function () {
					var get = {
						'order_id' : order_id,
					};
					$.getJSON(url('/user/order/cancel?callback=?'), get, function(data) {
						// todo ��Ҫ�ı�״̬���ı�ֵ
					});
				},
				cancelOnly: false
			});
		} else if (text == '����֧��') {
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
 * ��ȡ�û������б�
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

			// ����start����
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
 * ��������ˢ�º���
 */
function orders_scrolling() {
	var p = 1;
	var orders_page = 5;
	var myScroller;
	bind_scrolling();

	// ����ػ����¼�
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

        $('#scrolling_order').append('<div id="infinite" style="height:90px;line-height:60px;text-align:center;font-weight:bold">���ڼ���...</div>');
        this.scrollToBottom();

        $.bind(myScroller, "infinite-scroll-end", function () {
            // console.log("infinite-scroll-end");
            $.unbind(myScroller, "infinite-scroll-end");

            setTimeout(function() {
            	self.clearInfinite();

            	var get = {
        			'type'	 : 1,					// ��ȡ�����еķ���id��
        			'update' : 0,
        			'start'  : start,
            	};

            	// ���ÿ�������ȡ����
            	$.getJSON( url('/user/order/?callback=?'), get, function(data) {
            		var html = template.render('my_order_list', data);

            		$($(".order_list > div")[0]).append(html);

            		// ����start����
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
 * ���ﳵ��ɾ��
 */
$.ui.ready(function() {
	// ���󻬶�
	$("#account_cart").delegate('.cart_goods', 'swipeLeft', function(data) {
		$(this).css('margin-left','-146px');
		$('.swipe_left', $(this)).show();
	});

	// ���һ���
	$("#account_cart").delegate('.cart_goods', 'swipeRight', function(data) {
		$('.swipe_left', $(this)).hide();
		$(this).css('margin-left', '0');
	});

	// �´ι���
	$("#account_cart").delegate('.swipe_left1', 'click', function(data) {
		var goods_id = $(this).attr('goods_id');
		cart_unset_settle(goods_id);

		// ������Ӱ��
		var index = $('.swipe_left1').index($(this));
		$('.swipe_left').eq(index).hide();
		$('.cart_goods').eq(index).css('margin-left', '0');
		unsettle_set_mask(index);

		// ���¹��ﳵ
		cart_badge();
	});

	$("#account_cart").delegate('.swipe_left2', 'click', function(data) {
		var goods_id = $(this).attr('goods_id');
		cart_delete(goods_id);
		// ɾ���ڵ�
		var index = $('.swipe_left2').index($(this));
		$('#cartgoods_all a').eq(index).remove();
		// ���¹��ﳵ
		cart_badge();
	});
});

/**
 * �����´ι�����Ӱ��
 */
function unsettle_set_mask(index) {
	var shortage_pos = $('#cartgoods_all .goods_image').eq(index);
	$('.shortage2', shortage_pos).remove();
	shortage_pos.append('<div class="shortage2">�´�<br />����</div>');
}

/**
 * ȥ���´ι�����Ӱ��
 */
function unsettle_hide_mask(index) {
	var shortage_pos = $('#cartgoods_all .goods_image').eq(index);
	$('.shortage2', shortage_pos).remove();
}
