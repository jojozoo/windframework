<?php
/**
 * @author Qiong Wu <papa0924@gmail.com> 2010-11-8
 * @link http://www.phpwind.com
 * @copyright Copyright &copy; 2003-2110 phpwind.com
 * @license 
 */

L::import('WIND:core.base.WindAction');
/**
 * the last known user to change this file in the repository  <$LastChangedBy$>
 * @author Qiong Wu <papa0924@gmail.com>
 * @version $Id$ 
 * @package 
 */
abstract class WindController extends WindAction {

	protected $validatorClass = 'WIND:component.utility.WindValidator';

	/* (non-PHPdoc)
	 * @see WindAction::resolvedActionMethod()
	 */
	protected function resolvedActionMethod($handlerAdapter) {
		$action = $handlerAdapter->getAction();
		if ($action !== 'run') $action = 'do' . ucfirst($action);
		if ($action === 'doAction' || !in_array($action, get_class_methods(get_class($this)))) $this->sendError('The action method ' . $action . ' is protected or not exist.');
		call_user_func_array(array($this, $action), array());
	}

	/**
	 * 实现表单验证规则
	 */
	public function validatorFormRule() {
		return array();
	}

	/**
	 * @return the $validatorClass
	 */
	public function getValidatorClass() {
		return $this->validatorClass;
	}

}