<?php

namespace PPP\Module\TreeSimplifier;

use InvalidArgumentException;
use PPP\DataModel\AbstractNode;
use PPP\DataModel\TripleNode;

class RecursiveTripleNodeSimplifier implements NodeSimplifier {

	/**
	 * @var NodeSimplifierFactory
	 */
	private $simplifierFactory;

	/**
	 * @param NodeSimplifierFactory $simplifierFactory
	 */
	public function __construct(NodeSimplifierFactory $simplifierFactory) {
		$this->simplifierFactory = $simplifierFactory;
	}

	/**
	 * @see NodeSimplifier::isSimplifierFor
	 */
	public function isSimplifierFor(AbstractNode $node) {
		return $node instanceof TripleNode;
	}

	/**
	 * @see NodeSimplifier::simplify
	 * @param TripleNode $node
	 */
	public function simplify(AbstractNode $node) {
		if(!$this->isSimplifierFor($node)) {
			throw new InvalidArgumentException('RecursiveTripleSimplifier can only simplify TripleNode');
		}

		return new TripleNode(
			$this->simplifierFactory->newNodeSimplifier()->simplify($node->getSubject()),
			$this->simplifierFactory->newNodeSimplifier()->simplify($node->getPredicate()),
			$this->simplifierFactory->newNodeSimplifier()->simplify($node->getObject())
		);
	}
}
