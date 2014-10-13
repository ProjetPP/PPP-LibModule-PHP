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
	 * @param string $languageCode
	 * @param AbstractNode $sentenceTree
	 * @param string $requestId
	 */
	public function __construct($languageCode, AbstractNode $sentenceTree, $requestId) {
		$this->languageCode = $languageCode;
		$this->sentenceTree = $sentenceTree;
		$this->requestId = $requestId;
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
}
