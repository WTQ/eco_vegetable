/**
 * ��Ҫ��JS�ļ�����Ҫ�ǻ��������ķ�װ
 *
 * @author ������
 * @version 1.0 2014-05-18
 */

/**
 * APP�汾��
 */
var app_version = 'v0.1.1';

/**
 * API �汾��
 */
var api_version = 'v0.1';//

/**
 * �������ݶ˵�URL
 */
//var site_url = 'http://eco.te168.cn';
 var site_url = 'http://eco';
/**
 * ��Ʒ��ҳ��
 */
var goods_page = 10;

/**
 * ����URL����
 */
function url(uri) {
	return site_url + uri;
}

/**
 * Rest����Ĭ�ϳ�ʱʱ��
 */
var rest_timeout = 15000;

/**
 * panel��ת����
 */
function redirect(panel, newtab, goback) {
	newtab = arguments[1] || false;
	goback = arguments[2] || false;

	$.ui.loadContent(panel, newtab, goback, 'none');
}

/**
 * ��ȡURI�еĲ���ֵ
 * �����ĸ�ʽ��  #main/name1/value1/name2/value2
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
 * ��a�ĵ��������ʹ��ͨpanel�л�����������ͬʱpanel�ܹ�ˢ��
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
 * Ĭ�ϳ�ʼ���Ĳ���
 */
$.ui.ready(function() {
	// ����sidemenu�Ŀ��
	$.ui.setLeftSideMenuWidth("180px");
	// ����sidemenu��tablet��Ĭ�Ϲر�
	$.ui.disableSplitView();
	// ȥ��header�Ļ���Ч��
	$.ui.animateHeaders = false;
	// �޸�Ĭ�ϵ�data-transitionЧ��
	$.ui.availableTransitions["default"] = $.ui.noTransition;
	// �ر�OStheme
	$.ui.useOSThemes = false;

	load_entry();
});

/**
 * �������ҳ��ʱ����ת
 */
function load_entry() {
	// �жϳ�ʼ��panel�ļ���
		redirect('#index');

}

/**
 * ��ʾMask��
 */
function load_mask() {
	//$(id).append('<div class="load_mask"></div>');
	//$.ui.blockUI(.1);
	$.ui.showMask("Loading...");
}

/**
 * ����Mask��
 */
function hide_mask() {
	//$.ui.unblockUI();
	$.ui.hideMask();
}

/**
 * Rest ajax����
 */
function rest_ajax(ajax_type, uri, data, success, error, timeout) {
	var success	= arguments[3] || false;
	var error	= arguments[4] || false;
	// Ĭ��15S��ʱʱ��
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
				// alert('���ӳ�ʱ�����鵱ǰ����״��');
			}
		},
		dataType	: 'json',
		timeout		: timeout
	});
}

/**
 * Rest get����
 */
function rest_get(uri, data, success, error, timeout) {
	rest_ajax('get', uri, data, success, error, timeout);
}

/**
 * Rest post����
 */
function rest_post(uri, data, success, error, timeout) {
	rest_ajax('post', uri, data, success, error, timeout);
}

/**
 * ������ʾ����
 */
$.ui.ready(function() {
	$('#check-update').click(function() {
		load_mask();
		rest_post('/user/init', client, function(data) {

			// �˴�����������
			if (typeof(data.upgrade_type) != 'undefined' && data.upgrade_type != 0) {
			    // ��ʾ����
			    $.ui.popup({
	                title: '������ʾ',
	                message: data.upgrade_desc,
	                cancelText: "�ݲ�����",
	                doneText: "����",
	                doneCallback: function () {
						window.open(data.upgrade_url, '_system');
	                },
	                cancelOnly: false
	            });
			} else {
				// �ݲ���Ҫ��ʾ
				 $.ui.popup({
	                title: '������ʾ',
	                message: '�Ѿ������°汾',
	                cancelText: "ȷ��",
	                cancelOnly: true
	            });
			}
			hide_mask();
		});
	});
})

