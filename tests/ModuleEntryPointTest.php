<?php

namespace PPP\Module;

use Exception;
use PPP\DataModel\MissingNode;
use PPP\DataModel\StringResourceNode;
use PPP\DataModel\TripleNode;
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
			'{"language":"en","tree":{"type":"missing"},"id":"a"}',
			'[]'
		);

		$handlerMock = $this->getMock('PPP\Module\RequestHandler');
		$handlerMock->expects($this->any())
			->method('buildResponse')
			->with($this->equalTo(new ModuleRequest('en', new MissingNode(), 'a')))
			->will($this->returnValue(array(new ModuleResponse('en', new MissingNode(), array('accuracy' => 1)))));
		$tests[] = array(
			$handlerMock,
			'{"language":"en","tree":{"type":"missing"},"id":"a"}',
			'[{"language":"en","tree":{"type":"missing"},"measures":{"accuracy":1},"trace":[]}]'
		);

		$handlerMock = $this->getMock('PPP\Module\RequestHandler');
		$handlerMock->expects($this->any())
			->method('buildResponse')
			->with($this->equalTo(new ModuleRequest('en', new MissingNode(), 'a', array('accuracy' => 1))))
			->will($this->returnValue(array(new ModuleResponse('en', new MissingNode()))));
		$tests[] = array(
			$handlerMock,
			'{"language":"en","tree":{"type":"missing"},"measures":{"accuracy":1},"id":"a"}',
			'[{"language":"en","tree":{"type":"missing"},"measures":{"accuracy":1},"trace":[]}]'
		);

		$handlerMock = $this->getMock('PPP\Module\RequestHandler');
		$handlerMock->expects($this->any())
			->method('buildResponse')
			->with($this->equalTo(new ModuleRequest(
				'en',
				new TripleNode(new StringResourceNode('s'), new StringResourceNode('p'), new StringResourceNode('o')),
				'a'
			)))
			->will($this->returnValue(array(new ModuleResponse(
				'en',
				new TripleNode(new StringResourceNode('s'), new StringResourceNode('p'), new StringResourceNode('o')),
				array('accuracy' => 1)
			))));
		$tests[] = array(
			$handlerMock,
			'{"language":"en","tree":{"type":"triple","subject":{"type":"resource","value":"s","value-type":"string"},"predicate":{"type":"resource","value":"p","value-type":"string"},"object":{"type":"resource","value":"o","value-type":"string"}},"id":"a"}',
			'[{"language":"en","tree":{"type":"triple","subject":{"type":"resource","value":"s","value-type":"string"},"predicate":{"type":"resource","value":"p","value-type":"string"},"object":{"type":"resource","value":"o","value-type":"string"}},"measures":{"accuracy":1},"trace":[]}]'
		);

		return $tests;
	}

	public function testWithInvalidRequest() {
		$handlerMock = $this->getMock('PPP\Module\RequestHandler');
		$entryPointMock = $this->getMock('PPP\Module\ModuleEntryPoint', array('getRequestBody'), array($handlerMock));
		$entryPointMock->expects($this->any())
			->method('getRequestBody')
			->will($this->returnValue('{}'));

		$entryPointMock->exec();

		$this->expectOutputString('The serialization is invalid!');
	}

	public function testWithRequestHandlerException() {
		$handlerMock = $this->getMock('PPP\Module\RequestHandler');
		$handlerMock->expects($this->any())
			->method('buildResponse')
			->with($this->equalTo(new ModuleRequest('en', new MissingNode(), 'a')))
			->will($this->throwException(new Exception('foo')));

		$entryPointMock = $this->getMock('PPP\Module\ModuleEntryPoint', array('getRequestBody'), array($handlerMock));
		$entryPointMock->expects($this->any())
			->method('getRequestBody')
			->will($this->returnValue('{"language":"en","tree":{"type":"missing"},"id":"a"}'));

		$entryPointMock->exec();

		$this->expectOutputString('foo');
	}
}
