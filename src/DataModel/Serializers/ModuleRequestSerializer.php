<?php

namespace PPP\Module\DataModel\Serializers;

use PPP\Module\DataModel\ModuleRequest;
use Serializers\DispatchableSerializer;
use Serializers\Exceptions\UnsupportedObjectException;
use Serializers\Serializer;

/**
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleRequestSerializer implements DispatchableSerializer {

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
		return is_object($object) && $object instanceof ModuleRequest;
	}

	/**
	 * @see Serializer::serialize
	 */
	public function serialize($object) {
		if(!$this->isSerializerFor($object)) {
			throw new UnsupportedObjectException($object, 'ModuleRequestSerializer can only serialize ModuleRequest objects.');
		}

		return $this->getSerialization($object);
	}

	private function getSerialization(ModuleRequest $request) {
		return array(
			'language' => $request->getLanguageCode(),
			'tree' => $this->nodeSerializer->serialize($request->getSentenceTree()),
			'id' => $request->getRequestId(),
			'measures' => (object) $request->getMeasures(),
			'trace' => $request->getTrace()
		);
	}
}
