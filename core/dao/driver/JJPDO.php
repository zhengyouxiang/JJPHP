<?php
/**
 *JJPHP PDO操作类
 * @package  dao
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class JJPDO
{
	//pdo连接
	public $connection;
	/**
	 * 构造函数
	 */
	function __construct()
	{
		$connection = new PDO(JJDbConfig::$pdotype.':host='.JJDbConfig::$host.';dbname='.JJDbConfig::$dbname,JJDbConfig::$username,JJDbConfig::$password,
		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",PDO::ATTR_PERSISTENT=>true));
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
		$this->connection=$connection;
	}
	/**
	 * 改变数据库..
	 * @param $dbname
	 */
	function changedb($dbname)
	{
		$connection = new PDO(JJDbConfig::$pdotype.':host='.JJDbConfig::$host.';dbname='.$dbname,JJDbConfig::$username,JJDbConfig::$password,
		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",PDO::ATTR_PERSISTENT=>true));
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
		$this->connection=$connection;
	}
	/**
	 * @return PDOStatement  returns a PDOStatement object, or false on failure.
	 */
	function query($statement,$fetch=PDO::FETCH_ASSOC)
	{
		try {
			$stmt = $this->connection->query($statement);
			$result = $stmt->fetchAll($fetch);
			$stmt = null;
			return $result;
		} catch (Exception $e) {
		}
	}
	/**
	 * Execute an SQL statement and return the number of affected rows
	 * @param statement string
	 * @return int returns the number of rows that were modified or deleted by the SQL statement you issued. If no rows were affected, PDO::exec returns 0. &return.falseproblem; The following example incorrectly relies on the return value of PDO::exec, wherein a statement that affected 0 rows results in a call to die: exec() or die(print_r($db->errorInfo(), true)); ?> ]]>
	 */
	function exec($statement)
	{
		try {
			return  $this->connection->exec($statement);
		} catch (Exception $e) {
		}
	}
	/**
	 * Prepares a statement for execution and returns a statement object
	 * @link http://www.php.net/manual/en/pdo.prepare.php
	 * @param statement string <p>
	 * This must be a valid SQL statement for the target database server.
	 * </p>
	 * @param driver_options array[optional] <p>
	 * This array holds one or more key=&gt;value pairs to set
	 * attribute values for the PDOStatement object that this method
	 * returns. You would most commonly use this to set the
	 * PDO::ATTR_CURSOR value to
	 * PDO::CURSOR_SCROLL to request a scrollable cursor.
	 * Some drivers have driver specific options that may be set at
	 * prepare-time.
	 * </p>
	 * @return PDOStatement If the database server successfully prepares the statement,
	 * PDO::prepare returns a
	 * PDOStatement object.
	 * If the database server cannot successfully prepare the statement,
	 * PDO::prepare returns false or emits
	 * PDOException (depending on error handling).
	 * </p>
	 * <p>
	 * Emulated prepared statements does not communicate with the database server
	 * so PDO::prepare does not check the statement.
	 */
	function prepare($statement, array $driver_options=null)
	{
		return $this->connection->prepare($statement);
	}
	/**
	 * Prepares a statement for execution and returns a statement object and Prepares a statement for execution and returns a statement object and fetchall
	 * @param $sql
	 * @param $param
	 */
	function preareAndExec($statement,$param)
	{
		try {
			$stmt=$this->connection->prepare($statement);
			return $stmt->execute($param);
		} catch (Exception $e) {
		}
	}
	/**
	 * Prepares a statement for execution and returns a statement object and Prepares a statement for execution and returns a statement object and fetchall
	 * @param $sql
	 * @param $param
	 * @param $fetchmode
	 */
	function preareAndFetch($statement,$param,$fetchmodel=PDO::FETCH_ASSOC)
	{
		try {
			$stmt=$this->connection->prepare($statement);
			if($stmt->execute($param)==true)
			{
				$result = $stmt->fetchAll($fetchmodel);
				$stmt = null;
				return $result;
			}
		} catch (Exception $e) {
		}
	}
	/**
	 *Returns the ID of the last inserted row or sequence value
	 *@return string If a sequence name was not specified for the name parameter, PDO::lastInsertId returns a string representing the row ID of the last row that was inserted into the database.
	 */
	function lastInsertId()
	{
		return $this->connection->lastInsertId(null);
	}
	/**
	 * Initiates a transaction
	 * @return bool Returns true on success or false on failure
	 */
	function beginTransaction()
	{
		return $this->connection->beginTransaction();
	}
	/**
	 * Rolls back a transaction
	 * @return bool Returns true on success or false on failure.
	 */
	function rollback()
	{
		return $this->connection->rollBack();
	}
	/** Commits a transaction
	 * @return bool Returns true on success or false on failure.
	 */
	function commit()
	{
		return  $this->connection->commit();
	}
}

?>