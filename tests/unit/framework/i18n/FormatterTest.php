<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yiiunit\framework\i18n;

use yii\i18n\Formatter;
use yiiunit\TestCase;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FormatterTest extends TestCase
{
	/**
	 * @var Formatter
	 */
	protected $formatter;

	protected function setUp()
	{
		parent::setUp();
		if (!extension_loaded('intl')) {
			$this->markTestSkipped('intl extension is required.');
		}
		$this->mockApplication();
		$this->formatter = new Formatter(array(
			'locale' => 'en_US',
		));
	}

	protected function tearDown()
	{
		parent::tearDown();
		$this->formatter = null;
	}

	public function testAsDecimal()
	{
		$value = '123';
		$this->assertSame($value, $this->formatter->asDecimal($value));
		$value = '123456';
		$this->assertSame("123,456", $this->formatter->asDecimal($value));
		$value = '-123456.123';
		$this->assertSame("-123,456.123", $this->formatter->asDecimal($value));
	}

	public function testAsPercent()
	{
		$value = '123';
		$this->assertSame('12,300%', $this->formatter->asPercent($value));
		$value = '0.1234';
		$this->assertSame("12%", $this->formatter->asPercent($value));
		$value = '-0.009343';
		$this->assertSame("-1%", $this->formatter->asPercent($value));
	}

	public function testAsScientific()
	{
		$value = '123';
		$this->assertSame('1.23E2', $this->formatter->asScientific($value));
		$value = '123456';
		$this->assertSame("1.23456E5", $this->formatter->asScientific($value));
		$value = '-123456.123';
		$this->assertSame("-1.23456123E5", $this->formatter->asScientific($value));
	}

	public function testAsCurrency()
	{
		$value = '123';
		$this->assertSame('$123.00', $this->formatter->asCurrency($value));
		$value = '123.456';
		$this->assertSame("$123.46", $this->formatter->asCurrency($value));
		$value = '-123456.123';
		$this->assertSame("($123,456.12)", $this->formatter->asCurrency($value));
	}

	public function testDate()
	{
		$time = time();
		$this->assertSame(date('n/j/y', $time), $this->formatter->asDate($time));
		$this->assertSame(date('g:i A', $time), $this->formatter->asTime($time));
		$this->assertSame(date('n/j/y g:i A', $time), $this->formatter->asDatetime($time));

		$this->assertSame(date('M j, Y', $time), $this->formatter->asDate($time, 'long'));
		$this->assertSame(date('g:i:s A T', $time), $this->formatter->asTime($time, 'long'));
		$this->assertSame(date('M j, Y g:i:s A T', $time), $this->formatter->asDatetime($time, 'long'));
	}
}
