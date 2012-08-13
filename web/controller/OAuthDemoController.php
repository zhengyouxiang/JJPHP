<?php
class OAuthDemoController extends  OAuthController
{
	var $curl;
	public function  __construct()
	{
		parent::__construct();
		$this->curl=$this->getLib('curl');
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/OAuthDemo
	 * "Don't have permission to access"
	 */
	public function index()
	{
		echo  "hello JJPHP";
	}
	/**
	 *http://localhost/JJPHPDemo/index.php/OAuthDemo-verify
	 * {"error":"invalid_client"}
	 */
	public function verify()
	{
		$this->getOAuth2()->grantJJAccessToken();
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/OAuthDemo-testVerify
	 * "{\"access_token\":\"469b475a8e3d5aa30d91d2f0ae69e2fb\",\"user_id\":1,\"scope\":null}"
	 */
	public function  testVerify()
	{
		$data=array("client_id"=>'1000','client_secret'=>'1000','username'=>'jjphp','password'=>'jjphp');
		$url="http://localhost/JJPHPDemo/index.php/OAuthDemo-verify";
		$this->ajaxReturn($this->curl->post($url,$data));
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/OAuthDemo-testIndex
	 * "hello JJPHP"
	 */
	public function testIndex()
	{
		$data=array("access_token"=>'469b475a8e3d5aa30d91d2f0ae69e2fb','user_id'=>'1');
		$url="http://localhost/JJPHPDemo/index.php/OAuthDemo-index";
		$this->ajaxReturn($this->curl->post($url,$data));
	}
}