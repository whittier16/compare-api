<?php
namespace App\Common\Lib\Application\Responses;


class XMLResponse extends Response{

	public function __construct(){
		parent::__construct();
	}
	
	function send($records, $nodeName = 'products') {
		$response = $this->di->get('response');

		//Records conversion
		$records = $this->objectToArray($records);
		$records = $this->array2xml($records, $nodeName);
		
		//Headers for XML
        $response->setHeader('Content-Type', 'application/xml');
        $response->setContent($records);
		
        $response->send();
        
		return $this;
	}
}
