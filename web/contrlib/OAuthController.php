<?php
class OAuthController extends Controller
{
	public function before()
	{
		$oauth=$this->getOAuth2();		
		if($this->getAction()!='verify'&&$this->getAction()!='testVerify'&&$this->getAction()!='testIndex'&&!$oauth->verifyJJAccessToken())
		{
			$this->ajaxReturn("Don't have permission to access");
			$this->phpexit();
		}
	}
}