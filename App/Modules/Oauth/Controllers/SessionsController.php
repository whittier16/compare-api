<?php

/*
  +------------------------------------------------------------------------+
  | Phosphorum                                                             |
  +------------------------------------------------------------------------+
  | Copyright (c) 2013-2014 Phalcon Team and contributors                  |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file docs/LICENSE.txt.                        |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
*/

namespace App\Modules\Oauth\Controllers;

use App\Modules\Oauth\Library\Oauth\OAuth as OAuth;
use App\Modules\Oauth\Library\Oauth\Users as CompareUsers;

/**
 * Class SessionsController
 *
 * @package ComparisonAPI\Controllers
 */
class SessionsController extends \App\Modules\Backend\Controllers\RESTController
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
