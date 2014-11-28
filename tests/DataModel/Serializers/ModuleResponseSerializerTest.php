<?php

namespace PPP\Module\DataModel\Serializers;

use PPP\DataModel\MissingNode;
use PPP\DataModel\Serializers\MissingNodeSerializer;
use PPP\Module\DataModel\ModuleResponse;

/**
 * @covers PPP\Module\DataModel\Serializers\ModuleResponseSerializer
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleResponseSerializerTest extends \PHPUnit_Framework_TestCase {

	public function testSerialize() {
		$serializer = new ModuleResponseSerializer(new MissingNodeSerializer());
		$this->assertEquals(
			array(
				'language' => 'en',
				'tree' => array('type' => 'missing'),
				'measures' => (object) array('accuracy' => 1),
				'trace' => array('a')
			),
			$serializer->serialize(new ModuleResponse(
				'en',
				new MissingNode(),
				array('accuracy' => 1),
				array('a')
			))
		);
	}
}
