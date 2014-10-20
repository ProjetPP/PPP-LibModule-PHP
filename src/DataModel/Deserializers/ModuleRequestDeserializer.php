<?php

namespace PPP\Module\DataModel\Deserializers;

use Deserializers\Deserializer;
use Deserializers\Exceptions\DeserializationException;
use PPP\Module\DataModel\ModuleRequest;

/**
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleRequestDeserializer implements Deserializer {

	/**
	 * @var Deserializer
	 */
	private $nodeDeserializer;

	public function __construct(Deserializer $nodeDeserializer) {
		$this->nodeDeserializer = $nodeDeserializer;
	}
	
	/**
	 * @see Deserializer::serialize
	 */
	public function deserialize($serialization) {
		if(!$this->isValidDeserialization($serialization)) {
			throw new DeserializationException('The serialization is invalid!');
		}

		return $this->getDeserialized($serialization);
	}

	private function getDeserialized($serialization) {
		return new ModuleRequest(
			$serialization['language'],
			$this->nodeDeserializer->deserialize($serialization['tree']),
			$serialization['id'],
			array_key_exists('trace', $serialization) ? $serialization['trace'] : array()
		);
	}

	private function isValidDeserialization($serialization) {
		return is_array($serialization) &&
			array_key_exists('language', $serialization) &&
			array_key_exists('tree', $serialization) &&
			array_key_exists('id', $serialization);
	}
}
