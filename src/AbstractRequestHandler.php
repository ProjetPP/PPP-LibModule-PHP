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
	 * @see RequestHandler::getCustomResourceNodeSerializers
	 */
	public function getCustomResourceNodeSerializers() {
		return array();
	}

	/**
	 * @see RequestHandler::getCustomNodeDeserializers
	 */
	public function getCustomResourceNodeDeserializers() {
		return array();
	}
}
