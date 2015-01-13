<?php

namespace PPP\Module\DataModel;

use PPP\DataModel\FirstNode;
use PPP\DataModel\MissingNode;

/**
 * @covers PPP\Module\DataModel\ModuleRequest
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleRequestTest extends \PHPUnit_Framework_TestCase {

	public function testGetLanguageCode() {
		$request = new ModuleRequest('en', new MissingNode(), 'a');
		$this->assertEquals('en', $request->getLanguageCode());
	}

	public function testGetSentenceTree() {
		$request = new ModuleRequest('en', new MissingNode(), 'a');
		$this->assertEquals(new MissingNode(), $request->getSentenceTree());
	}

	public function testGetRequestId() {
		$request = new ModuleRequest('en', new MissingNode(), 'a');
		$this->assertEquals('a', $request->getRequestId());
	}

	public function testGetMeasures() {
		$request = new ModuleRequest('en', new MissingNode(), 'a', array('accuracy' => 1), array('a'));
		$this->assertEquals(array('accuracy' => 1), $request->getMeasures());
	}

	public function testGetTrace() {
		$request = new ModuleRequest('en', new MissingNode(), 'a', array('accuracy' => 1), array('a'));
		$this->assertEquals(array('a'), $request->getTrace());
	}

	public function testEquals() {
		$request = new ModuleRequest('en', new MissingNode(), 'a', array('accuracy' => 1), array('a'));
		$this->assertTrue($request->equals(new ModuleRequest('en', new MissingNode(), 'a', array('accuracy' => 1))));
	}

	/**
	 * @dataProvider nonEqualsProvider
	 */
	public function testNonEquals(ModuleRequest $node, $target) {
		$this->assertFalse($node->equals($target));
	}

	public function nonEqualsProvider() {
		return array(
			array(
				new ModuleRequest('en', new MissingNode(), 'a', array('accuracy' => 1)),
				new MissingNode()
			),
			array(
				new ModuleRequest('en', new MissingNode(), 'a', array('accuracy' => 1)),
				new ModuleRequest('fr', new MissingNode(), 'a', array('accuracy' => 1))
			),
			array(
				new ModuleRequest('en', new MissingNode(), 'a', array('accuracy' => 1)),
				new ModuleRequest('en', new FirstNode(new MissingNode()), 'a', array('accuracy' => 1))
			),
			array(
				new ModuleRequest('en', new MissingNode(), 'a', array('accuracy' => 1)),
				new ModuleRequest('en', new MissingNode(), 'b', array('accuracy' => 1))
			),
			array(
				new ModuleRequest('en', new MissingNode(), 'a', array('accuracy' => 1)),
				new ModuleRequest('en', new MissingNode(), 'a', array('accuracy' => 0))
			),
		);
	}
}
