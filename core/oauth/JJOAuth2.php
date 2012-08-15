<?php
/**
 * JJPHPOAuth类
 * @package  oauth
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
include_once dirname(__FILE__) . "/lib/OAuth2.php";
include_once  dirname(__FILE__) . "/../dao/NotORM.php";
include_once  JJPATH . "/web/util/OAuth2Util.php";
class JJOAuth2 extends  OAuth2
{
	private $db;
	/**
	 * Overrides OAuth2::__construct().
	 */
	public function __construct() {
		parent::__construct();
		$this->db=new NotORM();
	}
	/**
	 * Handle PDO exceptional cases.
	 */
	private function handleException($e) {
		echo "Database error: " . $e->getMessage();
		exit;
	}
	/**
	 * Little helper function to add a new client to the database.
	 * Do NOT use this in production! This sample code stores the secret
	 * in plaintext!
	 * @param $client_id
	 *   Client identifier to be stored.
	 * @param $client_secret
	 *   Client secret to be stored.
	 * @param $redirect_uri
	 *   Redirect URI to be stored.
	 */
	public function addClient($client_id, $client_secret, $redirect_uri) {
		$data=array(
                    "client_id"=>$client_id,
                    "client_secret"=>$client_secret,
                    "redirect_uri"=>$redirect_uri
		);
		$this->db->oauth_clients()->insert($data);
	}
	/**
	 * Implements OAuth2::checkClientCredentials().
	 * Do NOT use this in production! This sample code stores the secret
	 * in plaintext!
	 */
	protected function checkClientCredentials($client_id, $client_secret = NULL) {
		$result=$this->db->oauth_clients('client_id',$client_id)->fetchOneData();
		if ($client_secret === NULL)return False;
		if($result==NULL||!isset($result))return False;
		if($result["client_secret"] ==$client_secret)
		{
			return True;
		}
		return False;
	}
	/**
	 * Implements OAuth2::getRedirectUri().
	 */
	protected function getRedirectUri($client_id) {
		$result=$this->db->oauth_clients('client_id',$client_id)->fetchOneData();
		if ($result === FALSE)
		return FALSE;
		return isset($result["redirect_uri"]) && $result["redirect_uri"] ? $result["redirect_uri"] : NULL;
	}
	/**
	 * Implements OAuth2::getAccessToken().
	 */
	protected function getAccessToken($oauth_token) {
		$result=$this->db->oauth_tokens('oauth_token',$oauth_token)->fetchOneData();
		return $result !== FALSE ? $result : NULL;
	}
	/**
	 * Implements OAuth2::setAccessToken().
	 */
	protected function setAccessToken($oauth_token, $client_id, $expires,$user_id=null, $scope = NULL) {
		$data=array(
		"oauth_token"=>$oauth_token,
		"client_id"=>$client_id,
		"expires"=>$expires,
		"user_id"=>$user_id,
		"scope"=>$scope
		);
		$this->db->oauth_tokens()->insert($data);
	}
	/**
	 * Overrides OAuth2::getSupportedGrantTypes().
	 */
	protected function getSupportedGrantTypes() {
		return array(
		OAUTH2_GRANT_TYPE_AUTH_CODE,
		);
	}
	/**
	 * Overrides OAuth2::getAuthCode().
	 */
	protected function getAuthCode($code) {
		$result=$this->db->oauth_codes('code',$code)->fetchOneData();
		return $result !== NULL ? $result : NULL;
	}
	/**
	 * Overrides OAuth2::setAuthCode().
	 */
	protected function setAuthCode($code, $client_id, $redirect_uri, $expires,$user_id=NULL, $scope = NULL) {
		$data=array(
		"code"=>$code,
		"client_id"=>$client_id,
		"redirect_uri"=>$redirect_uri,
		"expires"=>$expires,
		"user_id"=>$user_id,
		"scope"=>$scope
		);
		$this->db->oauth_codes()->insert($data);
	}
	/**
	 * 简单的认证方式post去用户名和密码grantJJAccessToken
	 * @see core/oauth/lib/OAuth2::grantAccessToken()
	 */
	public function grantJJAccessToken() {
		$filters = array(
	  "client_id"=>array("flags" => FILTER_REQUIRE_SCALAR),
	  "client_secret"=>array("flags" => FILTER_REQUIRE_SCALAR),
      "username" => array("flags" => FILTER_REQUIRE_SCALAR),
      "password" => array("flags" => FILTER_REQUIRE_SCALAR),
	  "scope" => array("flags" => FILTER_REQUIRE_SCALAR),
	  "lifetime"=> array("flags" => FILTER_REQUIRE_SCALAR)
		);
		$input = filter_input_array(INPUT_POST, $filters);
		if ($this->checkClientCredentials($input["client_id"], $input["client_secret"]) === FALSE)
		$this->errorJsonResponse(OAUTH2_HTTP_BAD_REQUEST, OAUTH2_ERROR_INVALID_CLIENT);
		if (!$input["username"] || !$input["password"])
		$this->errorJsonResponse(OAUTH2_HTTP_BAD_REQUEST, OAUTH2_ERROR_INVALID_REQUEST, 'Missing parameters. "username" and "password" required');
		$stored = $this->checkUserCredentials($input["client_id"],$input["username"], $input["password"]);
		if ($stored === FALSE)
		$this->errorJsonResponse(OAUTH2_HTTP_BAD_REQUEST, OAUTH2_ERROR_INVALID_GRANT,'error username or password');
		$input['user_id']=$stored;
		if (!$input["scope"])
		$input["scope"] = NULL;
		if (!$input["lifetime"]||!is_numeric($input["lifetime"]))
		$input["lifetime"] = 0;
		$token = array(
          "access_token" => $this->genAccessToken(),
          "user_id"=>$input['user_id'],
          "scope" => $input["scope"]
		);
		if($this->checkCidAndUid($input["client_id"], $input['user_id']))
		{
			if($input["lifetime"]==0)
			{
				$this->setAccessToken($token["access_token"],$input["client_id"], 0,$input['user_id'], $input["scope"]);
			}
			else
			{
				$this->setAccessToken($token["access_token"],$input["client_id"], time()+$input["lifetime"],$input['user_id'], $input["scope"]);
			}
		}
		else
		{
			$this->updateToken($input["client_id"], $input['user_id'],$token["access_token"],$input["lifetime"],$input["scope"]);
		}
		$this->sendJsonHeaders();
		echo json_encode($token);
	}
  /**
   * 更新Token.setJJRefreshToken
   * @param  $refresh_token 
   * @param  $lifetime
   * @param  $scope
   */
	public function setJJRefreshToken($refresh_token,$lifetime=0,$scope = NULL) {
		$access_token= $this->genAccessToken();
		$oldtoken=$db->oauth_tokens("oauth_token",$refresh_token)->fetch();
		$oldtoken['oauth_token']=$access_token;
		if($lifetime==0||!is_numeric($lifetime))
		{
			$oldtoken['expires']=0;
		}else
		{
			$oldtoken['expires']=time()+$lifetime;
		}
		if($scope!=NULL&&isset($scope))
		{
			$oldtoken['scope']=$scope;
		}
		$oldtoken->update();
	}
	/**
	 * access_token和user_id根据认证是否有权限verifyJJAccessToken
	 * @param  $scope
	 * @param  $exit_not_present
	 * @param  $exit_invalid
	 * @param  $exit_expired
	 * @param  $exit_scope
	 * @param  $realm
	 */
	public function verifyJJAccessToken($scope = NULL, $exit_not_present = TRUE, $exit_invalid = TRUE, $exit_expired = TRUE, $exit_scope = TRUE, $realm = NULL)
	 {
		if(!array_key_exists('access_token', $_POST))return FALSE;
		if(!array_key_exists('user_id', $_POST))return FALSE;
		$access_token=$_POST['access_token'];
		$user_id=$_POST['user_id'];
		$token = $this->getAccessTokenBysid($access_token,$user_id);
		if ($token === NULL)
		return $exit_invalid ? $this->errorWWWAuthenticateResponseHeader(OAUTH2_HTTP_UNAUTHORIZED, $realm, OAUTH2_ERROR_INVALID_TOKEN, 'The access token provided is invalid.', NULL, $scope) : FALSE;
		if($token["expires"]!=0&&time() > $token["expires"])
		{
			return $exit_expired ? $this->errorWWWAuthenticateResponseHeader(OAUTH2_HTTP_UNAUTHORIZED, $realm, OAUTH2_ERROR_EXPIRED_TOKEN, 'The access token provided has expired.', NULL, $scope) : FALSE;
		}
		return TRUE;
	}
	/**
	 * 根据$client_id和$user_id判断是否已经存在
	 * @param  $client_id
	 * @param  $user_id
	 */
	protected function checkCidAndUid($client_id,$user_id)
	{
		$result=$this->db->oauth_tokens(array('client_id'=>$client_id,'user_id'=>$user_id))->fetchOneData();
		return $result == NULL ? TRUE : FALSE;
	}
	/**
	 * 更新Token
	 * @param  $client_id
	 * @param  $user_id
	 * @param  $refresh_token
	 * @param  $lifetime
	 * @param  $scope
	 */
	protected function updateToken($client_id,$user_id,$refresh_token,$lifetime=0,$scope = NULL)
	{
		$oldtoken=$this->db->oauth_tokens(array('client_id'=>$client_id,'user_id'=>$user_id))->fetch();
		$oldtoken['oauth_token']=$refresh_token;
		if($lifetime==0||!is_numeric($lifetime))
		{
			$oldtoken['expires']=0;
		}else
		{
			$oldtoken['expires']=time()+$lifetime;
		}
		if($scope!=NULL&&isset($scope))
		{
			$oldtoken['scope']=$scope;
		}
		$oldtoken->update();
	}
	/**
	 * 根据$oauth_token和$user_id得到Token
	 * @param  $oauth_token
	 * @param  $user_id
	 */
	protected function getAccessTokenBysid($oauth_token,$user_id)
	{
		$result=$this->db->oauth_tokens(array('oauth_token'=>$oauth_token,'user_id'=>$user_id))->fetchOneData();
		return $result !== NULL ? $result : NULL;
	}
	/**
	 * (non-PHPdoc)
	 * @see core/oauth/lib/OAuth2::checkUserCredentials()
	 */
	protected function checkUserCredentials($client_id, $username, $password) {
		return OAuth2Util::checkUser($client_id, $username, $password);
	}
}


