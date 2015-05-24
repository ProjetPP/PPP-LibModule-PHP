<?php

namespace PPP\Module\DataModel\Deserializers;

use PPP\DataModel\MissingNode;
use PPP\DataModel\Deserializers\MissingNodeDeserializer;
use PPP\Module\DataModel\ModuleResponse;

/**
 * @covers PPP\Module\DataModel\Deserializers\ModuleResponseDeserializer
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleResponseDeserializerTest extends \PHPUnit_Framework_TestCase {

	public function testDeserialize() {
		$deserializer = new ModuleResponseDeserializer(new MissingNodeDeserializer());
		$this->assertEquals(
			new ModuleResponse(
				'en',
				new MissingNode(),
				array('accuracy' => 1),
				array('a')
			)
			,
			$deserializer->deserialize(array(
				'language' => 'en',
				'tree' => array('type' => 'missing'),
				'measures' => array('accuracy' => 1),
				'trace' => array('a')
			))
		);
	}
}
