<?php
/**
 * JJPHPCache设置
 * @package  config
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class JJCacheConfig
{
	/********************************************************************************
	 * 如果是db者设置下面
	 CREATE TABLE `JJDbCache` (
	 `id` int(10) NOT NULL auto_increment,
	 `k` varchar(255) NOT NULL default '',
	 `v` text NOT NULL default '',
	 `dtime` int(10) NOT NULL default '0',
	 `cachetime` int(10) NOT NULL default '0',
	 PRIMARY KEY  (`id`),
	 KEY `k` (`k`)
	 ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	 **********************************************************************/
	public static $type='SFile';//可以是Db,MFile,Session,SFile
}