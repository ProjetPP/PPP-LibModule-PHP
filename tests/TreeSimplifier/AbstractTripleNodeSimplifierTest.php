<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\MissingNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\SentenceNode;
use PPP\DataModel\StringResourceNode;
use PPP\DataModel\TripleNode;

/**
 * @covers PPP\Module\TreeSimplifier\AbstractTripleNodeSimplifier
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class AbstractTripleNodeSimplifierTest extends NodeSimplifierBaseTest {

	protected function buildSimplifier() {
		$mock = $this->getMockForAbstractClass('PPP\Module\TreeSimplifier\AbstractTripleNodeSimplifier', array(new NodeSimplifierFactory()));
		$mock->expects($this->any())
			->method('doSimplification')
			->with(
				$this->equalTo(new ResourceListNode(array())),
				$this->equalTo(new ResourceListNode(array(new StringResourceNode('aa')))),
				$this->equalTo(new MissingNode())
			)
			->will($this->returnValue(new MissingNode()));
		return $mock;
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
				new MissingNode(),
				new TripleNode(new ResourceListNode(array()), new StringResourceNode('aa'), new MissingNode())
			),
			array(
				new TripleNode(new SentenceNode(''), new MissingNode(), new MissingNode()),
				new TripleNode(new SentenceNode(''), new MissingNode(), new MissingNode())
			),
			array(
				new TripleNode(new MissingNode(), new SentenceNode(''), new MissingNode()),
				new TripleNode(new MissingNode(), new SentenceNode(''), new MissingNode())
			),
			array(
				new TripleNode(new MissingNode(), new MissingNode(), new SentenceNode('')),
				new TripleNode(new MissingNode(), new MissingNode(), new SentenceNode(''))
			),
		);
	}
}
