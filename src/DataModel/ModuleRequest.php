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
	 * @var string[]
	 */
	private $trace;

	/**
	 * @param string $languageCode
	 * @param AbstractNode $sentenceTree
	 * @param string $requestId
	 * @param string[] $trace
	 */
	public function __construct($languageCode, AbstractNode $sentenceTree, $requestId, array $trace = array()) {
		$this->languageCode = $languageCode;
		$this->sentenceTree = $sentenceTree;
		$this->requestId = $requestId;
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
	 * @return string[]
	 */
	public function getTrace() {
		return $this->trace;
	}
}
