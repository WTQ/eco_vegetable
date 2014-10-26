/**
 * 对localStorage的操作封装
 * 
 * @author 风格独特
 * @versino 1.0, 2014-08-30 
 */

function timestamp() {
	return Math.round(new Date().getTime() / 1000);
}

var storage = (function() {
	var ls = window.localStorage;
	var api = {
		set		: function(key, value, timeout) {
			var type = typeof(value);
			var data;
			
			// 先移除原有的key
			ls.removeItem(key);
			
			if (type == 'object' || type == 'array') {
				data = {
					type 	: type,
					value	: JSON.stringify(value)
				};
			} else {
				data = {
					type	: type,
					value	: value
				};
			}
			
			// 超时设置
			var timeout = arguments[2] || false;
			if (timeout != false) {
				data['expires'] = parseInt(timestamp() + timeout);
			}
			
			ls.setItem(key, JSON.stringify(data));
		},
		
		get		: function(key) {
			var data = ls.getItem(key);
			if (data !== null) {
				try {
					var t_data = JSON.parse(data);
					
					// 超时移除key返回null
					if (typeof(t_data.expires) != 'undefined' && t_data.expires < timestamp()) {
						ls.removeItem(key);
						return null;
					}
					
					// 判断类型是否为object和array
					if (t_data.type == 'object' || t_data.type == 'array') {
						return JSON.parse(t_data.value);
					} else {
						return t_data.value;
					}
				} catch (e) {
					ls.removeItem(key);
					return null;
				}
			} else {
				return null;
			}
		},
		
		remove	: function(key) {
			ls.removeItem(key);
		},
		
		clear	: function() {
			ls.clear();
		}
	};
	
	return api;
})();

// 测试代码
// $.ui.ready(function() {
//	 var data = {
//		 'val'	: 'test'
//	 };
//	 storage.set('hha', data, 500);
//	 var hha = storage.get('hha');
// 	
//	 storage.set('hahha', 'asdfasdf');
//	 alert(storage.get('hahha'));
// 	
//	 alert(JSON.stringify(hha));
// 	
//	 // storage.remove('hha');
// 	
// });
