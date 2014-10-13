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
		$response = new ModuleRequest('en', new MissingNode(), 'a');
		$this->assertEquals('en', $response->getLanguageCode());
	}

	public function testGetSentenceTree() {
		$response = new ModuleRequest('en', new MissingNode(), 'a');
		$this->assertEquals(new MissingNode(), $response->getSentenceTree());
	}

	public function testGetRequestId() {
		$response = new ModuleRequest('en', new MissingNode(), 'a');
		$this->assertEquals('a', $response->getRequestId());
	}
}
