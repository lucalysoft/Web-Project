<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\mongo;

use yii\base\InvalidParamException;
use yii\base\Object;
use Yii;

/**
 * Collection represents the Mongo collection information.
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since 2.0
 */
class Collection extends Object
{
	/**
	 * @var \MongoCollection Mongo collection instance.
	 */
	public $mongoCollection;

	/**
	 * Drops this collection.
	 */
	public function drop()
	{
		$this->mongoCollection->drop();
	}

	/**
	 * @param array $condition
	 * @param array $fields
	 * @return \MongoCursor
	 */
	public function find($condition = [], $fields = [])
	{
		return $this->mongoCollection->find($this->buildCondition($condition), $fields);
	}

	/**
	 * @param array $condition
	 * @param array $fields
	 * @return array
	 */
	public function findAll($condition = [], $fields = [])
	{
		$cursor = $this->find($condition, $fields);
		$result = [];
		foreach ($cursor as $data) {
			$result[] = $data;
		}
		return $result;
	}

	/**
	 * Inserts new data into collection.
	 * @param array|object $data data to be inserted.
	 * @param array $options list of options in format: optionName => optionValue.
	 * @return \MongoId new record id instance.
	 * @throws Exception on failure.
	 */
	public function insert($data, $options = [])
	{
		$token = 'Inserting data into ' . $this->mongoCollection->getName();
		Yii::info($token, __METHOD__);
		try {
			Yii::beginProfile($token, __METHOD__);
			$options = array_merge(['w' => 1], $options);
			$this->tryResultError($this->mongoCollection->insert($data, $options));
			Yii::endProfile($token, __METHOD__);
			return is_array($data) ? $data['_id'] : $data->_id;
		} catch (\Exception $e) {
			Yii::endProfile($token, __METHOD__);
			throw new Exception($e->getMessage(), (int)$e->getCode(), $e);
		}
	}

	/**
	 * Inserts several new rows into collection.
	 * @param array $rows array of arrays or objects to be inserted.
	 * @param array $options list of options in format: optionName => optionValue.
	 * @return array inserted data, each row will have "_id" key assigned to it.
	 * @throws Exception on failure.
	 */
	public function batchInsert($rows, $options = [])
	{
		$token = 'Inserting batch data into ' . $this->mongoCollection->getName();
		Yii::info($token, __METHOD__);
		try {
			Yii::beginProfile($token, __METHOD__);
			$options = array_merge(['w' => 1], $options);
			$this->tryResultError($this->mongoCollection->batchInsert($rows, $options));
			Yii::endProfile($token, __METHOD__);
			return $rows;
		} catch (\Exception $e) {
			Yii::endProfile($token, __METHOD__);
			throw new Exception($e->getMessage(), (int)$e->getCode(), $e);
		}
	}

	/**
	 * Updates the rows, which matches given criteria by given data.
	 * @param array $condition description of the objects to update.
	 * @param array $newData the object with which to update the matching records.
	 * @param array $options list of options in format: optionName => optionValue.
	 * @return integer|boolean number of updated documents or whether operation was successful.
	 * @throws Exception on failure.
	 */
	public function update($condition, $newData, $options = [])
	{
		$token = 'Updating data in ' . $this->mongoCollection->getName();
		Yii::info($token, __METHOD__);
		try {
			Yii::beginProfile($token, __METHOD__);
			$options = array_merge(['w' => 1, 'multiple' => true], $options);
			if ($options['multiple']) {
				$keys = array_keys($newData);
				if (!empty($keys) && strncmp('$', $keys[0], 1) !== 0) {
					$newData = ['$set' => $newData];
				}
			}
			$condition = $this->buildCondition($condition);
			$result = $this->mongoCollection->update($condition, $newData, $options);
			$this->tryResultError($result);
			Yii::endProfile($token, __METHOD__);
			if (is_array($result) && array_key_exists('n', $result)) {
				return $result['n'];
			} else {
				return true;
			}
		} catch (\Exception $e) {
			Yii::endProfile($token, __METHOD__);
			throw new Exception($e->getMessage(), (int)$e->getCode(), $e);
		}
	}

	/**
	 * Update the existing database data, otherwise insert this data
	 * @param array|object $data data to be updated/inserted.
	 * @param array $options list of options in format: optionName => optionValue.
	 * @return \MongoId updated/new record id instance.
	 * @throws Exception on failure.
	 */
	public function save($data, $options = [])
	{
		$token = 'Saving data into ' . $this->mongoCollection->getName();
		Yii::info($token, __METHOD__);
		try {
			Yii::beginProfile($token, __METHOD__);
			$options = array_merge(['w' => 1], $options);
			$this->tryResultError($this->mongoCollection->save($data, $options));
			Yii::endProfile($token, __METHOD__);
			return is_array($data) ? $data['_id'] : $data->_id;
		} catch (\Exception $e) {
			Yii::endProfile($token, __METHOD__);
			throw new Exception($e->getMessage(), (int)$e->getCode(), $e);
		}
	}

