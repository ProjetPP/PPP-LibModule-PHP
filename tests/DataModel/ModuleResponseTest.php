<?php

namespace PPP\Module\DataModel;

use PPP\DataModel\MissingNode;

/**
 * @covers PPP\Module\DataModel\ModuleResponse
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleResponseTest extends \PHPUnit_Framework_TestCase {

	public function testGetLanguageCode() {
		$response = new ModuleResponse('en', new MissingNode());
		$this->assertEquals('en', $response->getLanguageCode());
	}

	public function testGetSentenceTree() {
		$response = new ModuleResponse('en', new MissingNode());
		$this->assertEquals(new MissingNode(), $response->getSentenceTree());
	}

	public function testGetMeasures() {
		$response = new ModuleResponse('en', new MissingNode(), array('accuracy' => 1));
		$this->assertEquals(array('accuracy' => 1), $response->getMeasures());
	}

	public function testGetTrace() {
		$response = new ModuleResponse('en', new MissingNode(), array('accuracy' => 1), array('a'));
		$this->assertEquals(array('a'), $response->getTrace());
	}
}
