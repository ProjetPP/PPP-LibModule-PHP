<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\IntersectionNode;
use PPP\DataModel\MissingNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\StringResourceNode;
use PPP\DataModel\UnionNode;

/**
 * @covers PPP\Module\TreeSimplifier\UnionNodeSimplifier
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class UnionNodeSimplifierTest extends NodeSimplifierBaseTest {

	protected function buildSimplifier() {
		return new UnionNodeSimplifier(new NodeSimplifierFactory());
	}

	public function simplifiableProvider() {
		return array(
			array(
				new UnionNode(array())
			)
		);
	}

	public function nonSimplifiableProvider() {
		return array(
			array(
				new IntersectionNode(array())
			)
		);
	}

	public function simplificationProvider() {
		return array(
			array(
				new ResourceListNode(array(
					new StringResourceNode('foo'),
					new StringResourceNode('bar')
				)),
				new UnionNode(array(
					new StringResourceNode('foo'),
					new ResourceListNode(array(
						new StringResourceNode('foo'),
						new StringResourceNode('bar')
					))
				)),
			),
			array(
				new UnionNode(array(
					new MissingNode(),
					new ResourceListNode(array(
						new StringResourceNode('foo'),
						new StringResourceNode('bar'),
						new StringResourceNode('oo')
					))
				)),
				new UnionNode(array(
					new StringResourceNode('foo'),
					new StringResourceNode('bar'),
					new MissingNode(),
					new StringResourceNode('oo')
				))
			),
			array(
				new ResourceListNode(array(
					new StringResourceNode('bar')
				)),
				new UnionNode(array(
					new UnionNode(array(
						new StringResourceNode('bar')
					))
				))
			)
		);
	}
}
