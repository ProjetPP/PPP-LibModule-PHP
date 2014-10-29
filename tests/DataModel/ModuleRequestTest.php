<?php

namespace PPP\Module\DataModel;

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
}
