<?php
/**
 * JJPHPOAuth设置
 * @package  config
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */

class JJOAuthConfig{
/********************************************************************************
CREATE TABLE `oauth_codes` (
   `id` int(20) NOT NULL auto_increment,
  `code` varchar(40) NOT NULL,
  `client_id` varchar(20) NOT NULL,
  `user_id` varchar(32) DEFAULT  NULL,  
  `redirect_uri` varchar(200) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `oauth_clients` (
  `id` int(20) NOT NULL auto_increment, 
  `client_id` varchar(20) NOT NULL,
  `client_secret` varchar(20) NOT NULL,
  `redirect_uri` varchar(200)  NULL,
  PRIMARY KEY ( `id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `oauth_tokens` (
   `id` int(20) NOT NULL auto_increment, 
  `oauth_token` varchar(40) NOT NULL,
  `client_id` varchar(20) NOT NULL,
  `user_id` varchar(32) DEFAULT NULL, 
  `expires` int(11) NOT NULL,
  `scope` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;
请重写\web\util\OAuth2Util.php  OAuth2Util类下的checkUser函数
用于判断用户名和密码是否符合 并返回userid
 **********************************************************************/
}