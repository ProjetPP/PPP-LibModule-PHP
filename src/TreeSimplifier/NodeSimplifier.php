<?php

namespace PPP\Module\TreeSimplifier;

use PPP\DataModel\AbstractNode;

/**
 * Interface for simplifiers
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
interface NodeSimplifier {

	/**
	 * @param AbstractNode $node
	 * @return bool
	 */
	public function isSimplifierFor(AbstractNode $node);

	/**
	 * @param AbstractNode $node
	 * @return AbstractNode
	 */
	public function simplify(AbstractNode $node);
}
