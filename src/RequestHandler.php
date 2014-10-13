<?php

namespace PPP\Module;

use PPP\Module\DataModel\ModuleRequest;
use PPP\Module\DataModel\ModuleResponse;

/**
 * Basic interface modules
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
interface RequestHandler {

	/**
	 * @param ModuleRequest $request
	 * @return ModuleResponse
	 */
	public function buildResponse(ModuleRequest $request);
}
