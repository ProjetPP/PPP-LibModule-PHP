<?php

namespace PPP\Module\DataModel\Serializers;

use PPP\Module\DataModel\ModuleResponse;
use Serializers\DispatchableSerializer;
use Serializers\Exceptions\UnsupportedObjectException;
use Serializers\Serializer;

/**
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleResponseSerializer implements DispatchableSerializer {

	/**
	 * @var Serializer
	 */
	private $nodeSerializer;

	public function __construct(Serializer $nodeSerializer) {
		$this->nodeSerializer = $nodeSerializer;
	}

	/**
	 * @see DispatchableSerializer::isSerializerFor
	 */
	public function isSerializerFor($object) {
		return is_object($object) && $object instanceof ModuleResponse;
	}

	/**
	 * @see Serializer::serialize
	 */
	public function serialize($object) {
		if(!$this->isSerializerFor($object)) {
			throw new UnsupportedObjectException($object, 'ModuleResponseSerializer can only serialize ModuleResponse objects.');
		}

		return $this->getSerialization($object);
	}

	private function getSerialization(ModuleResponse $response) {
		return array(
			'language' => $response->getLanguageCode(),
			'tree' => $this->nodeSerializer->serialize($response->getSentenceTree()),
			'pertinence' => $response->getPertinence()
		);
	}
}
