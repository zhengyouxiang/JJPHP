<?php
/**
 * JJPHP入口类
 * @package  core
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
!defined("COREPATH") && define("COREPATH",dirname(__FILE__));
include_once COREPATH.'/util/JJException.php';
include_once COREPATH.'/comm/JJBase.php';
class JJPHP extends JJBase
{
	/**
	 * 导入comm中的一些类
	 */
	public static function importComm()
	{
		include_once COREPATH.'/comm/Model.php';
		include_once COREPATH.'/comm/Service.php';
		include_once COREPATH.'/comm/Controller.php';
	}
	/**
	 * 导入其他的一些类
	 */
	public static function importOther()
	{
		include_once JJPATH.'/config/JJCacheConfig.php';
       include_once JJPATH.'/config/JJDbConfig.php';
		include_once COREPATH.'/util/JJGlobalFun.php';
       include_once  COREPATH.'/cache/JJCache.php';
	}
	/**
	 * 导入web/contrlib
	 */
	public static function importContrlib()
	{
	
		$contrlib=JJPATH.'/web/contrlib/';
		if(is_dir($contrlib))
		{
		   $listfile=scandir($contrlib);
		  foreach ($listfile as $filename)
	    	{
			  if(!is_dir($filename))include_once $contrlib.$filename;
		   }
		}
	}
	/**
	 * 框架的开始
	 */
	public static function start()
	{
		JJPHP::importOther();
		JJPHP::importComm();
		JJPHP::importContrlib();
		$dispatch=JJPHP::loadDispatch();
		$dispatch->run();
	}

}


