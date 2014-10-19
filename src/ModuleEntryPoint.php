<?php

namespace PPP\Module;

use Deserializers\Exceptions\DeserializationException;
use Exception;
use PPP\DataModel\DeserializerFactory;
use PPP\DataModel\SerializerFactory;
use PPP\Module\DataModel\Deserializers\ModuleRequestDeserializer;
use PPP\Module\DataModel\ModuleRequest;
use PPP\Module\DataModel\Serializers\ModuleResponseSerializer;

/**
 * Entry point for Modules
 *
 * @licence MIT
 * @author Thomas Pellissier Tanon
 */
class ModuleEntryPoint {

	/**
	 * @var requestHandler
	 */
	private $requestHandler;

	/**
	 * @param RequestHandler $requestHandler
	 */
	public function __construct(RequestHandler $requestHandler) {
		$this->requestHandler = $requestHandler;
	}

	/**
	 * Main function
	 */
	public function exec() {
		try {
			$this->outputResponse($this->serializeResponse($this->requestHandler->buildResponse($this->getRequest())));
		} catch(HttpException $e) {
			header('HTTP/1.1 ' . $e->getCode() . ' ' . $e->getMessage());
		} catch(Exception $e) {
			header('HTTP/1.1 500 Internal Server Error');
		}

	}

	/**
	 * @return ModuleRequest
	 */
	private function getRequest() {
		$requestJson = json_decode($this->getRequestBody(), true);
		try {
			return $this->buildRequestDeserializer()->deserialize($requestJson);
		} catch(DeserializationException $e) {
			throw new HttpException('Bad Request', 400);
		}
	}

	public function getRequestBody() {
		return file_get_contents("php://input");
	}


	private function outputResponse($serialization) {
		@header('Content-type: application/json');
		echo json_encode($serialization);
	}

	private function serializeResponse(array $responses) {
		$serialization = array();
		foreach($responses as $response) {
			$serialization[] = $this->buildResponseSerializer()->serialize($response);
		}
		return $serialization;
	}

	private function buildRequestDeserializer() {
		$deserializerFactory = new DeserializerFactory();
		return new ModuleRequestDeserializer($deserializerFactory->newNodeDeserializer());
	}


	private function buildResponseSerializer() {
		$serializerFactory = new SerializerFactory();
		return new ModuleResponseSerializer($serializerFactory->newNodeSerializer());
	}
}
