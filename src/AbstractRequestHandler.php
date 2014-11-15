<?php

namespace PPP\Module;

/**
 * Basic implementation of requestHandler
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
abstract class AbstractRequestHandler implements RequestHandler {

	/**
	 * @see RequestHandler::getCustomNodeSerializers
	 */
	public function getCustomNodeSerializers() {
		return array();
	}

	/**
	 * @see RequestHandler::getCustomNodeDeserializers
	 */
	public function getCustomNodeDeserializers() {
		return array();
	}
}
