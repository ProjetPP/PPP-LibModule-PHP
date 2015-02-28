<?php

namespace PPP\Module\TreeSimplifier;

use InvalidArgumentException;
use PPP\DataModel\AbstractNode;
use PPP\DataModel\OperatorNode;

/**
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class RecursiveOperatorNodeSimplifier implements NodeSimplifier {

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
		return $node instanceof OperatorNode;
	}

	/**
	 * @see NodeSimplifier::simplify
	 * @param OperatorNode $node
	 */
	public function simplify(AbstractNode $node) {
		if(!$this->isSimplifierFor($node)) {
			throw new InvalidArgumentException('RecursiveOperatorNodeSimplifier can only simplify OperatorNode');
		}

		$nodeSimplifier = $this->simplifierFactory->newNodeSimplifier();

		$operands = array();
		foreach($node->getOperands() as $operand) {
			$operands[] = $nodeSimplifier->simplify($operand);
		}

		$class = get_class($node);
		return new $class($operands);
	}
}
