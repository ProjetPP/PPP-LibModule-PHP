<?php

namespace PPP\Module\TreeSimplifier;

use InvalidArgumentException;
use PPP\DataModel\AbstractNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\ResourceNode;
use PPP\DataModel\UnionNode;

/**
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class UnionNodeSimplifier implements NodeSimplifier {

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
		return $node instanceof UnionNode;
	}

	/**
	 * @see NodeSimplifier::simplify
	 * @param UnionNode $node
	 */
	public function simplify(AbstractNode $node) {
		if(!$this->isSimplifierFor($node)) {
			throw new InvalidArgumentException('UnionNodeSimplifier can only simplify UnionNode');
		}

		$nodeSimplifier = $this->simplifierFactory->newNodeSimplifier();
		$resources = array();
		$otherOperands = array();

		foreach($node->getOperands() as $operand) {
			$operand = $nodeSimplifier->simplify($operand);
			if($operand instanceof ResourceListNode) {
				$resources[] = $operand;
			} else {
				$otherOperands[] = $operand;
			}
		}

		if(empty($otherOperands)) {
			return new ResourceListNode($resources);
		}

		if(!empty($resources)) {
			$otherOperands[] = new ResourceListNode($resources);
		}
		return new UnionNode($otherOperands);
	}
}
