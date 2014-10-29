<?php

namespace PPP\Module\DataModel;

use PPP\DataModel\AbstractNode;

/**
 * Representation of a request
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleRequest {

	/**
	 * @var string
	 */
	private $languageCode;

	/**
	 * @var AbstractNode
	 */
	private $sentenceTree;

	/**
	 * @var string
	 */
	private $requestId;

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
	 * @param string $requestId
	 * @param float[] $measures
	 * @param string[] $trace
	 */
	public function __construct($languageCode, AbstractNode $sentenceTree, $requestId, array $measures = array(), array $trace = array()) {
		$this->languageCode = $languageCode;
		$this->sentenceTree = $sentenceTree;
		$this->requestId = $requestId;
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
	 * @return string
	 */
	public function getRequestId() {
		return $this->requestId;
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
