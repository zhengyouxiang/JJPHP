<?php
/**
 * JJPHP 一些其他类的基础类
 * @package  comm
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class JJBase
{
	//单实例
	protected static $instance = array();
	public function __construct()
	{
		spl_autoload_register(array($this,'autoload'));
	}
	/**
	 * include_once /lib ,/ core/util ,/web/model,/web/service,/web/util文件 可以被自动调用
	 * @param  $classname
	 */
	public  function autoload($class)
	{
		$filename=COREPATH.'/util/'.$class.'.php';
        if(!$this->fileExists($filename))
        {
        $filename=COREPATH.'/lib/'.$class.'.php';
        }
	    if(!$this->fileExists($filename))
        {
        $filename=JJPATH.'/web/model/'.$class.'.php';
        }
	    if(!$this->fileExists($filename))
        {
        $filename=JJPATH.'/web/service/'.$class.'.php';
        }
         if(!$this->fileExists($filename))
        {
        $filename=JJPATH.'/web/util/'.$class.'.php';
        }
	   if(!$this->fileExists($filename))
        {
        $filename=COREPATH.'/dao/'.$class.'.php';
        }
        if($this->fileExists($filename))
        {
          include_once ($filename);
        }
           
	}
    /**
     * 得到路由的一个实例
     * @return JJDispatch
     */
	public static function loadDispatch()
	{
	   if(!isset(self::$instance['Dispatch']))
		{
			require_once(COREPATH."/comm/JJDispatch.php");
			self::$instance['Dispatch']=new JJDispatch();
		}
		return self::$instance['Dispatch'];
	}
	/**
	 * 得到NotORM的一个实例
	 * @return NotORM
	 */
	public function getNotORM()
	{
		if(!isset(self::$instance['NotORM']))
		{
			require_once(COREPATH."/dao/NotORM.php");
			self::$instance['NotORM']=new NotORM();
		}
		return self::$instance['NotORM'];
	}
	/**
	 * 得到cache的一个实例
	 * @param $type:Db,MFile,Session,SFile
	 * @return JJCache
	 */
	public function getCache($type='')
	{
		if($type!='SFile'&&$type!='Db'&&$type!='Session'&&$type!='MFile')
		{
			$type=JJCacheConfig::$type;
		}
		if(!isset(self::$instance['Cache'][$type]))
		{
			require_once(COREPATH."/cache/JJCache.php");
			self::$instance['Cache'][$type]=new JJCache($type);
		}
		return self::$instance['Cache'][$type];
	}
	/**
	 * 得到core/util 下的类的一个实例
	 * @param $class
	 * @return $class
	 */
	public function getCoreUtil($class)
	{
		if(!isset(self::$instance['coreutil'][$class]))
		{
			$filename=COREPATH.'/util/'.$class.'.php';
			if(!$this->fileExists($filename))
			{
				$class='JJ'.ucfirst($class);
				$filename=COREPATH.'/util/'.$class.'.php';
			}
			if (!$this->fileExists($filename))return false;
			require_once($filename);
			self::$instance['util'][$class]=new $class;
		}
		return self::$instance['util'][$class];
	}
	/**
	 * 得到 lib 下的类的一个实例
	 * @param $class
	 * @return $class
	 */
	public function getLib($class)
	{
		if(!isset(self::$instance['lib'][$class]))
		{
			$filename=COREPATH.'/lib/'.$class.'.php';
			if(!$this->fileExists($filename))
			{
				$class="JJ".ucfirst($class);
				$filename=COREPATH.'/lib/'.$class.'.php';
			}
			if (!$this->fileExists($filename))return false;
			require_once($filename);
			self::$instance['lib'][$class]=new $class;
		}
		return self::$instance['lib'][$class];
	}
	/**
	 * 判断文件是否存在
	 * @param $filename
	 * @return false || true
	 */
	public function fileExists($filename)
	{
		if(!file_exists($filename))
		{
			return false;
		}
		return true;
	}
	/**
	 * 得到Control的名称
	 * @return string
	 */
	public function getContrName()
	{
		if($_GET['c']==''||!isset($_GET['c']))return 'IndexController';
		$contrName=trim(ucfirst($_GET['c']).'Controller');
		if (false === preg_match('/^[a-z0-9_-]+$/i', $contrName))throw new JJException('无效的控制器'.$contrName); 
		return $contrName;
	}
	/**
	 * 得到Action的名称
	 * @return string
	 */
	public function getAction()
	{
		
	    if($_GET['a']==''||!isset($_GET['a']))return 'index';
	    $actionName=trim($_GET['a']);
		if (false === preg_match('/^[a-z0-9_-]+$/i', $actionName))throw new JJException('无效的方法'.$actionName); 
		return $actionName;
	}
	/**
	 * 得到控制器
	 * @return Controller
	 */
	public function getController()
	{
		$contrName=$this->getContrName();
	    if(!isset(self::$instance['controller'][$contrName]))
		{
			$filename=JJPATH.'/web/controller/'.$contrName.'.php';
			if(!$this->fileExists($filename))throw new JJException('控制'.$contrName.'不存在');
			require_once($filename);
			self::$instance['controller'][$contrName]=new $contrName();
		}
		return self::$instance['controller'][$contrName];
	}
	/**
	 * 得到模型层
	 * @return Model
	 */
	public function getModel($model)
	{
		$model=ucfirst($model);
	    if(!isset(self::$instance['model'][$model]))
		{
			$filename=JJPATH.'/web/model/'.$model.'.php';
			if(!$this->fileExists($filename))
			{
			$filename=JJPATH.'/web/model/'.$model.'Model.php';
			$model=$model.'Model';
			}
			if(!$this->fileExists($filename))throw new JJException('模型'.$model.'不存在');
			require_once($filename);
			self::$instance['model'][$model]=new $model();
		}
		return self::$instance['model'][$model];
	}
    /**
	 * 得到服务层
	 * @return Service
	 */
	public function getService($service)
	{
		$service=ucfirst($service);
	    if(!isset(self::$instance['service'][$service]))
		{
			$filename=JJPATH.'/web/service/'.$service.'.php';
			if(!$this->fileExists($filename))
			{
				$filename=JJPATH.'/web/service/'.$service.'Service.php';
				$service=$service.'Service';
			}
			if(!$this->fileExists($filename))throw new JJException('服务'.$service.'不存在');
			require_once($filename);
			self::$instance['service'][$service]=new $service();
		}
		return self::$instance['service'][$service];
	}
	   /**
	 * 得到web/util
	 */
	public function getWebUtil($name) 
	{
		$name=ucfirst($name);
	    if(!isset(self::$instance['webutil'][$name]))
		{
			$filename=JJPATH.'/web/util/'.$name.'.php';
			if(!$this->fileExists($filename))
			{
				$filename=JJPATH.'/web/util/'.$name.'Util.php';
				$name=$name.'Util';
			}
			if(!$this->fileExists($filename))throw new JJException('webutil'.$name.'不存在');
			require_once($filename);
			self::$instance['webutil'][$name]=new $name();
		}
		return self::$instance['webutil'][$name];
	}
   /**
	 * 得到OAuth2
	 * @return JJOAuth2
	 */
	public function getOAuth2()
	{
	    if(!isset(self::$instance['oauth2']))
		{
			$filename=COREPATH.'/oauth/JJOAuth2.php';
			if(!$this->fileExists($filename))throw new JJException('OAuth2不存在');
			require_once($filename);
			self::$instance['oauth2']=new JJOAuth2();
		}
		return self::$instance['oauth2'];
	}
	/**
	 * 中断离开
	 */
	public function phpexit()
	{
		exit();
	}
}