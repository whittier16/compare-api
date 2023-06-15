<?php
namespace App\Common\Lib\Application\Libraries\Oauth;

use Phalcon\DI\Injectable;
use Guzzle\Http\Client as HttpClient;

/**
 * Class OAuth
 *
 */
class OAuth extends Injectable
{

    protected $endPointAuthorize = 'http://oauth.compargo.com/authorize.php';

    protected $endPointAccessToken = 'http://oauth.compargo.com/token.php';

    protected $redirectUriAuthorize;

    protected $baseUri;

    protected $clientId;

    protected $clientSecret;

    protected $transport;

    /**
     * @param $config
     */
    public function __construct($config)
    {
        $this->redirectUriAuthorize = $config->redirectUri;
        $this->clientId             = $config->clientId;
        $this->clientSecret         = $config->clientSecret;
    }

    /**
     *
     */
    public function authorize()
    {
        $key   = $this->security->getTokenKey();
        $token = $this->security->getToken();
        $url = $this->endPointAuthorize . '?client_id=' . $this->clientId . '&redirect_uri='
            . $this->redirectUriAuthorize 
            . // add the tokenkey as a query param. Then we will be able to use it to check token authenticity
            '&state=' . $token . '&scope=r_products';
        $this->response->redirect($url, true);
    }

    /**
     * @return bool|mixed
     */
    public function accessToken($grant_type = 'client_credentials', $authorization_code)
    {  
    	if ($grant_type != 'client_credentials' || $grant_type != '') {
    		$params['code'] = $authorization_code;
    	}
    	
    	$params = array(
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
        	'grant_type'	=> ($grant_type != '') ? $grant_type : 'client_credentials'
        );
    	
        $response = $this->send($this->endPointAccessToken, $params);
        return $response;
    }

    /**
     * @param        $url
     * @param        $parameters
     * @param string $method
     *
     * @return bool|mixed
     */
    public function send($url, $parameters, $method = 'post')
    {
        try {

            $client = new HttpClient();

            $headers = array(
                'Accept' => 'application/json'
            );

            switch ($method) {
                case 'post':
                    $request = $client->post($url, $headers, $parameters);
                    break;
                case 'get':
                    $request = $client->get($url, $headers, $parameters);
                    break;
                default:
                    throw new \Exception('Invalid HTTP method');
            }

            return json_decode((string)$request->send()->getBody(), true);

        } catch (\Exception $e) {
            return false;
        }
    }
}