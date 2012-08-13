<?php
/**
 * JJPHP 控制器基类 中有一些对request和server控制方法
 * @package  comm
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class Controller extends JJBase
{
	/**
	 * 得到get信息
	 * @param $name
	 * @return string || array
	 */
	public function getGet($name = '') {
		if ($name==''||empty($name)) return $_GET;
		return (isset($_GET[$name])) ? $_GET[$name] : '';
	}
	/**
	 * 得到post信息
	 * @param $name
	 * @return string || array
	 */
	public function getPost($name='')
	{
		if($name==''||empty($name)) return $_POST;
		return (isset($_POST[$name]))?$_POST[$name] :'';
	}
	/**
	 * 得到Cookie信息
	 * @param  $name
	 * @return string || array
	 */
	public function getCookie($name='')
	{
		if ($name == ''||empty($name)) return $_COOKIE;
		return (isset($_COOKIE[$name])) ? $_COOKIE[$name] : '';
	}

	/**
	 * 设置cookie的值
	 * @param  string $name    cookie的名称
	 * @param  string $val     cookie值
	 * @param  string $expire  cookie失效时间
	 * @param  string $path    cookie路径
	 * @param  string $domain  cookie作用的主机
	 * @return string
	 */
	public function setCookie($name, $val, $expire = '', $path = '', $domain = '') {
		$expire = (empty($expire)) ? time() + 2592000 : $expire;
		$path   = (empty($path)) ? '/' : $path;
		$domain = (empty($domain)) ?  '': $domain;
		if (empty($domain)) {
			setcookie($name, $val, $expire, $path);
		} else {
			setcookie($name, $val, $expire, $path, $domain);
		}
		$_COOKIE[$name] = $val;
	}

	/**
	 * 删除cookie值
	 * @param  string $name    cookie的名称
	 * @return string
	 */
	public function delCookie($name) {
		$this->setCookie($name, '', time() - 3600);
		$_COOKIE[$name] = '';
		unset($_COOKIE[$name]);
	}

	/**
	 * 检查cookie是否存在
	 * @param  string $name    cookie的名称
	 * @return string
	 */
	public function isSetCookie($name) {
		return isset($_COOKIE[$name]);
	}
	/**
	 * 检查session是否存在
	 * @param  $name
	 */
	public function isSetSession($name)
	{
			if (!session_id()) $this->sessionStart();
			return isset($_SESSION[$name]);
	}
	/**
	 * session_start
	 */
	public function sessionStart()
	{
		session_start();
	}
	/**
	 * Session-设置session值
	 * @param  string $name
	 * @param  string $val
	 */
	public function setSession($name, $val)
	{
		if (!session_id()) $this->sessionStart();
		$_SESSION[$name] = $val;
	}
	/**
	 * Session-删除session值
	 * @param  string $name    
	 */
	public function delSession($name) {

		if (!session_id()) $this->start();
		if (isset($_SESSION[$name])) unset($_SESSION[$name]);
	}
	/**
	 * 得到Session信息
	 * @param  $name
	 * @return string || array
	 */
	public function getSession($name = '') {
		if (!session_id()) $this->sessionStart();
		return (isset($_SESSION[$name])) ? $_SESSION[$name] : '';
	}
	/**
	 * Session-清空session
	 * @return
	 */
	public function clearallSession() {
		if (!session_id()) $this->sessionStart();
		session_destroy();
		$_SESSION = array();
	}


	/**
	 * 得到request信息
	 * @param $name
	 * @return string || array
	 */
	public function getRequest($name='')
	{
		if ($name == ''||empty($name)) return '';
		if (isset($_GET[$name]))return $$_GET[$name];
		if (isset($_POST[$name]))return $_POST[$name];
		if (isset($_SESSION[$name]))return $_SESSION[$name];
		if (isset($_COOKIE[$name]))return $_COOKIE[$name];
		return '';
	}
	/**
	 * 获取SERVICE信息
	 * @param  string $name SERVER的键值名称
	 * @return string
	 */
	public function getRequestService($name = '') {
		if ($name == '') return $_SERVER;
		return (isset($_SERVER[$name])) ? $_SERVER[$name] : '';
	}

	/**
	 *	获取当前正在执行脚本的文件名
	 *  @return string
	 */
	public function getPhpSelf() {
		return $this->getRequestService('PHP_SELF');
	}

	/**
      *获取当前正在执行脚本的文件 
	 *  @return string
	 */
	public function getServiceName() {
		return $this->getRequestService('SERVER_NAME');
	}

	/**
	 *	获取请求时间 
	 *  @return int
	 */
	public function getRequestTime() {
		return $this->getRequestService('REQUEST_TIME');
	}

	/**
	 * 获取useragent信息
	 * @return string
	 */
	public function getUseragent() {
		return $this->getRequestService('HTTP_USER_AGENT');
	}

	/**
	 * 获取URI信息
	 * @return string
	 */
	public function getUri() {
		return $this->getRequestService('REQUEST_URI');
	}

	/**
	 * 判断是否为POST方法提交
	 * @return bool
	 */
	public function isPost() {
		return (strtolower($this->getRequestService('REQUEST_METHOD')) == 'post') ? true : false;
	}

	/**
	 * 判断是否为GET方法提交
	 * @return bool
	 */
	public function isGet() {
		return (strtolower($this->getRequestService('REQUEST_METHOD')) == 'get') ? true : false;
	}

	/**
	 * 判断是否为AJAX方式提交
	 * @return bool
	 */
	public function is_ajax() {
		if ($this->get_service('HTTP_X_REQUESTED_WITH') && strtolower($this->get_service('HTTP_X_REQUESTED_WITH')) == 'xmlhttprequest') return true;
		return false;
	}
	/**
	 * 获取ENV信息
	 * @param  string $name 
	 * @return string||array
	 */
	public function getENV($name = '') {
		if ($name == '') return $_ENV;
		return (isset($_ENV[$name])) ? $_ENV[$name] : '';
	}
	
	/**
	 *	Request-用户用户IP
	 *  @return string
	 */
	public function getUserIp() {
		static $realip;
		if (isset($_SERVER)){
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
				$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
				$realip = $_SERVER["HTTP_CLIENT_IP"];
			} else {
				$realip = $_SERVER["REMOTE_ADDR"];
			}
		} else {
			if (getenv("HTTP_X_FORWARDED_FOR")){
				$realip = getenv("HTTP_X_FORWARDED_FOR");
			} else if (getenv("HTTP_CLIENT_IP")) {
				$realip = getenv("HTTP_CLIENT_IP");
			} else {
				$realip = getenv("REMOTE_ADDR");
			}
		}
		return $realip;
	}
	/**
	 * 获得当前的域名
	 * @return  string
	 */
    public function getDomain()
    {
    	/* 协议 */
		$protocol = (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
		/* 域名或IP地址 */
		if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
		{
			$host = $_SERVER['HTTP_X_FORWARDED_HOST'];
		}
		elseif (isset($_SERVER['HTTP_HOST']))
		{
			$host = $_SERVER['HTTP_HOST'];
		}
		else
		{
			/* 端口 */
			if (isset($_SERVER['SERVER_PORT']))
			{
				$port = ':' . $_SERVER['SERVER_PORT'];
				if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol))
				{
					$port = '';
				}
			}
			else
			{
				$port = '';
			}
			if (isset($_SERVER['SERVER_NAME']))
			{
				$host = $_SERVER['SERVER_NAME'] . $port;
			}
			elseif (isset($_SERVER['SERVER_ADDR']))
			{
				$host = $_SERVER['SERVER_ADDR'] . $port;
			}
		}
		return $protocol . $host;
    }
	/**
	 * 获得网站的URL地址
	 * @return  string
	 */
  public	function siteUrl()
	{
		$php_self=htmlentities(isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
		return $this->getDomain(). substr($php_self, 0, strrpos($php_self, '/'));
	}
	
  /**
   * Send out HTTP headers for JSON.
   */
  public  function sendJsonHeaders() {
   header("Content-Type:application/json; charset=utf-8");   
    header("Cache-Control: no-store");
  }
  /**
   * json_encode
   */
  public function  jsonEncode($result)
  {
  	return json_encode($result);
  }
  /**
   * ajaxReturn
   * @param  $result
   */
  public function ajaxReturn($result)
  {
  	$this->sendJsonHeaders();
  	echo $this->jsonEncode($result);
  }
}