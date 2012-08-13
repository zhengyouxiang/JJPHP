<?php
/**
 *JJPHP 日志类
 * @package  coreutil
 * @author     zhuli <www.initphp.com>
 * @author     zhengyouxiangxiang <zhengyouxiang00@gmail.com>
 * @copyright   www.111work.com
 */
class JJLog
{
	const LOGPATH  = "/data/"; //默认日志目录
	const FILESIZE = '1024000'; //默认日志文件大小
	const FILENAME = 'JJPHP_Log.log'; //默认日志文件名称
    // 日志级别 从上到下，由低到高
    const EMERG   = 'EMERG';  // 严重错误: 导致系统崩溃无法使用
    const ALERT    = 'ALERT';  // 警戒性错误: 必须被立即修改的错误
    const CRIT      = 'CRIT';  // 临界值错误: 超过临界值的错误，例如一天24小时，而输入的是25小时这样
    const ERR       = 'ERR';  // 一般错误: 一般性错误
    const WARN    = 'WARN';  // 警告性错误: 需要发出警告的错误
    const NOTICE  = 'NOTIC';  // 通知: 程序可以运行但是还不够完美的错误
    const INFO     = 'INFO';  // 信息: 程序输出信息
    const DEBUG   = 'DEBUG';  // 调试: 调试信息
    const SQL       = 'SQL';  // SQL：SQL语句 注意只在调试模式开启时有效
	
	/**
	 * 写日志-直接写入日志文件或者邮件
	 * @param  string  $message  日志信息
	 * @param  string  $log_type 日志类型
	 * @return
	 */
 
   static public function write($message, $log_type = self::INFO) {
		$log_path = self::get_file_log_name();
		if(is_file($log_path) && (self::FILESIZE < filesize($log_path)) ) {
			rename($log_path, dirname($log_path).'/'.time().'-Bak-'.basename($log_path));
		}
		$message = self::get_message($message, $log_type);
		error_log($message, 3, $log_path, '');
	}

	/**
	 * 写日志-获取文件日志名称
	 * @return string
	 */
	static private function get_file_log_name() {
		return JJPATH.self::LOGPATH. self::FILENAME;
	}

	/**
	 * 写日志-组装message信息
	 * @param  string  $message  日志信息
	 * @param  string  $log_type 日志类型
	 * @return string
	 */
	 static private function get_message($message, $log_type) {
		return  date("Y-m-d H:i:s") . " [{$log_type}] : {$message}\r\n";
	}
}
