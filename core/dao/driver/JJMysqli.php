<?php
/**
 * JJPHP Mysqli操作类
 * @package  dao
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class JJMysqli{
	//mysqli连接
	var $connect;
	var $lastqueryid;
	/**
	 * 构造函数
	 */
	function __construct() {
		$this->_dbconnect(JJDbConfig::$host,JJDbConfig::$username,JJDbConfig::$password);
	}
	/**
	 * 改变数据库..
	 * @param $dbname
	 */
	function changedb($dbname)
	{
		$this->connect->select_db($dbname);
	}
	/**
	 * 建立数据库连接
	 * @param $host
	 * @param $username
	 * @param $password
	 */
	function _dbconnect($host="",$username="",$password="") {
		$this->connect= new mysqli(JJDbConfig::$host,JJDbConfig::$username,JJDbConfig::$password);
		$this->connect->set_charset('utf8');
		$this->connect->query("set names 'utf8'");
		if($this->connect->select_db(JJDbConfig::$dbname)){
			return false;
		}
		return $this->connect;
	}
	/**
	 * 释放查询资源
	 * @return void
	 */
	function _free_result() {
		if(is_resource($this->lastqueryid)) {
			mysqli_free_result($this->lastqueryid);
		}
		$this->lastqueryid=null;
	}
	/**
	 * free_result
	 * @param $result
	 */
	function free_result($result)
	{
		return  mysqli_free_result($result);
	}
	/**
	 * 遍历查询结果集
	 * @param $type		返回结果集类型
	 * 					MYSQLI_ASSOC，MYSQLI_NUM 和 MYSQLI_BOTH
	 * @return array
	 */
	function _fetch_next($type=MYSQLI_ASSOC) {
		$res = $this->lastqueryid->fetch_array($type);
		if(!$res) {
			$this->_free_result();
		}
		return $res;
	}
	/**
	 * fetch_object
	 * @param $result
	 */
	function fetch_object($result)
	{
		return mysqli_fetch_object($result);
	}
	/**
	 * fetch_array.
	 * @param $result
	 */
	function fetch_array($result)
	{
		return mysqli_fetch_array($result);
	}
	/**
	 * fetch_array.
	 * @param $result
	 */
	function fetch_assoc($result)
	{
		return  mysqli_fetch_assoc($result);

	}
	/**
	 * 直接用sql得到数据
	 * @param $sql
	 * @param $type
	 */
	function query($sql,$type=MYSQLI_ASSOC)
	{
		$rs=$this->_execute($sql);
		if(!is_resource($rs)) return $rs;
		$datalist = array();
		while(($rs = $this->_fetch_next($type)) != false) {
			if($key) {
				$datalist[$rs[$key]] = $rs;
			} else {
				$datalist[] = $rs;
			}
		}
		$this->_free_result();
		return $datalist;
	}
	/**
	 * exec
	 * @param $sql
	 */
	function exec($sql)
	{
	 return $this->_execute($sql);

	}
	/**
	 * 	执行SQL语句
	 * @param $sql
	 */
	function _execute($sql){
		if(!is_resource($this->connect)){
			$this->_dbconnect();
		}
		$this->lastqueryid=$this->connect->query($sql);
		return $this->lastqueryid;
	}
	/**
	 * 返回上一次执行的SQL影响的行数.
	 */
	function _affected_rows(){
		if(!is_resource($this->connect)){
			$this->dbconnect();
		}
		return @mysql_affected_rows($this->connect);

	}
	/**
	 * 	返回上一次执行INSERT产生的ID
	 */
	function lastInsertId()
	{
		if(($id = $this->connect->insert_id)>= 0)
		{
			return $id;
		}else
		{
			$idArr=$this->fetch_array($this->_execute("SELECT last_insert_id() as id"));
			return  intval($idArr[0]);
		}
	}
	/**
	 * prepare.
	 * @param $statement
	 */
	function prepare($statement)
	{
		return $this->connect->prepare($statement);
	}
	/**
	 * beginTransaction.
	 */
	function beginTransaction()
	{
		return $this->connect->autocommit(0);
	}
	/**
	 * rollback.
	 */
	function rollback()
	{
		return $this->$connect->rollback();
	}
	/**
	 * commit
	 */
	function commit()
	{
		$this->connect->autocommit(1);
		return  $this->$connect->connect();
	}
}
