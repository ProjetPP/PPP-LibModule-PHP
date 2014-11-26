<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\AbstractNode;

/**
 * Runs NodeSimplifiers as much as possible on the tree.
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class DispatchingSimplifier implements NodeSimplifier {

	/**
	 * @var NodeSimplifier[]
	 */
	private $simplifiers;

	/**
	 * @param NodeSimplifier[] $simplifiers
	 */
	public function __construct(array $simplifiers = array()) {
		$this->simplifiers = $simplifiers;
	}

	/**
	 * @see NodeSimplifier::sSimplifierFor
	 */
	public function isSimplifierFor(AbstractNode $node) {
		foreach($this->simplifiers as $simplifier) {
			if($simplifier->isSimplifierFor($node)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param AbstractNode $node
	 * @return AbstractNode
	 */
	public function simplify(AbstractNode $node) {
		do {
			$oldNode = $node;
			$node = $this->doDispatchedSimplification($node);
		} while(!$oldNode->equals($node));

		return $node;
	}

	private function doDispatchedSimplification(AbstractNode $node) {
		foreach($this->simplifiers as $simplifier) {
			if($simplifier->isSimplifierFor($node)) {
				$node = $simplifier->simplify($node);
			}
		}

		return $node;
	}
}
