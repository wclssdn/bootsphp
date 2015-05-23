<?php

namespace BootsPHP;

/**
 * 日志类
 * @uses Log::init(日志文件名, 日志路径, [日志级别], [日志文件切割方式]);
 * 如需配合服务器其他日志统一日志ID,则需调用Log::setLogId($logId);
 * @author wclssdn <ssdn@vip.qq.com>
 *
 */
class Log{

	/**
	 * 日志级别: 无
	 * @var number
	 */
	const LOG_LEVEL_NONE = 0;

	/**
	 * 日志级别: 提醒
	 * @var number
	 */
	const LOG_LEVEL_NOTICE = 1;

	/**
	 * 日志级别: 警告
	 * @var number
	 */
	const LOG_LEVEL_WARNING = 2;

	/**
	 * 日志级别: 错误
	 * @var number
	 */
	const LOG_LEVEL_ERROR = 4;

	/**
	 * 日志级别: 调试
	 * @var number
	 */
	const LOG_LEVEL_DEBUG = 8;

	/**
	 * 日志级别: 所有
	 * @var number
	 */
	const LOG_LEVEL_ALL = 255;

	/**
	 * 日志文件切割方式: 按小时切分
	 * @var string
	 */
	const LOG_FILE_SPLIT_STYLE_HOUR = 'YmdH';

	/**
	 * 日志文件切割方式: 按天切分
	 * @var string
	 */
	const LOG_FILE_SPLIT_STYLE_DAY = 'Ymd';

	/**
	 * 日志文件切割方式: 按周切分
	 * @var string
	 */
	const LOG_FILE_SPLIT_STYLE_WEEK = 'YW';

	/**
	 * 日志文件切割方式: 按月切分
	 * @var string
	 */
	const LOG_FILE_SPLIT_STYLE_MONTH = 'Ym';

	/**
	 * 日志文件切割方式: 按年切分
	 * @var string
	 */
	const LOG_FILE_SPLIT_STYLE_YEAR = 'Y';

	/**
	 * 日志文件切割方式: 不切分
	 * @var string
	 */
	const LOG_FILE_SPLIT_STYLE_NONE = '';

	/**
	 * 记录日志的级别
	 * @var number
	 */
	protected static $logLevel = self::LOG_LEVEL_ALL;

	/**
	 * 日志通过header发送到客户端的级别
	 * @var number
	 */
	protected static $sendHeaderLevel = self::LOG_LEVEL_NONE;

	/**
	 * 是否通过header发送日志到客户端
	 * @var boolean
	 */
	protected static $sendHeader = false;

	/**
	 * 记录文件以及行数的日志级别, 多个用level | level
	 * @var number
	 */
	protected static $logFileLineLevel = self::LOG_LEVEL_ERROR;

	protected static $logFileName = 'log';

	protected static $logFilePath = '/tmp/';

	protected static $logFileSplitStyle = self::LOG_FILE_SPLIT_STYLE_MONTH;

	/**
	 * 每次日志均打印的额外信息
	 * @var array
	 */
	protected static $extra = array();

	/**
	 * 用于跟踪一次完整请求的标识
	 * @var string
	 */
	protected static $logId = null;

	/**
	 * 可减小不同用户生成的logId的冲突可能
	 * @var string
	 */
	protected static $logIdSalt = null;

	/**
	 * 需要记录的数据
	 * @var array
	 */
	protected static $data;

	private function __construct(){
	}

	private function __clone(){
	}

	/**
	 * 初始化Log, 设置应用名, 日志文件位置, 写日志等级, 日志文件切割方式
	 * @param string $logFileName 应用标识. 也就是日志文件名
	 * @param string $logPath 日志存储路径
	 * @param number $logLevel 日志等级. 多个用位或操作. 例如Log::LOG_LEVEL_WARNING | Log::LOG_LEVEL_ERROR
	 * @param string $logFileSplitStyle 日志文件的切割方式, 默认按月
	 */
	public static function init($logFileName, $logFilePath, $logLevel = self::LOG_LEVEL_ALL, $logFileSplitStyle = self::LOG_FILE_SPLIT_STYLE_MONTH){
		static $init = false;
		if ($init === false){
			$logFileName && self::$logFileName = $logFileName;
			self::$logFilePath = $logFilePath;
			self::$logFileSplitStyle = $logFileSplitStyle;
			self::resetData();
		}
	}

