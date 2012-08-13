<?php
/**
 * JJPHP 缓存类的入口类
 * @package  cache
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class JJCache
{
	const DB='Db';
	const MFILE='MFile';
	const SESSION='Session';
	const SFILE='SFile';
	private  $type;
	private  $cache;
	/**
	 * 构造函数
	 * @param $type:Db,MFile,Session,SFile
	 */
	function  __construct($type='')
	{
		if($type==JJCache::DB||$type==JJCache::MFILE||$type==JJCache::SESSION||$type==JJCache::SFILE)
		{
			$this->type=$type;
		}
		else
		{
			$this->type=JJCacheConfig::$type;
		}
		$cacheclass="JJ".$this->type."Cache";
		include_once dirname(__FILE__) . "/driver/JJ".$this->type."Cache.php";
		$this->cache=new $cacheclass;
	}
	/**
	 * 根据KEY得到缓存内容
	 * @param $key
	 * @return Object
	 */
	function load($key) {
		return $this->cache->load($key);
	}

	/**
	 * 根据KEY保存到缓存里
	 * @param $key
	 * @param $value
	 * @param $cachetime
	 */
	function save($key, $value, $cachetime=0)  {
		$this->cache->save($key, $value,$cachetime);
	}
	/**
	 * 清空所有缓存
	 */
	public function clear_all() {
		$this->cache->clear_all();
	}
	/**
	 *根据KEY清空缓存
	 * @param $key
	 */
	public function clear($key) {
		$this->cache->clear($key);
	}

}
