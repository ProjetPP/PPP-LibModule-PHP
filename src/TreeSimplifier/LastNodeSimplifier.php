<?php

namespace PPP\Module\TreeSimplifier;

use InvalidArgumentException;
use PPP\DataModel\AbstractNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\LastNode;

/**
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class LastNodeSimplifier implements NodeSimplifier {

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
		return $node instanceof LastNode;
	}

	/**
	 * @see NodeSimplifier::simplify
	 * @param LastNode $node
	 */
	public function simplify(AbstractNode $node) {
		if(!$this->isSimplifierFor($node)) {
			throw new InvalidArgumentException('LastNodeSimplifier can only simplify LastNode');
		}

		$nodeSimplifier = $this->simplifierFactory->newNodeSimplifier();
		$operand = $nodeSimplifier->simplify($node->getOperand());

		if($operand instanceof ResourceListNode) {
			if($operand->isEmpty()) {
				return $operand;
			} else {
				$resources = $operand->toArray();
				return new ResourceListNode(array(end($resources)));
			}
		} else {
			return new LastNode($operand);
		}
	}
}
