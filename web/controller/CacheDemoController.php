<?php
class CacheDemoController extends Controller
{
	
	/**
	 * http://localhost/JJPHPDemo/index.php/cacheDemo-index
	 */
	public function index()
	{
		$cache=$this->getCache();
		$cache->save('test', "hello JJPHP");
		$this->ajaxReturn($cache->load('test'));
	}
		/**
	 * http://localhost/JJPHPDemo/index.php/cacheDemo-dbCache
	 */
	public function dbCache()
	{
		$cache=$this->getCache(JJCache::DB);
		$cache->save('test', "hello JJPHP");
		$this->ajaxReturn($cache->load('test'));
	}
}