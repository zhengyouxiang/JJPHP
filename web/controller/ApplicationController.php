<?php
class ApplicationController extends Controller
{
	public $appmode;
	public function  __construct()
	{
		parent::__construct();
		$this->appmode=$this->getModel("application");
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-getApplication?id=2
	 * {"id":"2","author_id":"11","maintainer_id":null,"title":"JUSH","web":"http:\/\/jush.sourceforge.net\/","slogan":"JavaScript Syntax Highlighter"}
	 */
	public function getApplication()
	{
		if(key_exists("id", $_GET))
		{
			$id=$this->getGet('id');
			$app=$this->appmode->getDetailById($id);
			$this->ajaxReturn($app);
		}
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-toString
	 * ["1","2","3","4"]
	 */
	public function toString()
	{
		$app=$this->appmode->tostring();
		$this->ajaxReturn($app);
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-wherein
	 * ["0","1","2","3"]
	 */
	public function wherein()
	{
		$app=$this->appmode->wherein();
		$this->ajaxReturn($app);
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-where
	 *["4","1, 2, 3","1, 2, 3","1, 2","","1, 2, 3, 4","1, 3","3"]
	 */
	public function where()
	{
		$app=$this->appmode->where();
		$this->ajaxReturn($app);
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-limit
	 * [{"id":"1","author_id":"11","maintainer_id":"11","title":"Adminer","web":"http:\/\/www.adminer.org\/","slogan":"Database management in single PHP file"},{"id":"2","author_id":"11","maintainer_id":null,"title":"JUSH","web":"http:\/\/jush.sourceforge.net\/","slogan":"JavaScript Syntax Highlighter"},{"id":"3","author_id":"12","maintainer_id":"12","title":"Nette","web":"http:\/\/nettephp.com\/","slogan":"Nette Framework for PHP 5"}
	 */
	public function limit()
	{
		$app=$this->appmode->limit();
		$this->ajaxReturn($app);
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-searchOrder
	 * [{"id":"1","author_id":"11","maintainer_id":"11","title":"Adminer","web":"http:\/\/www.adminer.org\/","slogan":"Database management in single PHP file"},{"id":"4","author_id":"12","maintainer_id":"12","title":"Dibi","web":"http:\/\/dibiphp.com\/","slogan":"Database Abstraction Library for PHP 5"},{"id":"2","author_id":"11","maintainer_id":null,"title":"JUSH","web":"http:\/\/jush.sourceforge.net\/","slogan":"JavaScript Syntax Highlighter"},{"id":"3","author_id":"12","maintainer_id":"12","title":"Nette","web":"http:\/\/nettephp.com\/","slogan":"Nette Framework for PHP 5"}]
	 */
	public function searchOrder()
	{
		$app=$this->appmode->searchOrder();
		$this->ajaxReturn($app);
	}
	/**
	 *  http://localhost/JJPHPDemo/index.php/application-basic
	 *[{"apptitle":"Adminer","authorname":"Jakub Vrana","tagname":["PHP","MySQL"]},{"apptitle":"JUSH","authorname":"Jakub Vrana","tagname":["JavaScript"]},{"apptitle":"Nette","authorname":"David Grudl","tagname":["PHP"]},{"apptitle":"Dibi","authorname":"David Grudl","tagname":["PHP","MySQL"]}]
	 */
	public function basic()
	{
		$app=$this->appmode->basic();
		$this->ajaxReturn($app);
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-findone
	 * ["PHP"]
	 */
	public function findone()
	{
		$app=$this->appmode->findone();
		$this->ajaxReturn($app);
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-aggregation
	 *["Adminer: 2 tag(s)","JUSH: 1 tag(s)","Nette: 1 tag(s)","Dibi: 2 tag(s)"]
	 */
	public function	aggregation()
	{
		$app=$this->appmode->aggregation();
		$this->ajaxReturn($app);
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-fetchPairs
	 * {"1":"Adminer","4":"Dibi","2":"JUSH","3":"Nette"}
	 */
	public function		fetchPairs()
	{
		$app=$this->appmode->fetchPairs();
		$this->ajaxReturn($app);
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-union
	 * ["23","22","21","4","3","2","1"]
	 */
	public function union()
	{
		$app=$this->appmode->union();
		$this->ajaxReturn($app);
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-arrayOffset
	 *"1"
	 */
	public function arrayOffset()
	{
		$app=$this->appmode->arrayOffset();
		$this->ajaxReturn($app);
	}
		/**
	 * http://localhost/JJPHPDemo/index.php/application-inMulti
	 *["11: 1: 21","11: 1: 22","11: 2: 23","12: 3: 21","12: 4: 21","12: 4: 22"]
	 */
	public function inMulti()
	{
			$app=$this->appmode->inMulti();
		$this->ajaxReturn($app);
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-multipleArguments
	 *["1 22","1 21"]
	 */
	public function multipleArguments()
	{
		$app=$this->appmode->multipleArguments();
		$this->ajaxReturn($app);
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-update
	 */
	public function update()
	{
	 $app=$this->appmode->update();
	}
		/**
	 * http://localhost/JJPHPDemo/index.php/application-rowset
	 */
	public function rowset()
	{
	 $app=$this->appmode->rowset();
	}
		/**
	 * http://localhost/JJPHPDemo/index.php/application-insertUpdate
	 */
	public function insertUpdate()
	{
		 $app=$this->appmode->insertUpdate();
	}
			/**
	 * http://localhost/JJPHPDemo/index.php/application-join
	 * [{"id":"11","author_id":"11","maintainer_id":"11","title":"Adminer","web":"http:\/\/www.vrana.cz\/","slogan":"Database management in single PHP file","name":"Jakub Vrana","born":null,"authorid":"11"},{"id":"11","author_id":"11","maintainer_id":null,"title":"JUSH","web":"http:\/\/www.vrana.cz\/","slogan":"JavaScript Syntax Highlighter","name":"Jakub Vrana","born":null,"authorid":"11"},{"id":"12","author_id":"12","maintainer_id":"12","title":"Nette","web":"http:\/\/davidgrudl.com\/","slogan":"Nette Framework for PHP 5","name":"David Grudl","born":null,"authorid":"12"},{"id":"12","author_id":"12","maintainer_id":"12","title":"Dibi","web":"http:\/\/davidgrudl.com\/","slogan":"Database Abstraction Library for PHP 5","name":"David Grudl","born":null,"authorid":"12"}]
	 */
	public function join()
	{
		 $app=$this->appmode->join();
		 		$this->ajaxReturn($app);
	}
		/**
		 * http://localhost/JJPHPDemo/index.php/application-sqlquery
		 * [{"id":"1","author_id":"11","maintainer_id":"11","title":"Adminer","web":"http:\/\/www.adminer.org\/","slogan":"Database management in single PHP file"},{"id":"2","author_id":"11","maintainer_id":null,"title":"JUSH","web":"http:\/\/jush.sourceforge.net\/","slogan":"JavaScript Syntax Highlighter"},{"id":"3","author_id":"12","maintainer_id":"12","title":"Nette","web":"http:\/\/nettephp.com\/","slogan":"Nette Framework for PHP 5"},{"id":"4","author_id":"12","maintainer_id":"12","title":"Dibi","web":"http:\/\/dibiphp.com\/","slogan":"Database Abstraction Library for PHP 5"}]
		 */
	public function sqlquery()
	{
		 $app=$this->appmode->sqlquery();
		 		$this->ajaxReturn($app);
	}
	/**
	 * http://localhost/JJPHPDemo/index.php/application-sqlexec
	 * Enter description here ...
	 */
	public function sqlexec()
	{
		 $app=$this->appmode->sqlexec();
	}
}