<?php
namespace App\Common\Lib\Application\Libraries\Oauth;

use Guzzle\Http\Client as HttpClient;

/**
 * Class Users
 *
 * @package App\Modules\Oauth
 */
class Users
{

    protected $endPoint = 'http://oauth.compargo.com';

    protected $accessToken;

    /**
     * @param $accessToken
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->_response   = $this->request('/resource.php');
    }

    /**
     * @param $method
     *
     * @return mixed|null
     */
    public function request($method)
    {
        try {
            $client = new HttpClient();
            return json_decode(
                $client->get($this->endPoint . $method . '?access_token=' . $this->accessToken)->send()->getBody(),
                true
            );
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return is_array($this->_response);
    }
}