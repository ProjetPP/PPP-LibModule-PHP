<?php

namespace PPP\Module;

use Deserializers\Exceptions\DeserializationException;
use Exception;
use PPP\DataModel\DeserializerFactory;
use PPP\DataModel\SerializerFactory;
use PPP\Module\DataModel\Deserializers\ModuleRequestDeserializer;
use PPP\Module\DataModel\ModuleRequest;
use PPP\Module\DataModel\ModuleResponse;
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
			$this->filterRequestMethod();
			$request = $this->getRequest();
			$responses = $this->requestHandler->buildResponse($request);
			$this->outputResponse($this->serializeResponse($this->cleanResponses($responses, $request)));
		} catch(HttpException $e) {
			$this->outputHttpException($e);
		} catch(Exception $e) {
			$this->outputHttpException(new HttpException($e->getMessage(), 500, $e));
		}
	}

	private function filterRequestMethod() {
		if(!array_key_exists('REQUEST_METHOD', $_SERVER)) {
			return;
		}
		if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			exit();
		}
		if($_SERVER['REQUEST_METHOD'] !== 'POST') {
			new HttpException('Bad request method: ' . $_SERVER['REQUEST_METHOD'], 405);
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
			throw new HttpException($e->getMessage(), 400, $e);
		}
	}

	public function getRequestBody() {
		return file_get_contents("php://input");
	}

	private function cleanResponses(array $responses, ModuleRequest $request) {
		$cleanedResponses = array();

		/** @var ModuleResponse $response */
		foreach($responses as $response) {
			if($request->getSentenceTree()->equals($response->getSentenceTree())) {
				continue;
			}

			$cleanedResponses[] = new ModuleResponse(
				$response->getLanguageCode(),
				$response->getSentenceTree(),
				$response->getMeasures() + $request->getMeasures(),
				$response->getTrace()
			);
		}

		return $cleanedResponses;
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

	private function outputHttpException(HttpException $exception) {
		$this->setHttpResponseCode($exception->getCode());
		echo $exception->getMessage();
	}

	private function setHttpResponseCode($code) {
		if(function_exists('http_response_code')) {
			@http_response_code($code);
		} else {
			@header('X-PHP-Response-Code: '. $code, true, $code);
		}
	}
}
