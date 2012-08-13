<?php
/**
 * JJPHP 单个文件缓存类
 * @package  cache
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class JJSFileCache {
	private $filename, $data = array();
	function __construct($filename="") {
		if($filename==""||!isset($filename))
		{
			$filename=dirname(__FILE__)."/../path/simple/jjsfilecache.cache";
		}
		else
		{
			$filename=dirname(__FILE__)."/../path/simple/".$filename.".cache";
		}
		$this->filename = $filename;
		$this->data = unserialize(@file_get_contents($filename)); // @ - file may not exist
	}
	function changefile($filename)
	{
		$filename=dirname(__FILE__)."/../path/".$filename.".cache";
		$this->filename = $filename;
		$this->data = unserialize(@file_get_contents($filename)); // @ - file may not exist
	}
	function load($key) {
		if (!isset($this->data[$key])) {
			return null;
		}
		return $this->data[$key];
	}
	function save($key, $data,$cachetime=0) {
		if (!isset($this->data[$key]) || $this->data[$key] !== $data) {
			$this->data[$key] = $data;
			file_put_contents($this->filename, serialize($this->data), LOCK_EX);
		}
	}
	public function clear_all() {
		return false;
	}
	public function clear($key) {
		return false;
	}

}
