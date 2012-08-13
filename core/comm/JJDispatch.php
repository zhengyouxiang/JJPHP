<?php
/**
 *  JJPHP 路由分发和框架的运行类
 * @package  comm
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */

class JJDispatch extends JJBase
{
	private $before_action  = 'before';//前置Action
	private $after_action   = 'after'; //后置Action
	/**
	 * 路由分发并解析api方式的路由
	 * index.php/user-add.api
	 * @throws JJException
	 */
	public function dispatch()
	{
		$uri=$_SERVER['REQUEST_URI'];
		$filter_param = array('<','>','"',"'",'%3C','%3E','%22','%27','%3c','%3e');
		$uri = str_replace($filter_param, '', $uri);
		if($posi=strpos($uri, '?'))
		{
			$uri = substr($uri,0,$posi);
		}
		if (strpos($uri, '.php')) {
			$uri = explode('.php', $uri);
			$uri = $uri[1];
		}
		else
		{
			$uri='';
		}
		$uri = explode('-', str_replace('.api', '', trim($uri, '/')));
		if (!is_array($uri) || count($uri) == 0)throw new JJException("请求参数错误");
		if (isset($uri[0])) $_GET['c'] = $uri[0];
		if (isset($uri[1])) $_GET['a'] = $uri[1];
		
	}
	/**
	 * 运行框架
	 */
	public function run()
	{
		$this->dispatch();
		$controller=$this->getController();
		$this->run_before_action($controller);
		$this->run_action($controller);
		$this->run_after_action($controller);
	}
	/**
	 * 运行Action
	 * @param $controller
	 * @throws JJException
	 */
	private function run_action($controller)
	{
		$action=$this->getAction();
		if (!method_exists($controller, $action)) throw new JJException($this->getContrName()."->".$action."不存在");
		$controller->$action();
	}
	/**
	 * 运行前置Action
	 * @param $controller
	 */
	private function run_before_action($controller) {
		if (!method_exists($controller, $this->before_action)) return false;
		$before=$this->before_action;
		$controller->$before();
	}
	/**
	 * 运行后置Action
	 * @param $controller
	 */
	private function run_after_action($controller) {
		if (!method_exists($controller, $this->after_action)) return false;
		$after=$this->after_action;
		$controller->$after();
	}

}
