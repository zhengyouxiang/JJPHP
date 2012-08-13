<?php
/**
 * JJPHP OAuth2Util类
 * @package  webutil
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class OAuth2Util extends JJBase
{
	public static function checkUser($client_id, $username, $password)
	{
		if($username==$password)
		{
			return 1;
		}
		return False;
	}
}