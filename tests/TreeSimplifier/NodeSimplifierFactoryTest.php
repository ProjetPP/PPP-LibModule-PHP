<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\FirstNode;
use PPP\DataModel\IntersectionNode;
use PPP\DataModel\LastNode;
use PPP\DataModel\MissingNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\SortNode;
use PPP\DataModel\StringResourceNode;
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
				new FirstNode(new SortNode(new resourceListNode(), new StringResourceNode('foo'))),
				new MissingNode()
			),
			$factory->newNodeSimplifier()->simplify(new TripleNode(
				new UnionNode(array()),
				new FirstNode(new SortNode(
					new IntersectionNode(array(
						new LastNode(new ResourceListNode())
					)),
					new StringResourceNode('foo')
				)),
				new MissingNode()
			))
		);
	}
}
