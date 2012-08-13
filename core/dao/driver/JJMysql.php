<?php
/**
 * JJPHP Mysql操作类
 * @package  dao
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class JJMysql{
	//mysql连接
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
		mysql_select_db($dbname,$this->connect);
	}
	/**
	 * 建立数据库连接
	 * @param $host
	 * @param $username
	 * @param $password
	 */
	function _dbconnect($host,$username,$password) {
		if(!$this->connect=@mysql_connect(JJDbConfig::$host,JJDbConfig::$username,JJDbConfig::$password,1)){
			return false;
		}
		@mysql_query("set names 'utf8'");
		if(@mysql_select_db(JJDbConfig::$dbname,$this->connect)){
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
			mysql_free_result($this->lastqueryid);
		}
		$this->lastqueryid=null;
	}
	/**
	 * 遍历查询结果集
	 * @param $type		返回结果集类型
	 * 					MYSQL_ASSOC，MYSQL_NUM 和 MYSQL_BOTH
	 * @return array
	 */
	function _fetch_next($type=MYSQL_ASSOC) {
		$res = mysql_fetch_array($this->lastqueryid, $type);
		if(!$res) {
			$this->_free_result();
		}
		return $res;
	}
	/**
	 * fetch_array.
	 * @param $result
	 */
	function fetch_array($result)
	{
		return mysql_fetch_array($result);
	}
	/**
	 * free_result
	 * @param  $result
	 */
	function free_result($result)
	{
		return  mysql_free_result($result);
	}
		/**
	 * fetch_array.
	 * @param $result
	 */
	function fetch_assoc($result)
	{
		return  mysql_fetch_assoc($result);
	}
	/**
	 * fetch_object
	 * @param $result
	 */
	function fetch_object($result)
	{
		return mysql_fetch_object($result);
	}
	/**
	 * 直接用sql得到数据
	 * @param $sql
	 * @param $type
	 */
	function query($sql,$type=MYSQL_ASSOC)
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
		$this->lastqueryid=@mysql_query($sql,$this->connect);
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
		if(!is_resource($this->connect)){
			$this->dbconnect();
		}
		return @mysql_insert_id($this->connect);
	}
	/**
	 * beginTransaction.
	 */
	function beginTransaction()
	{
		mysql_query('START TRANSACTION', $this->lastqueryid);
	}
	/**
	 * rollback.
	 */
	function rollback()
	{
		mysql_query('ROLLBACK', $this->lastqueryid);
	}
	/**
	 * commit
	 */
	function commit()
	{
		$result = mysql_query('COMMIT', $this->lastqueryid);
	}
}