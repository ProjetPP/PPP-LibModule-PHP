<?php

namespace PPP\Module\TreeSimplifier;

/**
 * Build a NodeSimplifier for query trees
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class NodeSimplifierFactory {

	/**
	 * @var NodeSimplifier
	 */
	private $nodeSimplifier;

	/**
	 * @param NodeSimplifier[] $additionalSimplifiers
	 */
	public function __construct(array $additionalSimplifiers = array()) {
		$this->nodeSimplifier = $this->buildNodeSimplifier($additionalSimplifiers);
	}

	private function buildNodeSimplifier(array $additionalSimplifiers) {
		return new DispatchingSimplifier(
			array_merge(
				array(
					new SetOperatorNodeSimplifier()
				),
				$additionalSimplifiers,
				array(
					new FirstNodeSimplifier($this),
					new LastNodeSimplifier($this),
					new RecursiveOperatorNodeSimplifier($this),
					new SetOperatorNodeSimplifier(),
					new RecursiveSortNodeSimplifier($this),
					new RecursiveTripleNodeSimplifier($this)
				)
			)
		);
	}

	/**
	 * @return NodeSimplifier
	 */
	public function newNodeSimplifier() {
		return $this->nodeSimplifier;
	}
}
