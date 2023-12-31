<?php
namespace App\Common\Lib\Application\Exceptions;

use App\Common\Lib\Application\Responses\JSONResponse,
    App\Common\Lib\Application\Responses\XMLResponse,
    App\Common\Lib\Application\Responses\CSVResponse;
	
class HTTPException extends \Exception{

	public $devMessage;
	public $errorCode;
	public $response;
	public $additionalInfo;

	public function __construct($message, $code, $errorArray){
		$this->message = $message;
		$this->devMessage = @$errorArray['dev'];
		$this->errorCode = @$errorArray['internalCode'];
		$this->code = $code;
		$this->additionalInfo = @$errorArray['more'];
		$this->response = $this->getResponseDescription($code);
	}

	public function send(){
		$di = \Phalcon\DI::getDefault();
		
		$res = $di->get('response');
		$req = $di->get('request');
		
		//query string, filter, default
		if(!$req->get('suppress_response_codes', null, null)){
			$res->setStatusCode($this->getCode(), $this->response)->sendHeaders();
		} else {
			$res->setStatusCode('200', 'OK')->sendHeaders();
		}
		
		$error = array(
			'errorCode' => $this->getCode(),
			'userMessage' => $this->getMessage(),
			'devMessage' => $this->devMessage,
			'more' => $this->additionalInfo,
			'applicationCode' => $this->errorCode,
		);
		
		if (!$req->get('type') || $req->get('type') == 'json'| $req->get('type') == 'option'){
			$response = new JSONResponse();
			$response->send($error, true);	
			return;
		} else if ($req->get('type') == 'xml'){
			$response = new XMLResponse();
			$response->send($error, true);
			return;
		} else if($req->get('type') == 'csv'){
			$response = new CSVResponse();
			$response->send(array($error));
			return;
		}
		
		error_log(
			'HTTPException: ' . $this->getFile() .
			' at ' . $this->getLine()
		);

		return true;
	}

	protected function getResponseDescription($code)
	{
		$codes = array(

			// Informational 1xx
			100 => 'Continue',
			101 => 'Switching Protocols',

			// Success 2xx
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',

			// Redirection 3xx
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',  // 1.1
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			// 306 is deprecated but reserved
			307 => 'Temporary Redirect',

			// Client Error 4xx
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			418 => 'I\'m a teapot',
			420 => 'Twitter rate limiting',
			422 => 'Request unable to be followed due to semantic errors',
			423 => 'Resource that is being accessed is locked',
			424 => 'Request failed due to failure of a previous request',
			426 => 'Client should switch to a different protocol',
			428 => 'Origin server requires the request to be conditional',
			429 => 'User has sent too many requests in a given amount of time',
			431 => 'Server is unwilling to process the request',
			444 => 'Server returns no information and closes the connection',
			449 => 'Request should be retried after performing action',
			450 => 'Windows Parental Controls blocking access to webpage',
			451 => 'The server cannot reach the client\'s mailbox.',
			499 => 'connection closed by client while HTTP server is processing',
				
			// Server Error 5xx
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
			509 => 'Bandwidth Limit Exceeded'
		);

		$result = (isset($codes[$code])) ? $codes[$code] : 'Unknown Status Code';
		return $result;
	}
}
