<?php
class AdminManageController extends  AdminController
{
	/*
	 * http://localhost/JJPHPDemo/index.php/adminManage-index
	 */
	public function index()
	{
		$this->ajaxReturn('hello admin');
	}
	/*
	 * http://localhost/JJPHPDemo/index.php/adminManage-adminLogin
	 */
	public function adminLogin()
	{
		$this->setSession('admin', 'admin');
		$this->ajaxReturn('login');
	}
}