/**
 * 主要的JS文件，主要是基础函数的封装
 *
 * @author lizzyphy
 * @version 1.0 2014-10-24
 */

/**
 * 请求数据端的URL
 */
var site_url =  'http://eco/admin';

/**
 * 生成URL函数
 */
function url(uri) {
	/*if (api_version != '') {
		uri = '/api/' + api_version + uri;
	}*/
	return site_url + uri;
}