	/**
	 * Removes data from the collection.
	 * @param array $condition description of records to remove.
	 * @param array $options list of options in format: optionName => optionValue.
	 * @return integer|boolean number of updated documents or whether operation was successful.
	 * @throws Exception on failure.
	 */
	public function remove($condition = [], $options = [])
	{
		$token = 'Removing data from ' . $this->mongoCollection->getName();
		Yii::info($token, __METHOD__);
		try {
			Yii::beginProfile($token, __METHOD__);
			$options = array_merge(['w' => 1, 'multiple' => true], $options);
			$result = $this->mongoCollection->remove($this->buildCondition($condition), $options);
			$this->tryResultError($result);
			Yii::endProfile($token, __METHOD__);
			if (is_array($result) && array_key_exists('n', $result)) {
				return $result['n'];
			} else {
				return true;
			}
		} catch (\Exception $e) {
			Yii::endProfile($token, __METHOD__);
			throw new Exception($e->getMessage(), (int)$e->getCode(), $e);
		}
	}

	/**
	 * Checks if command execution result ended with an error.
	 * @param mixed $result raw command execution result.
	 * @throws Exception if an error occurred.
	 */
	protected function tryResultError($result)
	{
		if (is_array($result)) {
			if (!empty($result['err'])) {
				throw new Exception($result['errmsg'], (int)$result['code']);
			}
		} elseif (!$result) {
			throw new Exception('Unknown error, use "w=1" option to enable error tracking');
		}
	}

	/**
	 * Converts user friendly condition keyword into actual Mongo condition keyword.
	 * @param string $key raw condition key.
	 * @return string actual key.
	 */
	protected function normalizeConditionKeyword($key)
	{
		static $map = [
			'OR' => '$or',
			'>' => '$gt',
			'>=' => '$gte',
			'<' => '$lt',
			'<=' => '$lte',
			'!=' => '$ne',
			'<>' => '$ne',
			'IN' => '$in',
			'NOT IN' => '$nin',
			'ALL' => '$all',
			'SIZE' => '$size',
			'TYPE' => '$type',
			'EXISTS' => '$exists',
			'NOTEXISTS' => '$exists',
			'ELEMMATCH' => '$elemMatch',
			'MOD' => '$mod',
			'%' => '$mod',
			'=' => '$$eq',
			'==' => '$$eq',
			'WHERE' => '$where'
		];
		$matchKey = strtoupper($key);
		if (array_key_exists($matchKey, $map)) {
			return $map[$matchKey];
		} else {
			return $key;
		}
	}

	/**
	 * Converts given value into [[MongoId]] instance.
	 * If array given, each element of it will be processed.
	 * @param mixed $rawId raw id(s).
	 * @return array|\MongoId normalized id(s).
	 */
	protected function ensureMongoId($rawId)
	{
		if (is_array($rawId)) {
			$result = [];
			foreach ($rawId as $key => $value) {
				$result[$key] = $this->ensureMongoId($value);
			}
			return $result;
		} elseif (is_object($rawId)) {
			if ($rawId instanceof \MongoId) {
				return $rawId;
			} else {
				$rawId = (string)$rawId;
			}
		}
		return new \MongoId($rawId);
	}

	/**
	 * Parses the condition specification and generates the corresponding Mongo condition.
	 * @param array $condition the condition specification. Please refer to [[Query::where()]]
	 * on how to specify a condition.
	 * @return array the generated Mongo condition
	 * @throws InvalidParamException if the condition is in bad format
	 */
	public function buildCondition($condition)
	{
		static $builders = [
			'AND' => 'buildAndCondition',
			'OR' => 'buildOrCondition',
			'BETWEEN' => 'buildBetweenCondition',
			'NOT BETWEEN' => 'buildBetweenCondition',
			'IN' => 'buildInCondition',
			'NOT IN' => 'buildInCondition',
			'LIKE' => 'buildLikeCondition',
		];

		if (!is_array($condition)) {
			throw new InvalidParamException('Condition should be an array.');
		} elseif (empty($condition)) {
			return [];
		}
		if (isset($condition[0])) { // operator format: operator, operand 1, operand 2, ...
			$operator = strtoupper($condition[0]);
			if (isset($builders[$operator])) {
				$method = $builders[$operator];
				array_shift($condition);
				return $this->$method($operator, $condition);
			} else {
				throw new InvalidParamException('Found unknown operator in query: ' . $operator);
			}
		} else {
			// hash format: 'column1' => 'value1', 'column2' => 'value2', ...
			return $this->buildHashCondition($condition);
		}
	}

