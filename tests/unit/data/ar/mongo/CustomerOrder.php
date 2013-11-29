<?php

namespace yiiunit\data\ar\mongo;


class CustomerOrder extends ActiveRecord
{
	public static function collectionName()
	{
		return 'customer_order';
	}

	public function attributes()
	{
		return [
			'_id',
			'number',
			'customer_id',
			'items',
		];
	}

	public function getCustomer()
	{
		return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
	}
}