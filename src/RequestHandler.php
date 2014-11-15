<?php

namespace PPP\Module;

use Deserializers\Deserializer;
use PPP\Module\DataModel\ModuleRequest;
use PPP\Module\DataModel\ModuleResponse;
use Serializers\Serializer;

/**
 * Basic interface modules
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
interface RequestHandler {

	/**
	 * @param ModuleRequest $request
	 * @return ModuleResponse[]
	 */
	public function buildResponse(ModuleRequest $request);

	/**
	 * Returns serializers for custom nodes of the module
	 *
	 * @return Serializer[]
	 */
	public function getCustomNodeSerializers();

	/**
	 * Returns deserializers for custom nodes of the module
	 *
	 * @return Deserializer[]
	 */
	public function getCustomNodeDeserializers();
}
