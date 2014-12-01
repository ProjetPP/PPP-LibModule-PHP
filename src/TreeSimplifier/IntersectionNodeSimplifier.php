<?php

namespace PPP\Module\TreeSimplifier;

use InvalidArgumentException;
use PPP\DataModel\AbstractNode;
use PPP\DataModel\IntersectionNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\ResourceNode;

/**
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class IntersectionNodeSimplifier implements NodeSimplifier {

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
		return $node instanceof IntersectionNode;
	}

	/**
	 * @see NodeSimplifier::simplify
	 * @param IntersectionNode $node
	 */
	public function simplify(AbstractNode $node) {
		if(!$this->isSimplifierFor($node)) {
			throw new InvalidArgumentException('UnionNodeSimplifier can only simplify IntersectionNode');
		}

		$nodeSimplifier = $this->simplifierFactory->newNodeSimplifier();
		$resourceLists = array();
		$otherOperands = array();

		foreach($node->getOperands() as $operand) {
			$operand = $nodeSimplifier->simplify($operand);
			if($operand instanceof ResourceListNode) {
				$resourceLists[] = $operand;
			} else {
				$otherOperands[] = $operand;
			}
		}

		if(empty($resourceLists)) {
			return new IntersectionNode($otherOperands);
		}

		$resourceList = $this->doIntersection($resourceLists);

		if(empty($otherOperands) || $resourceList->count() === 0) {
			return $resourceList;
		}

		$otherOperands[] = $resourceList;
		return new IntersectionNode($otherOperands);
	}

	private function doIntersection(array $lists) {
		$result = iterator_to_array(reset($lists));
		foreach($lists as $list) {
			$result = $this->intersect($result, $list);
		}

		return new ResourceListNode($result);
	}

	private function intersect(array $list1, ResourceListNode $list2) {
		$resources = array();

		foreach($list1 as $resource) {
			if($list2->hasResource($resource)) {
				$resources[] = $resource;
			}
		}

		return $resources;
	}
}
