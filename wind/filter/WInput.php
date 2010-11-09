<?php
/**
 * @author xiaoxia xu <x_824@sina.com> 2010-11-9
 * @link http://www.phpwind.com
 * @copyright Copyright &copy; 2003-2110 phpwind.com
 * @license 
 */
/**
 * 全局性过滤，过滤通过GET\POST\COOKIE\SERVER\FILES\GLOBALS中的内容
 * the last known user to change this file in the repository  <$LastChangedBy$>
 * @author xiaoxia xu <x_824@sina.com>
 * @version $Id$ 
 * @package
 */
class WInput extends WFilter {
	/**
	 * 过滤输入
	 */
	public function doPreProcessing($httpRequest) {
		$allowed = array('GLOBALS' => 1,'_GET' => 1,'_POST' => 1,'_COOKIE' => 1,'_FILES' => 1,'_SERVER' => 1,
						'P_S_T' => 1);
		foreach ($GLOBALS as $key => $value) {
			if (!isset($allowed[$key])) {
				$GLOBALS[$key] = null;
				unset($GLOBALS[$key]);
			}
		}
		if (!get_magic_quotes_gpc()) {
			WInput::slashes($_POST);
			WInput::slashes($_GET);
			WInput::slashes($_COOKIE);
		}
		WInput::slashes($_FILES);
		/*$GLOBALS['pwServer'] = S::getServer(array('HTTP_REFERER','HTTP_HOST','HTTP_X_FORWARDED_FOR','HTTP_USER_AGENT',
													'HTTP_CLIENT_IP','HTTP_SCHEME','HTTPS','PHP_SELF',
													'REQUEST_URI','REQUEST_METHOD','REMOTE_ADDR','SCRIPT_NAME',
													'QUERY_STRING'));
		!$GLOBALS['pwServer']['PHP_SELF'] && $GLOBALS['pwServer']['PHP_SELF'] = S::getServer('SCRIPT_NAME');*/
	}
	
	public function doPostProcessing($httpRequest) {
		
	}
	
	/**
	 * 转义函数~~~此函数的位置可以考虑移植到工具类中
	 * @param $array
	 */
	public static function slashes(&$array) {
		if (is_array($array)) {
			foreach ($array as $key => $value) {
				if (is_array($value)) {
					WInput::slashes($array[$key]);
				} else {
					$array[$key] = addslashes($value);
				}
			}
		}
	}
}