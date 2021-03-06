<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\MissingNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\StringResourceNode;
use PPP\DataModel\UnionNode;

/**
 * @covers PPP\Module\TreeSimplifier\DispatchingSimplifier
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class DispatchingSimplifierTest extends \PHPUnit_Framework_TestCase {

	protected function buildSimplifier() {
		return new DispatchingSimplifier(array(
			new SetOperatorNodeSimplifier()
		));
	}

	public function testImplementsNodeSimplifierInterface() {
		$this->assertInstanceOf('PPP\Module\TreeSimplifier\NodeSimplifier', $this->buildSimplifier());
	}

	public function testIsNodeSimplifierForReturnsTrue() {
		$this->assertTrue($this->buildSimplifier()->isSimplifierFor(new UnionNode(array())));
	}

	public function testIsNodeSimplifierForReturnsFalse() {
		$this->assertFalse($this->buildSimplifier()->isSimplifierFor(new MissingNode()));
	}

	public function testSimplification() {
		$this->assertEquals(
			new ResourceListNode(array(
				new StringResourceNode('foo'),
				new StringResourceNode('bar')
			)),
			$this->buildSimplifier()->simplify(new UnionNode(array(
				new ResourceListNode(array(new StringResourceNode('foo'))),
				new ResourceListNode(array(new StringResourceNode('bar')))
			)))
		);
	}
}
