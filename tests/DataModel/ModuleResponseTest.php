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
		$response = new ModuleResponse('en', new MissingNode(), 0.5);
		$this->assertEquals('en', $response->getLanguageCode());
	}

	public function testGetSentenceTree() {
		$response = new ModuleResponse('en', new MissingNode(), 0.5);
		$this->assertEquals(new MissingNode(), $response->getSentenceTree());
	}

	public function testGetPertinence() {
		$response = new ModuleResponse('en', new MissingNode(), 0.5);
		$this->assertEquals(0.5, $response->getPertinence());
	}
}
