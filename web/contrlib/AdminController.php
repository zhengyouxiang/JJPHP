<?php
class AdminController extends  Controller
{
	public function before()
	{
		if($this->getAction()!='adminLogin'&&!$this->isSetSession('admin'))
		{
			$this->ajaxReturn("Don't have permission to access");
			$this->phpexit();
		}
	}

}