	/**
	 * 设置日志ID, 用于跟踪一次完整的请求过程.
	 * 如果调用请确保在最开始的未知调用.
	 * @param string $logId
	 */
	public static function setLogId($logId){
		self::$logId = $logId;
	}

	/**
	 * 获取log ID.
	 * 如果指定了则返回指定的. 如果未指定则返回一个随机的
	 */
	protected static function getLogId(){
		if (self::$logId === null){
			self::$logId = rand(111111111, 999999999) xor uniqid();
		}
		return self::$logId;
	}

	/**
	 * 设置日志记录级别
	 * @param number $level 默认为Log::LOG_LEVEL_ALL
	 */
	public static function setLogWriteLevel($level){
		self::$logLevel = (int)$level;
	}

	/**
	 * 设置记录文件以及行数的日志级别
	 * @param number $level 默认Log::LOG_LEVEL_ERROR
	 */
	public static function setLogFileLineLevel($level){
		self::$logFileLineLevel = (int)$level;
	}

	/**
	 * 设置log通过header发送到客户端
	 */
	public static function openSendHeader(){
		self::$sendHeader = true;
	}

	/**
	 * 设置log不通过header发送到客户端
	 */
	public static function closeSendHeader(){
		self::$sendHeader = false;
	}

	/**
	 * 设置log通过header发送到客户端的级别 默认为Log::LOG_LEVEL_ALL
	 * @param number $level
	 */
	public static function setLogSendHeaderLevel($level){
		self::$sendHeaderLevel = $level;
	}

	/**
	 * 每次都记录的额外的日志信息
	 * @param mixed $extraLog
	 */
	public static function extraLog($extraLog){
		$arguments = func_get_args();
		for ($i = 0, $cnt = count($arguments); $i < $cnt; ++$i){
			self::$extra[] = $arguments[$i];
		}
	}

	/**
	 * 记录DEBUG级别的日志
	 * @param string $log
	 */
	public static function debug($log){
		self::resetData();
		if (count(func_get_args()) > 1){
			self::$data = array_slice(func_get_args(), 1);
		}
		self::writeLog($log, self::LOG_LEVEL_DEBUG);
	}

	/**
	 * 记录NOTICE级别的日志
	 * @param string $log
	 */
	public static function notice($log){
		self::resetData();
		if (count(func_get_args()) > 1){
			self::$data = array_slice(func_get_args(), 1);
		}
		self::writeLog($log, self::LOG_LEVEL_NOTICE);
	}

	/**
	 * 记录WARNING级别的日志
	 * @param string $log
	 */
	public static function warning($log){
		self::resetData();
		if (count(func_get_args()) > 1){
			self::$data = array_slice(func_get_args(), 1);
		}
		self::writeLog($log, self::LOG_LEVEL_WARNING);
	}

	/**
	 * 记录ERROR级别的日志
	 * @param string $log
	 */
	public static function error($log){
		self::resetData();
		if (count(func_get_args()) > 1){
			self::$data = array_slice(func_get_args(), 1);
		}
		self::writeLog($log, self::LOG_LEVEL_ERROR);
	}

	/**
	 * 获取日志文件绝对路径
	 * @return string
	 */
	protected static function getLogFile(){
		static $logFile = null;
		if ($logFile === null){
			$logFile = rtrim(self::$logFilePath, '\\/') . DIRECTORY_SEPARATOR . self::$logFileName;
			switch (self::$logFileSplitStyle){
				case self::LOG_FILE_SPLIT_STYLE_DAY:
					$logFile .= date('Ymd');
					break;
				case self::LOG_FILE_SPLIT_STYLE_WEEK:
					$logFile .= date('YW');
					break;
				case self::LOG_FILE_SPLIT_STYLE_MONTH:
					$logFile .= date('Ym');
					break;
				case self::LOG_FILE_SPLIT_STYLE_YEAR:
					$logFile .= date('Y');
					break;
				case self::LOG_FILE_SPLIT_STYLE_NONE:
				default:
					break;
			}
		}
		return $logFile;
	}

