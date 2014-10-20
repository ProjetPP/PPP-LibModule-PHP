<?php

namespace PPP\Module;

use PPP\DataModel\MissingNode;
use PPP\Module\DataModel\ModuleRequest;
use PPP\Module\DataModel\ModuleResponse;

/**
 * @covers PPP\Module\ModuleEntryPoint
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleEntryPointTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider responsesProvider
	 */
	public function testGetResponse(RequestHandler $handler, $request, $response) {
		$entryPointMock = $this->getMock('PPP\Module\ModuleEntryPoint', array('getRequestBody'), array($handler));
		$entryPointMock->expects($this->any())
			->method('getRequestBody')
			->will($this->returnValue($request));

		$entryPointMock->exec();

		$this->expectOutputString($response);
	}

	public function responsesProvider() {
		$tests = array();

		$handlerMock = $this->getMock('PPP\Module\RequestHandler');
		$handlerMock->expects($this->any())
			->method('buildResponse')
			->with($this->equalTo(new ModuleRequest('en', new MissingNode(), 'a')))
			->will($this->returnValue(array()));
		$tests[] = array(
			$handlerMock,
			'{"language":"en", "tree":{"type":"missing"}, "id":"a"}',
			'[]'
		);

		$handlerMock = $this->getMock('PPP\Module\RequestHandler');
		$handlerMock->expects($this->any())
			->method('buildResponse')
			->with($this->equalTo(new ModuleRequest('en', new MissingNode(), 'a')))
			->will($this->returnValue(array(new ModuleResponse('en', new MissingNode(), 0.5))));
		$tests[] = array(
			$handlerMock,
			'{"language":"en", "tree":{"type":"missing"}, "id":"a"}',
			'[{"language":"en","tree":{"type":"missing"},"pertinence":0.5,"trace":[]}]'
		);

		return $tests;
	}
}
