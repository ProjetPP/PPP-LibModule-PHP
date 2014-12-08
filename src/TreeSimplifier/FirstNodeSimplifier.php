<?php

namespace PPP\Module\TreeSimplifier;

use InvalidArgumentException;
use PPP\DataModel\AbstractNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\FirstNode;

/**
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class FirstNodeSimplifier implements NodeSimplifier {

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
		return $node instanceof FirstNode;
	}

	/**
	 * @see NodeSimplifier::simplify
	 * @param FirstNode $node
	 */
	public function simplify(AbstractNode $node) {
		if(!$this->isSimplifierFor($node)) {
			throw new InvalidArgumentException('FirstNodeSimplifier can only simplify FirstNode');
		}

		$nodeSimplifier = $this->simplifierFactory->newNodeSimplifier();
		$operand = $nodeSimplifier->simplify($node->getOperand());

		if($operand instanceof ResourceListNode) {
			if($operand->isEmpty()) {
				return $operand;
			} else {
				$resources = $operand->toArray();
				return new ResourceListNode(array(reset($resources)));
			}
		} else {
			return new FirstNode($operand);
		}
	}
}
