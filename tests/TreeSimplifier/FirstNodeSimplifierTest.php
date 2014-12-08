<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\IntersectionNode;
use PPP\DataModel\MissingNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\StringResourceNode;
use PPP\DataModel\FirstNode;

/**
 * @covers PPP\Module\TreeSimplifier\FirstNodeSimplifier
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class FirstNodeSimplifierTest extends NodeSimplifierBaseTest {

	protected function buildSimplifier() {
		return new FirstNodeSimplifier(new NodeSimplifierFactory());
	}

	public function simplifiableProvider() {
		return array(
			array(
				new FirstNode(new ResourceListNode(array()))
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
					new StringResourceNode('foo')
				)),
				new FirstNode(new ResourceListNode(array(
					new StringResourceNode('foo'),
					new StringResourceNode('bar')
				)))
			),
			array(
				new ResourceListNode(array()),
				new FirstNode(new ResourceListNode(array()))
			),
			array(
				new FirstNode(new MissingNode()),
				new FirstNode(new MissingNode())
			),
		);
	}
}
