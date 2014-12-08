<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\MissingNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\SortNode;
use PPP\DataModel\StringResourceNode;
use PPP\DataModel\UnionNode;

/**
 * @covers PPP\Module\TreeSimplifier\RecursiveSortNodeSimplifier
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class RecursiveSortNodeSimplifierTest extends NodeSimplifierBaseTest {

	protected function buildSimplifier() {
		return new RecursiveSortNodeSimplifier(new NodeSimplifierFactory());
	}

	public function simplifiableProvider() {
		return array(
			array(
				new SortNode(new MissingNode(), new StringResourceNode('foo'))
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
				new SortNode(new ResourceListNode(), new StringResourceNode('foo')),
				new SortNode(new UnionNode(array()), new StringResourceNode('foo'))
			),
		);
	}
}
