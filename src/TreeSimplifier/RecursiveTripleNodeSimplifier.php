<?php

namespace PPP\Module\TreeSimplifier;

use InvalidArgumentException;
use PPP\DataModel\AbstractNode;
use PPP\DataModel\MissingNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\ResourceNode;
use PPP\DataModel\TripleNode;

abstract class AbstractTripleNodeSimplifier implements NodeSimplifier {

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
			throw new InvalidArgumentException('TripleSimplifier can only simplify TripleNode');
		}

		$subject = $this->cleanArgument($node->getSubject());
		$predicate = $this->cleanArgument($node->getPredicate());
		$object = $this->cleanArgument($node->getObject());

		if(
			$this->isValidArgument($subject) &&
			$this->isValidArgument($predicate) &&
			$this->isValidArgument($object)
		) {
			return $this->doSimplification($subject, $predicate, $object);
		}

		return $node;
	}

	/**
	 * @param ResourceListNode|MissingNode $subject
	 * @param ResourceListNode|MissingNode $predicate
	 * @param ResourceListNode|MissingNode $object
	 * @return AbstractNode
	 */
	protected abstract function doSimplification(AbstractNode $subject, AbstractNode $predicate, AbstractNode $object);

	private function cleanArgument(AbstractNode $node) {
		$node = $this->simplifierFactory->newNodeSimplifier()->simplify($node);
		if($node instanceof ResourceNode) {
			return new ResourceListNode(array($node));
		}

		return $node;
	}

	private function isValidArgument(AbstractNode $node) {
		return $node instanceof ResourceListNode || $node instanceof MissingNode;
	}
}
