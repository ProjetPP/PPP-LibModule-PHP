<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\ResourceListNode;
use PPP\DataModel\StringResourceNode;
use PPP\DataModel\UnionNode;

/**
 * @covers PPP\Module\TreeSimplifier\NodeSimplifierFactory
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class NodeSimplifierFactoryTest extends \PHPUnit_Framework_TestCase {

	public function testNewNodeSimplifier() {
		$factory = new NodeSimplifierFactory();

		$this->assertEquals(
			new ResourceListNode(array(
				new StringResourceNode('foo'),
				new StringResourceNode('bar')
			)),
			$factory->newNodeSimplifier()->simplify(new UnionNode(array(
				new ResourceListNode(array(new StringResourceNode('foo'))),
				new ResourceListNode(array(new StringResourceNode('bar')))
			)))
		);
	}
}