	/**
	 * Creates a condition based on column-value pairs.
	 * @param array $condition the condition specification.
	 * @return array the generated Mongo condition.
	 */
	public function buildHashCondition($condition)
	{
		$result = [];
		foreach ($condition as $name => $value) {
			$name = $this->normalizeConditionKeyword($name);
			if (strncmp('$', $name, 1) === 0) {
				// Native Mongo condition:
				$result[$name] = $value;
			} else {
				if (is_array($value)) {
					if (array_key_exists(0, $value)) {
						// Quick IN condition:
						$result = array_merge($result, $this->buildInCondition('IN', [$name, $value]));
					} else {
						// Normalize possible verbose condition:
						$actualValue = [];
						foreach ($value as $k => $v) {
							$actualValue[$this->normalizeConditionKeyword($k)] = $v;
						}
						$result[$name] = $actualValue;
					}
				} else {
					// Direct match:
					if ($name == '_id') {
						$value = $this->ensureMongoId($value);
					}
					$result[$name] = $value;
				}
			}
		}
		return $result;
	}

	/**
	 * Connects two or more conditions with the `AND` operator.
	 * @param string $operator the operator to use for connecting the given operands
	 * @param array $operands the Mongo conditions to connect.
	 * @return array the generated Mongo condition.
	 */
	public function buildAndCondition($operator, $operands)
	{
		$result = [];
		foreach ($operands as $operand) {
			$condition = $this->buildCondition($operand);
			$result = array_merge_recursive($result, $condition);
		}
		return $result;
	}

	/**
	 * Connects two or more conditions with the `OR` operator.
	 * @param string $operator the operator to use for connecting the given operands
	 * @param array $operands the Mongo conditions to connect.
	 * @return array the generated Mongo condition.
	 */
	public function buildOrCondition($operator, $operands)
	{
		$operator = $this->normalizeConditionKeyword($operator);
		$parts = [];
		foreach ($operands as $operand) {
			$parts[] = $this->buildCondition($operand);
		}
		return [$operator => $parts];
	}

	/**
	 * Creates an Mongo condition, which emulates the `BETWEEN` operator.
	 * @param string $operator the operator to use
	 * @param array $operands the first operand is the column name. The second and third operands
	 * describe the interval that column value should be in.
	 * @return array the generated Mongo condition.
	 * @throws InvalidParamException if wrong number of operands have been given.
	 */
	public function buildBetweenCondition($operator, $operands)
	{
		if (!isset($operands[0], $operands[1], $operands[2])) {
			throw new InvalidParamException("Operator '$operator' requires three operands.");
		}
		list($column, $value1, $value2) = $operands;
		if (strncmp('NOT', $operator, 3) === 0) {
			return [
				$column => [
					'$lt' => $value1,
					'$gt' => $value2,
				]
			];
		} else {
			return [
				$column => [
					'$gte' => $value1,
					'$lte' => $value2,
				]
			];
		}
	}

	/**
	 * Creates an Mongo condition with the `IN` operator.
	 * @param string $operator the operator to use (e.g. `IN` or `NOT IN`)
	 * @param array $operands the first operand is the column name. If it is an array
	 * a composite IN condition will be generated.
	 * The second operand is an array of values that column value should be among.
	 * @return array the generated Mongo condition.
	 * @throws InvalidParamException if wrong number of operands have been given.
	 */
	public function buildInCondition($operator, $operands)
	{
		if (!isset($operands[0], $operands[1])) {
			throw new InvalidParamException("Operator '$operator' requires two operands.");
		}

		list($column, $values) = $operands;

		$values = (array)$values;

		if (!is_array($column)) {
			$columns = [$column];
			$values = [$column => $values];
		} elseif (count($column) < 2) {
			$columns = $column;
			$values = [$column[0] => $values];
		} else {
			$columns = $column;
		}

		$operator = $this->normalizeConditionKeyword($operator);
		$result = [];
		foreach ($columns as $column) {
			if ($column == '_id') {
				$inValues = $this->ensureMongoId($values[$column]);
			} else {
				$inValues = $values[$column];
			}
			$result[$column][$operator] = $inValues;
		}
		return $result;
	}

	/**
	 * Creates a Mongo condition, which emulates the `LIKE` operator.
	 * @param string $operator the operator to use
	 * @param array $operands the first operand is the column name.
	 * The second operand is a single value that column value should be compared with.
	 * @return array the generated Mongo condition.
	 * @throws InvalidParamException if wrong number of operands have been given.
	 */
	public function buildLikeCondition($operator, $operands)
	{
		if (!isset($operands[0], $operands[1])) {
			throw new InvalidParamException("Operator '$operator' requires two operands.");
		}
		list($column, $value) = $operands;
		return [$column => '/' . $value . '/'];
	}
}