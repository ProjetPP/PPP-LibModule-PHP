<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\IntersectionNode;
use PPP\DataModel\MissingNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\TripleNode;
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
			new TripleNode(
				new ResourceListNode(),
				new resourceListNode(),
				new MissingNode()
			),
			$factory->newNodeSimplifier()->simplify(new TripleNode(
				new UnionNode(array()),
				new IntersectionNode(array(
					new ResourceListNode()
				)),
				new MissingNode()
			))
		);
	}
}
