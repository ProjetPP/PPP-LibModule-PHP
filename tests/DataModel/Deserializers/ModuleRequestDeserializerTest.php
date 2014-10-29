<?php

namespace PPP\Module\DataModel\Serializers;

use PPP\DataModel\Deserializers\MissingNodeDeserializer;
use PPP\DataModel\MissingNode;
use PPP\Module\DataModel\Deserializers\ModuleRequestDeserializer;
use PPP\Module\DataModel\ModuleRequest;

/**
 * @covers PPP\Module\DataModel\Serializers\ModuleResponseSerializer
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleRequestDeserializerTest extends \PHPUnit_Framework_TestCase {

	public function testDeserialize() {
		$deserializer = new ModuleRequestDeserializer(new MissingNodeDeserializer());
		$this->assertEquals(
			new ModuleRequest(
				'en',
				new MissingNode(),
				'a'
			),
			$deserializer->deserialize(array(
				'language' => 'en',
				'tree' => array('type' => 'missing'),
				'id' => 'a'
			))
		);
		$this->assertEquals(
			new ModuleRequest(
				'en',
				new MissingNode(),
				'a',
				array(),
				array('a')
			),
			$deserializer->deserialize(array(
				'language' => 'en',
				'tree' => array('type' => 'missing'),
				'id' => 'a',
				'trace' => array('a')
			))
		);
		$this->assertEquals(
			new ModuleRequest(
				'en',
				new MissingNode(),
				'a',
				array('accuracy' => 1)
			),
			$deserializer->deserialize(array(
				'language' => 'en',
				'tree' => array('type' => 'missing'),
				'id' => 'a',
				'measures' => array('accuracy' => 1)
			))
		);
	}
}
