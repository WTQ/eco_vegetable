<?php
/**
 * 封装curl对HTTP的请求
 * 
 * @author 风格独特
 * @version 1.1 2014-05-03
 */

class Curl 
{
	/**
	 * 保存Curl连接的资源参数
	 * 
	 * @var resource
	 */
	private $m_ch;
	
	/**
	 * 保存请求的URL
	 * 
	 * @var string
	 */
	private $m_url = '';
	
	/**
	 * 是否返回响应的HTTP响应头
	 * 
	 * @var boolen
	 */
	private $m_header = FALSE;
	
	/**
	 * 构造函数
	 * 
	 * @param string $url
	 */
	public function __construct($url = '', $timeout = 15) {
		if (trim($url) != '') {
			$this->m_url = $url;
		}
		
		// 初始化m_ch
		$this->m_ch = curl_init();
		
		// 设置超时时间
		$this->setopt(CURLOPT_CONNECTTIMEOUT, $timeout);
		
		// 使执行curl_exec正确是返回http响应内容
		$this->setopt(CURLOPT_RETURNTRANSFER, TRUE);
		
		// 开启HTTP请求头输出
		// $this->setopt(CURLINFO_HEADER_OUT, TRUE);
	}
	
	/**
	 * 设置Curl的选项
	 * 
	 * @param string $option 选项
	 * @param string $value 值
	 */
	public function setopt($option, $value) {
		if (!curl_setopt($this->m_ch, $option, $value)) {
			die('setopt失败');
		}
	}
	
	/**
	 * 设置HTTP请求头
	 * 
	 * @param array $arrHeader
	 */
	public function set_header(array $arrHeader) {
		$this->setopt(CURLOPT_HTTPHEADER, $arrHeader);
	}
	
	/**
	 * 采用GET发送请求
	 * 
	 * @param string $url
	 * @return multitype:string array
	 */
	public function get($url = NULL) {
		// 设置URL
		if ($url !== NULL) {
			$this->m_url = $url;
		}
		$this->setopt(CURLOPT_URL,		$this->m_url);
		
		$this->setopt(CURLOPT_HTTPGET,	TRUE);
		
		if ($this->m_header == TRUE) {
			$this->setopt(CURLOPT_HEADER,	TRUE);
			$content = curl_exec($this->m_ch);
			return $this->parse_content($content);
		}

		$this->setopt(CURLOPT_HEADER,	FALSE);
		$content = curl_exec($this->m_ch);
		return $content;
	}
	
	/**
	 * 采用POST发送请求
	 * 
	 * @param mixed $data
	 * @param string $url
	 * @return multitype:string array
	 */
	public function post($data, $url = NULL) {
		if (is_array($data)) {
			$data = http_build_query($data);
		}

		// 设置URL
		if ($url !== NULL) {
			$this->m_url = $url;
		}
		$this->setopt(CURLOPT_URL, 			$this->m_url);
		
		$this->setopt(CURLOPT_POST,			TRUE);
		$this->setopt(CURLOPT_POSTFIELDS,	$data);
		
		if ($this->m_header == TRUE) {
			$this->setopt(CURLOPT_HEADER,	TRUE);
			$content = curl_exec($this->m_ch);
			return $this->parse_content($content);
		}

		$this->setopt(CURLOPT_HEADER,	FALSE);
		$content = curl_exec($this->m_ch);
		return $content;
	}
	
	public function set_ssl() {
		$this->setopt(CURLOPT_SSL_VERIFYHOST,	FALSE);
		$this->setopt(CURLOPT_SSL_VERIFYPEER,	FALSE);
	}
	
	/**
	 * 需不需要输出HTTP响应头
	 * 
	 * @param boolen $header
	 */
	public function out_header($header = TRUE) {
		if ($header == TRUE) {
			$this->m_header = TRUE;
		}
	}
	
	/**
	 * 错误信息调用
	 * 
	 * @return string
	 */
	public function error() {
		return curl_error($this->m_ch);
	}
	
	/**
	 * 获取请求的信息
	 * 
	 * @return array
	 */
	public function getinfo($opt = NULL) {
		if ($opt === NULL) {
			return curl_getinfo($this->m_ch);
		} else {
			return curl_getinfo($this->m_ch, $opt);
		}
	}
	
	/**
	 * 解析HTTP响应结果
	 * 
	 * @param string $httpContent
	 * @return array HTTP响应头内容
	 */
	private function parse_content($httpContent) {
		$array = array(
			'header'	=>	'',
			'content'	=>	'',
		);
		if (preg_match('/(.*?)(?:\r\n\r\n|\n\n)(.*)/s', $httpContent, $match)) {
			$array['header'] = $match[1];
			$array['content'] = $match[2];
		}
		return $array;
	}
}
