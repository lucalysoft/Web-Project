<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\widgets;

use yii\helpers\Html;
use yii\bootstrap\Widget;
use yii\bootstrap\Alert as BsAlert;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * - \Yii::$app->getSession()->setFlash('error', 'This is the message');
 * - \Yii::$app->getSession()->setFlash('success', 'This is the message');
 * - \Yii::$app->getSession()->setFlash('info', 'This is the message');
 *
 * @author Alexander Makarov <sam@rmcerative.ru>
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 */
class Alert extends Widget
{
	/**
	 * @var array the allowed bootstrap alert types.
	 */
	public $allowedTypes = ['error', 'danger', 'success', 'info', 'warning'];
	 
	/**
	 * @var array the options for rendering the close button tag.
	 */
	public $closeButton = [];
	
	private $_doNotRender = true;
	
	public function init()
	{
		$this->_doNotRender = true;
		$session = \Yii::$app->getSession();
		$flashes = $session->getAllFlashes();
		$baseCssClass = isset($this->options['class']) ? $this->options['class'] : '';

		foreach ($flashes as $type => $message) {
			if (in_array($type, $this->allowedTypes)) {
				$this->options['class'] = (($type === 'error') ? "alert-danger" : "alert-{$type}") . ' ' . $baseCssClass;
				echo BsAlert::widget([
					'body' => $message,
					'closeButton' => $this->closeButton,
					'options' => $this->options
				]);
				Html::removeCssClass($this->options, $class);
				$session->removeFlash($type);
				$this->_doNotRender = false;
			}
		}
		
		if (!$this->_doNotRender) {
			parent::init();
		}
	}

	public function run()
	{
		if (!$this->_doNotRender) {
			parent::run();
		}
	}
}