	/**
	 * 获取用户IP
	 * @return Ambigous <NULL, string>
	 */
	protected static function getUserIP(){
		static $ip = null;
		if ($ip === null){
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match('#^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$#', $_SERVER['HTTP_X_FORWARDED_FOR'])){
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}else{
				$ip = $_SERVER['REMOTE_ADDR'];
			}
		}
		return $ip;
	}

	/**
	 * 获取请求的path信息
	 * @return Ambigous <NULL, string>
	 */
	protected static function getUrlPath(){
		static $path = null;
		if ($path === null){
			$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		}
		return $path;
	}

	/**
	 * 格式化日志
	 * @param string $log
	 * @param number $logLevel
	 */
	protected static function formatLog($log, $logLevel){
		$log = str_replace(array(
				"\r",
				"\n"
		), ' ', $log);
		$level = '';
		switch ($logLevel){
			case self::LOG_LEVEL_DEBUG:
				$level = 'DEBUG';
				break;
			case self::LOG_LEVEL_NOTICE:
				$level = 'NOTICE';
				break;
			case self::LOG_LEVEL_WARNING:
				$level = 'WARNING';
				break;
			case self::LOG_LEVEL_ERROR:
				$level = 'ERROR';
				break;
		}
		$logId = self::getLogId();
		$date = date('Y-m-d H:i:s');
		$path = self::getUrlPath();
		$ip = self::getUserIP();
		$backTrace = debug_backtrace();
		$traceInfo = array();
		for ($i = count($backTrace) - 1; $i >= 0; --$i){
			if ($backTrace[$i]['class'] == __CLASS__){
				$file = $backTrace[$i]['file'];
				$line = $backTrace[$i]['line'];
				$pos = $i + 1;
				$function = isset($backTrace[$pos]['class']) ? "{$backTrace[$pos]['class']}{$backTrace[$pos]['type']}{$backTrace[$pos]['function']}" : $backTrace[$pos]['function'];
				break;
			}
		}
		$data = array();
		if (self::checkData() === true){
			foreach (self::$data as $d){
				$data[] = json_encode($d);
			}
		}
		self::resetData();
		$data = implode("\t", $data);
		$data && $data = "\t{$data}";
		$extra = array();
		if (self::$extra){
			foreach (self::$extra as $e){
				$extra[] = is_string($e) ? "[{$e}]" : json_encode($e);
			}
		}
		$extra = implode('', $extra);
		$log = "[{$level}][{$date}][{$logId}][{$ip}][{$path}]{$extra}	{$log}{$data}";
		if (self::$logFileLineLevel & $logLevel){
			$log .= "[{$function}() in {$file}({$line})]";
		}
		return $log . PHP_EOL;
	}

	/**
	 * 是否有需要记录的数据
	 * @return boolean
	 */
	protected static function checkData(){
		if (self::$data !== self::initData()){
			return true;
		}
		return false;
	}

	/**
	 * 初始化数据变量
	 */
	protected static function initData(){
		static $data = null;
		if ($data === null){
			$data = rand(111111, 999999);
		}
		return $data;
	}

	/**
	 * 重置数据变量
	 */
	protected static function resetData(){
		self::$data = self::initData();
	}

	/**
	 * 写日志到文件
	 */
	protected static function writeLog($log, $logLevel){
		static $signs = array();
		if (!is_string($log)){
			$log = json_encode($log);
		}
		if (self::$logLevel & $logLevel || self::$sendHeaderLevel & $logLevel){
			$log = self::formatLog($log, $logLevel);
		}
		if (self::$logLevel & $logLevel){
			$logFile = self::getLogFile();
			if (!isset($signs[$logFile]['write'])) {
				$signs[$logFile]['write'] = is_writable($logFile);
			}
			if ($signs[$logFile]['write']){
				file_put_contents($logFile, $log, FILE_APPEND);
			}
		}
		if (self::$sendHeader && self::$sendHeaderLevel & $logLevel){
			$uniq = uniqid();
			header("Log_{$uniq}:{$log}");
		}
	}
}