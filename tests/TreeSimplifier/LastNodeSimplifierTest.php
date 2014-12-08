<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\IntersectionNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\StringResourceNode;
use PPP\DataModel\LastNode;

/**
 * @covers PPP\Module\TreeSimplifier\LastNodeSimplifier
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class LastNodeSimplifierTest extends NodeSimplifierBaseTest {

	protected function buildSimplifier() {
		return new LastNodeSimplifier(new NodeSimplifierFactory());
	}

	public function simplifiableProvider() {
		return array(
			array(
				new LastNode(new ResourceListNode(array()))
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
					new StringResourceNode('bar')
				)),
				new LastNode(new ResourceListNode(array(
					new StringResourceNode('foo'),
					new StringResourceNode('bar')
				)))
			),
			array(
				new ResourceListNode(array()),
				new LastNode(new ResourceListNode(array()))
			)
		);
	}
}
