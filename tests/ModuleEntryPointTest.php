<?php

namespace PPP\Module;

use Exception;
use PPP\DataModel\MissingNode;
use PPP\DataModel\ResourceListNode;
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

		$handlerMock = $this->getMockForAbstractClass('PPP\Module\AbstractRequestHandler');
		$handlerMock->expects($this->any())
			->method('buildResponse')
			->with($this->equalTo(new ModuleRequest('en', new MissingNode(), 'a')))
			->will($this->returnValue(array()));
		$tests[] = array(
			$handlerMock,
			'{"language":"en","tree":{"type":"missing"},"id":"a"}',
			'[]'
		);

		$handlerMock = $this->getMockForAbstractClass('PPP\Module\AbstractRequestHandler');
		$handlerMock->expects($this->any())
			->method('buildResponse')
			->with($this->equalTo(new ModuleRequest('en', new MissingNode(), 'a')))
			->will($this->returnValue(array(new ModuleResponse(
				'en',
				new ResourceListNode(array(new StringResourceNode('p'))),
				array('accuracy' => 1)
			))));
		$tests[] = array(
			$handlerMock,
			'{"language":"en","tree":{"type":"missing"},"id":"a"}',
			'[{"language":"en","tree":{"type":"resource","value":"p","value-type":"string"},"measures":{"accuracy":1},"trace":[]}]'
		);

		$handlerMock = $this->getMockForAbstractClass('PPP\Module\AbstractRequestHandler');
		$handlerMock->expects($this->any())
			->method('buildResponse')
			->with($this->equalTo(new ModuleRequest('en', new MissingNode(), 'a')))
			->will($this->returnValue(array(
				new ModuleResponse(
					'en',
					new ResourceListNode(array(new StringResourceNode('p'))),
					array('accuracy' => 1)
				),
				new ModuleResponse(
					'en',
					new ResourceListNode(array(new StringResourceNode('p'))),
					array('accuracy' => 0.9)
				)
			)));
		$tests[] = array(
			$handlerMock,
			'{"language":"en","tree":{"type":"missing"},"id":"a"}',
			'[{"language":"en","tree":{"type":"resource","value":"p","value-type":"string"},"measures":{"accuracy":1},"trace":[]}]'
		);

		$handlerMock = $this->getMockForAbstractClass('PPP\Module\AbstractRequestHandler');
		$handlerMock->expects($this->any())
			->method('buildResponse')
			->with($this->equalTo(new ModuleRequest('en', new MissingNode(), 'a', array('accuracy' => 1))))
			->will($this->returnValue(array(new ModuleResponse('en', new ResourceListNode(array(new StringResourceNode('p')))))));
		$tests[] = array(
			$handlerMock,
			'{"language":"en","tree":{"type":"missing"},"measures":{"accuracy":1},"id":"a"}',
			'[{"language":"en","tree":{"type":"resource","value":"p","value-type":"string"},"measures":{"accuracy":1},"trace":[]}]'
		);

		$handlerMock = $this->getMockForAbstractClass('PPP\Module\AbstractRequestHandler');
		$handlerMock->expects($this->any())
			->method('buildResponse')
			->with($this->equalTo(new ModuleRequest(
				'en',
				new TripleNode(
					new ResourceListNode(array(new StringResourceNode('s'))),
					new ResourceListNode(array(new StringResourceNode('p'))),
					new ResourceListNode(array(new StringResourceNode('o')))
				),
				'a'
			)))
			->will($this->returnValue(array(new ModuleResponse(
				'en',
				new TripleNode(
					new ResourceListNode(array(new StringResourceNode('s1'))),
					new ResourceListNode(array(new StringResourceNode('p1'))),
					new ResourceListNode(array(new StringResourceNode('o1')))
				),
				array('accuracy' => 1)
			))));
		$tests[] = array(
			$handlerMock,
			'{"language":"en","tree":{"type":"triple","subject":{"type":"resource","value":"s","value-type":"string"},"predicate":{"type":"resource","value":"p","value-type":"string"},"object":{"type":"resource","value":"o","value-type":"string"}},"id":"a"}',
			'[{"language":"en","tree":{"type":"triple","subject":{"type":"resource","value":"s1","value-type":"string"},"predicate":{"type":"resource","value":"p1","value-type":"string"},"object":{"type":"resource","value":"o1","value-type":"string"}},"measures":{"accuracy":1},"trace":[]}]'
		);

		return $tests;
	}

	public function testWithInvalidRequest() {
		$handlerMock = $this->getMockForAbstractClass('PPP\Module\AbstractRequestHandler');
		$entryPointMock = $this->getMock('PPP\Module\ModuleEntryPoint', array('getRequestBody'), array($handlerMock));
		$entryPointMock->expects($this->any())
			->method('getRequestBody')
			->will($this->returnValue('{}'));

		$entryPointMock->exec();

		$this->expectOutputString('The serialization is invalid!');
	}

	public function testWithRequestHandlerException() {
		$handlerMock = $this->getMockForAbstractClass('PPP\Module\AbstractRequestHandler');
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
