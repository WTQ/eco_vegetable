/**
 * 实时匹配oninput区域搜索结果
 */

function position_search() {
	var name = $('#zone_input').val();		// 获取搜索框的输入内容
	var get  = {
		'name' : name,
	};
	// 根据输入值实时显示搜索结果
	$.getJSON(url('/user/zone/select_community?callback=?'), get, function(data) {
		var html = template.render('tmp_search_tips', data);
		$('#search_tips').html(html);
	});
	return false;
}


/**
 * 用户地址填写页面
 */
function load_community() {
	// 标题栏填充当前选择小区店铺
	$('#zone_title').text(localStorage['shop_address']);
}

/**
 * 提交用户配送地址
 */
function confirm_address() {
	// 注意区别 shop_address
	var user_address = $("#address_input").val();
	var community_id = localStorage['community_id'];
	var address_id   = localStorage['address_id'];
	var get          = {
		'user_address' : user_address,
		'community_id' : community_id,
		'address_id'   : address_id
	};

	$.getJSON(url('/user/zone/save_community?callback=?'), get, function(data) {
		if (data['error'] === 0) {
			// 地址提交成功，则把该地址本地存储
			localStorage['user_address'] = user_address;
			redirect('#cart');
		} else {
			redirect("#position_input");
		}
	});
}


/**
 * 我的账户panel加载时调用
 */
function my_account() {
	$('#wrap_address').html('<div id="scroller_address" class="accountall"></div>');
	load_mask();
	$.getJSON(url('/user/user/user_info?callback=?'), function(data) {
		var html = template.render('tmp_myaccount', data);
		$("#scroller_address").html(html);
		hide_mask();

		var myScroller = $('#scroller_address').scroller();
	});
}


/**
 * 切换地址panel加载时调用
 */
$.ui.ready(function() {
	$('#address_confirm_change').click(function() {
		var address_id = get_param("address_id");
		var get = {
			'address_id' : address_id,
		};
		$.getJSON(url('/user/zone/change_address?callback=?'), get, function(data) {
			if (data.error == 0) {
				window.localStorage['shop_id'] = data.shop_id;
				redirect('#myaccount');
			} else {
				alert(data.msg);
			}
		});
	});
});

/**
 * 加载position_search时的调用
 */
function load_positon_search() {
	$('#zone_input')[0].focus();
}


/**
 * 输入详细配送地址时，切换footer的button
 */
$.ui.ready(function() {
	$(".address_input").focus(function(){
		// 焦点在地址输入框时，“确认地址”按钮可点击
		$("#address_verify").addClass("verify_address2");
	});
	// “确认地址”按钮事件
	$(".verify_address1").click(function() {
		if ($("#address_verify").hasClass("verify_address2")) {
			// 提交用户配送地址
			confirm_address();
		}
	});
});

/**
 * 发送反馈
 */
$.ui.ready(function() {
	$(".send_suggestion").click(function() {
		var suggestion = $('.suggestion_text').val();
		var select = $('#suggestion_type').val();
		var get = {
				"content" : suggestion,
				"type"    : select,
		};

		$.getJSON(url('/user/ucomment/save?callback=?'), get, function(data) {

		});
		$.ui.loadContent('#submit_sug', false, false, 'fade');
	});
});

/**
 * 发送完反馈跳转到更多页面
 */
function load_sug() {
	setTimeout(function() {
		$.ui.loadContent('#more', false, false, 'fade');
	}, 2000);
}
