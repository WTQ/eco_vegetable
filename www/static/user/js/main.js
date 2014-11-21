/**
 * 主要的JS文件，主要是基础函数的封装
 *
 * @author 风格独特
 * @version 1.0 2014-05-18
 */

/**
 * APP版本号
 */
var app_version = 'v0.2.1';

/**
 * API 版本号
 */
var api_version = 'v0.1';//

/**
 * 请求数据端的URL
 */
//var site_url = 'http://eco';
 var site_url = 'http://121.41.50.149';
/**
 * 商品分页数
 */
var goods_page = 10;

/**
 * 生成URL函数
 */
function url(uri) {
	return site_url + uri;
}

/**
 * Rest请求默认超时时间
 */
var rest_timeout = 15000;

/**
 * panel跳转函数
 */
function redirect(panel, newtab, goback) {
	newtab = arguments[1] || false;
	goback = arguments[2] || false;

	$.ui.loadContent(panel, newtab, goback, 'none');
}

/**
 * 提取URI中的参数值
 * 参数的格式是  #main/name1/value1/name2/value2
 */
function get_param(name) {
	var reg = new RegExp("#(.+)\/" + name + "\/(.+?)(\/|$)");
	var url = "" + window.location;
	var r = url.match(reg);
	if (r != null) {
		return r[2];
	} else {
		return null;
	}
}

/**
 * 绑定a的点击操作，使相通panel切换，当参数不同时panel能够刷新
 */
$.ui.ready(function() {
	$('nav a').click(function() {
		var reg = new RegExp("(#.+?)(\/|$)");
		target = $(this).attr('href');
		if (target == null) {
			return;
		}
		r = target.match(reg);
		if (r == null) {
			return;
		}

		what = $.query(r[1]).get(0);

		if (what === $.ui.activeDiv) {
			var old_target = "" + window.location;
			old_target = old_target.substr(old_target.indexOf('#'));
			if (old_target !== target) {
				window.location = target;
				sort_change();
			}
		}
	});
});

/**
 * 默认初始化的操作
 */
$.ui.ready(function() {
	// 设置sidemenu的宽度
	$.ui.setLeftSideMenuWidth("180px");
	// 设置sidemenu在tablet上默认关闭
	$.ui.disableSplitView();
	// 去掉header的滑动效果
	$.ui.animateHeaders = false;
	// 修改默认的data-transition效果
	$.ui.availableTransitions["default"] = $.ui.noTransition;
	// 关闭OStheme
	$.ui.useOSThemes = false;

	load_entry();
});

/**
 * 加载入口页面时的跳转
 */
function load_entry() {
	// 判断初始化panel的加载
		redirect('#index');

}

/**
 * 显示Mask层
 */
function load_mask() {
	//$(id).append('<div class="load_mask"></div>');
	//$.ui.blockUI(.1);
	$.ui.showMask("Loading...");
}

/**
 * 隐藏Mask层
 */
function hide_mask() {
	//$.ui.unblockUI();
	$.ui.hideMask();
}

/**
 * Rest ajax函数
 */
function rest_ajax(ajax_type, uri, data, success, error, timeout) {
	var success	= arguments[3] || false;
	var error	= arguments[4] || false;
	// 默认15S超时时间
	var timeout	= arguments[5] || rest_timeout;

	$.ajax({
		type		: ajax_type,
		url			: url(uri),
		data		: data,
		success		: function(data) {
			if (success != false) {
				success(data);
			}
		},
		error		: function(data) {
			if (error != false) {
				error(data);
			} else {
				// alert(data.responseText);
				// alert(JSON.stringify(data));return;
				// alert('连接超时，请检查当前网络状况');
			}
		},
		dataType	: 'json',
		timeout		: timeout
	});
}

/**
 * Rest get函数
 */
function rest_get(uri, data, success, error, timeout) {
	rest_ajax('get', uri, data, success, error, timeout);
}

/**
 * Rest post函数
 */
function rest_post(uri, data, success, error, timeout) {
	rest_ajax('post', uri, data, success, error, timeout);
}

/**
 * 升级提示部分
 */
$.ui.ready(function() {
	$('#check-update').click(function() {
		load_mask();
		rest_post('/user/init', client, function(data) {

			// 此处检查升级情况
			if (typeof(data.upgrade_type) != 'undefined' && data.upgrade_type != 0) {
			    // 提示升级
			    $.ui.popup({
	                title: '升级提示',
	                message: data.upgrade_desc,
	                cancelText: "暂不升级",
	                doneText: "升级",
	                doneCallback: function () {
						window.open(data.upgrade_url, '_system');
	                },
	                cancelOnly: false
	            });
			} else {
				// 暂不需要提示
				 $.ui.popup({
	                title: '升级提示',
	                message: '已经是最新版本',
	                cancelText: "确定",
	                cancelOnly: true
	            });
			}
			hide_mask();
		});
	});
})

