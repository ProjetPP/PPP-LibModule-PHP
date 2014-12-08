<?php

namespace PPP\Module\TreeSimplifier;

use InvalidArgumentException;
use PPP\DataModel\AbstractNode;
use PPP\DataModel\SortNode;

class RecursiveSortNodeSimplifier implements NodeSimplifier {

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
		return $node instanceof SortNode;
	}

	/**
	 * @see NodeSimplifier::simplify
	 * @param SortNode $node
	 */
	public function simplify(AbstractNode $node) {
		if(!$this->isSimplifierFor($node)) {
			throw new InvalidArgumentException('RecursiveSortSimplifier can only simplify SortNode');
		}

		return new SortNode(
			$this->simplifierFactory->newNodeSimplifier()->simplify($node->getOperand()),
			$node->getPredicate()
		);
	}
}
