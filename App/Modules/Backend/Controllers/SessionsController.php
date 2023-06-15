<?php
namespace App\Modules\Backend\Controllers;

use App\Common\Lib\Application\Libraries\OAuth\OAuth,
	App\Common\Lib\Application\Libraries\OAuth\Users as CompareUsers,
	App\Common\Lib\Application\Controllers\RESTController;

/**
 * Class SessionsController
 *
 * @package ComparisonAPI\Controllers
 */
class SessionsController extends RESTController
{
    /**
     * @return \Phalcon\Http\ResponseInterface
     */
    public function accessToken()
    {	
        $oauth = new OAuth($this->di->getConfig()->oauth);

        $request = $this->di->get('request');
 	    $code = (null !== $request->get('code')) ? $request->get('code') : '';
 		$grantType = (null !== $request->get('grant_type'))?$request->get('grant_type'):'';
 		
        $response = $oauth->accessToken($grantType, $code);
        
        if (is_array($response)) {
        	$compareUser = new CompareUsers($response['access_token']);
        	
        	if (!$compareUser->isValid()){
        		return $compareUser;
        	}  	
        }
        return $response;
    }
    
    /**
     * @return \Phalcon\Http\ResponseInterface
     */
    public function authorize()
    {	
    	$oauth = new OAuth($this->di->getConfig()->oauth);
    	return $oauth->authorize();
    }
    
    public function resource($token){
  		$compareUser = new CompareUsers($token);
  		if ($compareUser->_response['success'] != NULL){
  			return true;
  		}
  		return false;
    }
}
