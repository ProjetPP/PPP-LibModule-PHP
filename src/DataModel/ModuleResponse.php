<?php

namespace PPP\Module\DataModel;

use PPP\DataModel\AbstractNode;

/**
 * Representation of a response
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleResponse {

	/**
	 * @var string
	 */
	private $languageCode;

	/**
	 * @var AbstractNode
	 */
	private $sentenceTree;

	/**
	 * @var float
	 */
	private $pertinence;

	/**
	 * @param string $languageCode
	 * @param AbstractNode $sentenceTree
	 * @param float $pertinence
	 */
	public function __construct($languageCode, AbstractNode $sentenceTree, $pertinence) {
		$this->languageCode = $languageCode;
		$this->sentenceTree = $sentenceTree;
		$this->pertinence = $pertinence;
	}

	/**
	 * @return string
	 */
	public function getLanguageCode() {
		return $this->languageCode;
	}

	/**
	 * @return AbstractNode
	 */
	public function getSentenceTree() {
		return $this->sentenceTree;
	}

	/**
	 * @return float
	 */
	public function getPertinence() {
		return $this->pertinence;
	}
}
