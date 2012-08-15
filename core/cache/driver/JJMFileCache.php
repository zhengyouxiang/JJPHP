<?php
/**
 * JJPHP 多个文件缓存类
 * @package  cache
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class JJMFileCache {
    private $cache_path;
	function __construct() 
	{
		$this->cache_path=JJPATH."/data/cachepath/multi";
	}
	function load($key) {
		$key = $this->get_cache_filename($key);
		/* 缓存不存在的情况 */
		if (!file_exists($key)) return false; 
		$data = file_get_contents($key); //获取缓存
		/* 缓存过期的情况 */
		$filetime = substr($data, 13, 10);
		$pos = strpos($data, ')');
		$cachetime = substr($data, 24, $pos - 24);
		$data  = substr($data, $pos +1);
		if ($cachetime == 0) return @unserialize($data);
		if (time() > ($filetime + $cachetime)) {
			@unlink($key);
			return false; //缓存过期
		}
        return @unserialize($data);
	}
	function save($key, $data, $time = 0) {
		
		 $key = $this->get_cache_filename($key);
		 @file_put_contents($key, '<?php exit;?>' . time() .'('.$time.')' .  serialize($data));
		 clearstatcache();
		 return true;
	}
    private function get_cache_filename($filename) {
		$filename = md5($filename); //文件名MD5加密
		$filename = $this->cache_path .'/'. $filename . '.php';
		return $filename;
	}
	public function clear_all() {
		@set_time_limit(3600);
		$path = opendir($this->cache_path);		
		while (false !== ($filename = readdir($path))) {
			if ($filename !== '.' && $filename !== '..') {
   				@unlink($this->cache_path . '/' .$filename);
			}
		}
		closedir($path);
		return true;
	}
	public function clear($filename) {
		$filename = $this->get_cache_filename($filename);
		if (!file_exists($filename)) return true;
		@unlink($filename);
		return true;
	}
}
