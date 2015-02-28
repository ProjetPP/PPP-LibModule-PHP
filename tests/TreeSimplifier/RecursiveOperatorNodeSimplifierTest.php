<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\FirstNode;
use PPP\DataModel\IntersectionNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\StringResourceNode;
use PPP\DataModel\UnionNode;

/**
 * @covers PPP\Module\TreeSimplifier\RecursiveOperatorNodeSimplifier
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class RecursiveOperatorNodeSimplifierTest extends NodeSimplifierBaseTest {

	protected function buildSimplifier() {
		return new RecursiveOperatorNodeSimplifier(new NodeSimplifierFactory());
	}

	public function simplifiableProvider() {
		return array(
			array(
				new UnionNode(array())
			),
			array(
				new IntersectionNode(array())
			)
		);
	}

	public function nonSimplifiableProvider() {
		return array(
			array(
				new FirstNode(array())
			)
		);
	}

	public function simplificationProvider() {
		return array(
			array(
				new UnionNode(array(
					new ResourceListNode(array(new StringResourceNode('foo')))
				)),
				new UnionNode(array(
					new FirstNode(new ResourceListNode(array(new StringResourceNode('foo'))))
				))
			),
			array(
				new IntersectionNode(array(
					new ResourceListNode(array(new StringResourceNode('foo')))
				)),
				new IntersectionNode(array(
					new FirstNode(new ResourceListNode(array(new StringResourceNode('foo'))))
				))
			)
		);
	}
}
