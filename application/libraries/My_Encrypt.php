<?php
/**
 * 修改CI的Encrypt类解密错误时推出的问题
 * 
 * @author 风格独特
 */

class My_Encrypt extends CI_Encrypt
{
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 修改字符串错误时退出时的BUG
	 * 
	 * @see CI_Encrypt::decode()
	 */
	public function decode($string, $key = '')
	{
		$key = $this->get_key($key);

		if (preg_match('/[^a-zA-Z0-9\/\+=]/', $string))
		{
			return FALSE;
		}

		$dec = base64_decode($string);

		if ($this->_mcrypt_exists === TRUE)
		{
			if (($dec = $this->mcrypt_decode($dec, $key)) === FALSE)
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}

		return $dec;
	}
}