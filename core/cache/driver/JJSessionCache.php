<?php
/**
 * JJPHP Session缓存类
 * @package  cache
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class JJSessionCache
{
	function load($key) {
		if (!isset($_SESSION["JJSessionCache"][$key])) {
			return null;
		}
		return $_SESSION["JJSessionCache"][$key];
	}
	
	function save($key, $data,$cachetime=0) {
		$_SESSION["JJSessionCache"][$key] = $data;
	}
	public function clear_all() {
        unset($_SESSION["JJSessionCache"]);
	}
	public function clear($key) {
		unset($_SESSION["JJSessionCache"][$key]);
	}
}
