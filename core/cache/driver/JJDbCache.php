<?php
/**
 * JJPHP 数据库缓存类
 * @package  cache
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
include_once  COREPATH."/dao/NotORM.php";
class JJDbCache {
	private $notORM;
	function __construct() {
       $this->notORM=new NotORM();
	}
	function load($key) {
		$key = $this->get_cache_key($key);
		$temp=$this->notORM->JJDbCache("k",$key);
		$result=$temp->fetchOneData();
	    if(!$result)return false;
	    if ($result['cachetime'] == 0) return @unserialize(base64_decode($result['v']));
	    if ((time() > ($result['dtime'] + $result['cachetime']))) {
			$temp-> delete();
		}
		return @unserialize(base64_decode($result['v']));
	}
	function save($key, $value, $cachetime=0) {
		$cachetime=(int)$cachetime;
		$value=base64_encode(@serialize($value));
		$key = $this->get_cache_key($key);
		$time = time();
		$temp=$this->notORM->JJDbCache("k",$key);
		if($temp->count()==0)
		{
			if($this->notORM->JJDbCache()->insert(array("k"=>$key,"v" => $value, "dtime" => $time,"cachetime"=>$cachetime)))return true;
		}
		else 
		{
			$temp=$temp->fetch();
			$temp['v']=$value;
			$temp['dtime']=$time;
			$temp['cachetime']=$cachetime;
			if($temp->update())return true ;
		}
        return false;
	}
	public function clear($key) {
		$key = $this->get_cache_key($key);
		return 	$this->notORM->JJDbCache("k",$key)->delete();
	}
	public function clear_all() {
		$sql = "TRUNCATE TABLE JJDbCache";
		 $this->notORM->JJDAO->exec($sql);
	}
	private function get_cache_key($key) {
		return md5(trim($key));
	}

}
