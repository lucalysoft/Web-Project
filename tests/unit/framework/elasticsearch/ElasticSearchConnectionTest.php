<?php

namespace yiiunit\framework\elasticsearch;

use yii\redis\Connection;

/**
 * @group elasticsearch
 */
class ElasticSearchConnectionTest extends ElasticSearchTestCase
{
	/**
	 * Empty DSN should throw exception
	 * @expectedException \yii\base\InvalidConfigException
	 */
	public function testEmptyDSN()
	{
		$db = new Connection();
		$db->open();
	}

}