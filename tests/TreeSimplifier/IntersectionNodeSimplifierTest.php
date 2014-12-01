<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\IntersectionNode;
use PPP\DataModel\MissingNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\StringResourceNode;
use PPP\DataModel\UnionNode;

/**
 * @covers PPP\Module\TreeSimplifier\IntersectionNodeSimplifier
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class IntersectionNodeSimplifierTest extends NodeSimplifierBaseTest {

	protected function buildSimplifier() {
		return new IntersectionNodeSimplifier(new NodeSimplifierFactory());
	}

	public function simplifiableProvider() {
		return array(
			array(
				new IntersectionNode(array())
			)
		);
	}

	public function nonSimplifiableProvider() {
		return array(
			array(
				new UnionNode(array())
			)
		);
	}

	public function simplificationProvider() {
		return array(
			array(
				new ResourceListNode(array(
					new StringResourceNode('foo')
				)),
				new IntersectionNode(array(
					new ResourceListNode(array(
						new StringResourceNode('foo'),
						new StringResourceNode('bar')
					)),
					new ResourceListNode(array(new StringResourceNode('foo')))
				))
			),
			array(
				new ResourceListNode(),
				new IntersectionNode(array(
					new ResourceListNode(array(new StringResourceNode('foo'))),
					new ResourceListNode(array(new StringResourceNode('bar')))
				))
			),
			array(
				new IntersectionNode(array(
					new MissingNode(),
					new ResourceListNode(array(
						new StringResourceNode('foo')
					))
				)),
				new IntersectionNode(array(
					new IntersectionNode(array(
						new ResourceListNode(array(new StringResourceNode('foo'))),
						new ResourceListNode(array(new StringResourceNode('foo')))
					)),
					new MissingNode(),
					new ResourceListNode(array(new StringResourceNode('foo')))
				))
			),
			array(
				new IntersectionNode(array()),
				new IntersectionNode(array())
			),
		);
	}
}
