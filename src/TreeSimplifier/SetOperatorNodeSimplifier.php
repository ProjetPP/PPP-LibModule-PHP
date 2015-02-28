<?php

namespace PPP\Module\TreeSimplifier;

use InvalidArgumentException;
use PPP\DataModel\AbstractNode;
use PPP\DataModel\IntersectionNode;
use PPP\DataModel\ResourceListNode;
use PPP\DataModel\UnionNode;

/**
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class SetOperatorNodeSimplifier implements NodeSimplifier {

	/**
	 * @see NodeSimplifier::isSimplifierFor
	 */
	public function isSimplifierFor(AbstractNode $node) {
		return $node instanceof IntersectionNode || $node instanceof UnionNode;
	}

	/**
	 * @see NodeSimplifier::simplify
	 */
	public function simplify(AbstractNode $node) {
		if($node instanceof UnionNode) {
			return $this->simplifyUnionNode($node);
		} elseif($node instanceof IntersectionNode) {
			return $this->simplifyIntersectionNode($node);
		} else {
			throw new InvalidArgumentException('SetOperatorNodeSimplifier can only simplify UnionNode and IntersectionNode');
		}
	}

	private function simplifyUnionNode(UnionNode $node) {
		$simplifiedOperands = $this->simplifyUnionOperands($this->getUnionOperands($node));

		switch(count($simplifiedOperands)) {
			case 0:
				return new ResourceListNode();
			case 1:
				return reset($simplifiedOperands);
			default:
				return new UnionNode($simplifiedOperands);
		}
	}

	private function getUnionOperands(UnionNode $node) {
		$operands = array();

		foreach($node->getOperands() as $operand) {
			if($operand instanceof IntersectionNode) {
				$operand = $this->simplifyIntersectionNode($operand);
			}

			if($operand instanceof UnionNode) {
				$operands = array_merge($operands, $this->getUnionOperands($operand));
			} else {
				$operands[] = $operand;
			}
		}

		return $operands;
	}

	private function simplifyUnionOperands(array $operands) {
		list($resourceLists, $otherOperands) = $this->filterOperandsByType($operands, 'list');

		if(!empty($resourceLists)) {
			$otherOperands[] = new ResourceListNode($resourceLists);
		}

		return $otherOperands;
	}

	private function filterOperandsByType(array $operands, $type) {
		$filteredOperands = array();
		$otherOperands = array();

		/** @var AbstractNode $operand */
		foreach($operands as $operand) {
			if($operand->getType() === $type) {
				$filteredOperands[] = $operand;
			} else {
				$otherOperands[] = $operand;
			}
		}

		return array($filteredOperands, $otherOperands);
	}

	private function simplifyIntersectionNode(IntersectionNode $node) {
		$node = $this->simplifyLazilyIntersectionNode($node);

		if($node instanceof IntersectionNode) {
			return $this->moveUnionUnderIntersection($node);
		} else {
			return $node;
		}
	}

	private function simplifyLazilyIntersectionNode(IntersectionNode $node) {
		$simplifiedOperands = $this->simplifyIntersectionOperands($this->getIntersectionOperands($node));

		if(count($simplifiedOperands) === 1) {
			return reset($simplifiedOperands);
		}

		return new IntersectionNode($simplifiedOperands);
	}

	private function getIntersectionOperands(IntersectionNode $node) {
		$operands = array();

		foreach($node->getOperands() as $operand) {
			if($operand instanceof UnionNode) {
				$operand = $this->simplifyUnionNode($operand);
			}

			if($operand instanceof IntersectionNode) {
				$operands = array_merge($operands, $this->getIntersectionOperands($operand));
			} else {
				$operands[] = $operand;
			}
		}

		return $operands;
	}

	private function simplifyIntersectionOperands(array $operands) {
		list($resourceLists, $otherOperands) = $this->filterOperandsByType($operands, 'list');

		if(!empty($resourceLists)) {
			$otherOperands[] = $this->doIntersection($resourceLists);
		}

		return $otherOperands;
	}

	private function doIntersection(array $lists) {
		$result = reset($lists)->toArray();
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

	private function moveUnionUnderIntersection(IntersectionNode $intersectionNode) {
		list($unions, $otherOperands) = $this->filterOperandsByType($intersectionNode->getOperands(), 'union');

		$intersectionsOperands = array($otherOperands);

		/** @var UnionNode $union */
		foreach($unions as $union) {
			$newIntersectionsOperands = array();
			foreach($intersectionsOperands as $intersectionOperands) {
				foreach($union->getOperands() as $operand) {
					$newIntersectionsOperands[] = array_merge($intersectionOperands, array($operand));
				}
			}
			$intersectionsOperands = $newIntersectionsOperands;
		}

		$intersections = array();
		foreach($intersectionsOperands as $intersectionOperands) {
			$intersections[] = $this->simplifyLazilyIntersectionNode(new IntersectionNode($intersectionOperands));
		}

		if(count($intersections) === 1) {
			return reset($intersections);
		}

		return new UnionNode($intersections);
	}
}
