<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\FirstNode;
use PPP\DataModel\IntersectionNode;
use PPP\DataModel\LastNode;
use PPP\DataModel\MissingNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\StringResourceNode;
use PPP\DataModel\TripleNode;
use PPP\DataModel\UnionNode;

/**
 * @covers PPP\Module\TreeSimplifier\SetOperatorNodeSimplifier
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class SetOperatorNodeSimplifierTest extends NodeSimplifierBaseTest {

	protected function buildSimplifier() {
		return new SetOperatorNodeSimplifier();
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
				new MissingNode()
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
					new ResourceListNode(array(new StringResourceNode('foo'))),
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
						new StringResourceNode('bar')
					))
				)),
				new UnionNode(array(
					new ResourceListNode(array(new StringResourceNode('foo'))),
					new MissingNode(),
					new ResourceListNode(array(new StringResourceNode('bar')))
				))
			),
			array(
				new ResourceListNode(array(
					new StringResourceNode('bar')
				)),
				new UnionNode(array(
					new UnionNode(array(
						new ResourceListNode(array(new StringResourceNode('bar')))
					))
				))
			),
			array(
				new ResourceListNode(),
				new UnionNode(array())
			),
			array(
				new ResourceListNode(array(new StringResourceNode('foo'))),
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
					new ResourceListNode(array(new StringResourceNode('foo') ))
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
			array(
				new ResourceListNode(array(new StringResourceNode('baz'))),
				new IntersectionNode(array(
					new UnionNode(array(
						new ResourceListNode(array(new StringResourceNode('baz')))
					))
				))
			),
			array(
				new UnionNode(array(
					new IntersectionNode(array(
						new FirstNode(new ResourceListNode()),
						new ResourceListNode(array(new StringResourceNode('baz')))
					)),
					new IntersectionNode(array(
						new LastNode(new ResourceListNode()),
						new ResourceListNode(array(new StringResourceNode('baz')))
					)),
				)),
				new IntersectionNode(array(
					new UnionNode(array(
						new FirstNode(new ResourceListNode()),
						new LastNode(new ResourceListNode())
					)),
					new ResourceListNode(array(new StringResourceNode('baz'))),
				))
			),
			array(
				new UnionNode(array(
					new IntersectionNode(array(
						new FirstNode(new ResourceListNode()),
						new ResourceListNode(array(new StringResourceNode('baz')))
					)),
					new IntersectionNode(array(
						new LastNode(new ResourceListNode()),
						new ResourceListNode(array(new StringResourceNode('baz')))
					)),
				)),
				new IntersectionNode(array(
					new UnionNode(array(
						new FirstNode(new ResourceListNode()),
						new LastNode(new ResourceListNode())
					)),
					new UnionNode(array(
						new ResourceListNode(array(new StringResourceNode('baz')))
					)),
				))
			),
			array(
				new UnionNode(array(
					new TripleNode(
						new MissingNode(),
						new ResourceListNode(array(
							new StringResourceNode('bar'),
							new StringResourceNode('baz'))
						),
						new ResourceListNode(array(new StringResourceNode('foo')))
					),
					new TripleNode(
						new ResourceListNode(array(new StringResourceNode('foo')))
						new ResourceListNode(array(
							new StringResourceNode('bar1'),
							new StringResourceNode('baz1'))
						),
						new MissingNode()
					)
				)),
				new UnionNode(array(
					new TripleNode(
						new MissingNode(),
						new ResourceListNode(array(
							new StringResourceNode('bar'),
							new StringResourceNode('baz'))
						),
						new ResourceListNode(array(new StringResourceNode('foo')))
					),
					new TripleNode(
						new ResourceListNode(array(new StringResourceNode('foo')))
						new ResourceListNode(array(
							new StringResourceNode('bar1'),
							new StringResourceNode('baz1'))
						),
						new MissingNode()
					)
				))
			)
		);
	}
}
