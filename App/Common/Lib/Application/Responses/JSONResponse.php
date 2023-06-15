<?php
namespace App\Common\Lib\Application\Responses;

class JSONResponse extends Response{

	protected $snake = true;
	protected $envelope = true;

	public function __construct(){
		parent::__construct();
	}

	public function send($records, $error=false){
		
		// Error's come from HTTPException.  This helps set the proper envelope data
		$response = $this->di->get('response');
		$success = ($error) ? 'ERROR' : 'SUCCESS';

		// If the query string 'envelope' is set to false, do not use the envelope.
		// Instead, return headers.
		$request = $this->di->get('request');
		if ($request->get('envelope', null, null) === 'false'){
			$this->envelope = false;
		}

		// Most devs prefer camelCase to snake_Case in JSON, but this can be overriden here
		if($this->snake){
			$records = $this->arrayKeysToSnake($records);
		}

		$etag = md5(serialize($records));

		$count = count($records);
		if ($this->envelope){
			if ($request->get('count') == 1 && $request->get('limit') == 0) {
				$records = array();
			}
			
			// Provide an envelope for JSON responses.  '_meta' and 'records' are the objects.
			$message = array();
			$message = array(
				'status' => $success,
				'count' => ($error) ? 1 : $count
			);
			
			// Handle 0 record responses, or assign the records
			if($message['count'] === 0){
				// This is required to make the response JSON return an empty JS object.  Without
				// this, the JSON return an empty array:  [] instead of {}
				$message['data'] = new \stdClass();
			} else {
				$message['data'] = $records;
			}

		} else {
			$response->setHeader('X-Record-Count', $count);
			$response->setHeader('X-Status', $success);
			$message = $records;
		}
		
		$response->setContentType('application/json', 'UTF-8');
		$response->setHeader('E-Tag', $etag);
		
		if ($request->getPost()){
			$response->setHeader('X-HTTP-Method-Override', 'POST');
		}

		// HEAD requests are detected in the parent constructor. HEAD does everything exactly the
		// same as GET, but contains no body.
		if (!$this->head){
			$response->setJsonContent($message);
		}
		
		$response->send();

		return $this;
	}

	public function convertSnakeCase($snake){
		$this->snake = (bool) $snake;
		return $this;
	}

	public function useEnvelope($envelope){
		$this->envelope = (bool) $envelope;
		return $this;
	}
}