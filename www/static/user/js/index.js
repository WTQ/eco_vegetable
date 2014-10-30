/**
 * 主要用来处理cordova的事件
 *
 * @author 风格独特
 * @version 1.0 2014-08-30
 */

/**
 * 保存客户端的信息
 */
var client;

/**
 * 两次返回按钮判断的全局变量
 */
var back_exit = false;

var app = {
    initialize: function() {
        this.bindEvents();
    },

    // 绑定设备准备好事件
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
        document.addEventListener('backbutton', this.onBackKeyDown, false);
    },

    // 设备ready时间，此时可以调用cordova的插件
    onDeviceReady: function() {
        // 启用调用appframework
        $.ui.launch();

        // 保存client的信息
        client = {
            version_code    : app_version,
            model           : device.model,
            os_version      : device.version,
            platform        : device.platform,
            uuid            : device.uuid
        };

        // 调用初始化
        app.onAppInit();
        
        // 获取更新信息
        app.onAppUpdate();
    },
    
    // 初始化
    onAppInit: function() {
        var ls_version = storage.get('app_version');
        if (ls_version == null || ls_version != app_version) {
            // 清除所有Localstorage
            storage.clear();
            storage.set('app_version', app_version);
        }
    },
    
 // 获取升级信息
    onAppUpdate: function() {
        // 强制升级提示
        if (storage.get('upgrade_force') == '1') {
            // 强制升级
    		$.ui.popup({
                title: '强制升级提示',
                message: '此版本已不再维护，请升级',
                cancelText: "升级",
                cancelCallback: function () {
                	var upgrade_url = storage.get('upgrade_url');
                   	if (upgrade_url != null) {
						window.open(upgrade_url, '_system');
					}
					navigator.app.exitApp();
                },
                cancelOnly: true
            });
        } else {
        	// 发送初始化信息至服务器
        	setTimeout(function() {
        		rest_post('/user/init', client, function(data) {
        			// 此处检查升级情况
        			if (data.upgrade_type == 1 && storage.get('upgrade_tip') == null) {
        			    // 提示升级
        			    $.ui.popup({
                            title: '升级提示',
                            message: data.upgrade_desc,
                            cancelText: "暂不升级",
                            cancelCallback: function () {
                                // 3天内不提示
                                storage.set('upgrade_tip', '', 3600 * 24 * 3, 'no');
                            },
                            doneText: "升级",
                            doneCallback: function () {
								window.open(data.upgrade_url, '_system');
                            },
                            cancelOnly: false
                        });
        			} else if (data.upgrade_type == 2) {
        			    // 设置强制更新本地变量
        			    storage.set('upgrade_force', '1');
        			    storage.set('upgrade_url', data.upgrade_url);
        			    
        			    // 强制升级
    	        		$.ui.popup({
    	                    title: '强制升级提示',
    	                    message: '此版本已不再维护，请升级',
    	                    cancelText: "升级",
    	                    cancelCallback: function () {
    	                    	var upgrade_url = storage.get('upgrade_url');
    	                       	if (upgrade_url != null) {
    	    						window.open(upgrade_url, '_system');
    	    					}
	    						navigator.app.exitApp();
    	                    },
    	                    cancelOnly: true
    	                });
        			} else {
        				// 暂不需要提示
        			}
        		});
        	}, 3000);
    	}
    },

    // 返回按钮回调事件
    onBackKeyDown : function() {
        // 历史panel数量
        var hist_num = $.ui.history.length; 
        
        // 当历史为0或者为两次返回时，退出APP
        if (hist_num == 0 || back_exit == true) {
            navigator.app.exitApp();
        }
        
        // 历史大于0时，执行返回操作
        if (hist_num > 0) {
            $.ui.goBack();
        }
        
        // 设置返回变量
        back_exit = true;
        setTimeout(function() {
            back_exit = false;
        }, 1000);
    }
};

