<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\MissingNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\TripleNode;
use PPP\DataModel\UnionNode;

/**
 * @covers PPP\Module\TreeSimplifier\RecursiveTripleNodeSimplifier
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class RecursiveTripleNodeSimplifierTest extends NodeSimplifierBaseTest {

	protected function buildSimplifier() {
		return new RecursiveTripleNodeSimplifier(new NodeSimplifierFactory());
	}

	public function simplifiableProvider() {
		return array(
			array(
				new TripleNode(new MissingNode(), new MissingNode(), new MissingNode())
			)
		);
	}

	public function nonSimplifiableProvider() {
		return array(
			array(
				new MissingNode()
			)
		);
	}

	public function simplificationProvider() {
		return array(
			array(
				new TripleNode(new ResourceListNode(), new ResourceListNode(), new ResourceListNode()),
				new TripleNode(new UnionNode(array()), new UnionNode(array()), new UnionNode(array()))
			),
		);
	}
}
