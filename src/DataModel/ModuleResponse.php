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
	 * @var float[]
	 */
	private $measures;

	/**
	 * @var string[]
	 */
	private $trace;

	/**
	 * @param string $languageCode
	 * @param AbstractNode $sentenceTree
	 * @param float[] $measures
	 * @param string[] $trace
	 */
	public function __construct($languageCode, AbstractNode $sentenceTree, array $measures = array(), array $trace = array()) {
		$this->languageCode = $languageCode;
		$this->sentenceTree = $sentenceTree;
		$this->measures = $measures;
		$this->trace = $trace;
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
	 * @return float[]
	 */
	public function getMeasures() {
		return $this->measures;
	}

	/**
	 * @return string[]
	 */
	public function getTrace() {
		return $this->trace;
	}
}
