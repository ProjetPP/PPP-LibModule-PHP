<?php

namespace PPP\Module\DataModel\Serializers;

use PPP\DataModel\Serializers\MissingNodeSerializer;
use PPP\DataModel\MissingNode;
use PPP\Module\DataModel\ModuleRequest;

/**
 * @covers PPP\Module\DataModel\Serializers\ModuleRequestSerializerTest
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleRequestSerializerTest extends \PHPUnit_Framework_TestCase {

	public function testSerialize() {
		$serializer = new ModuleRequestSerializer(new MissingNodeSerializer());
		$this->assertEquals(
			array(
				'language' => 'en',
				'tree' => array('type' => 'missing'),
				'id' => 'a',
				'measures' => (object) array('accuracy' => 1),
				'trace' => array('a')
			),
			$serializer->serialize(new ModuleRequest(
				'en',
				new MissingNode(),
				'a',
				array('accuracy' => 1),
				array('a')
			))
		);
	}
}
