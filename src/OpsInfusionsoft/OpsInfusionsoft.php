<?php


namespace OpsInfusionsoft;

use \core\Token;
class OpsInfusionsoft
{
    public $infusionsoft;
    public $Token;
    public function __construct()
    {
        $this->infusionsoft = new \Infusionsoft\Infusionsoft(array(
            'clientId'     => IS_CLIENT_ID,
            'clientSecret' => IS_SECRET_ID,
            'redirectUri'  => IS_REDIRECT_URI,
        ));

        $this->Token = new Token();
    }

    public function getAuthorizationUrl()
    {
        return $this->infusionsoft->getAuthorizationUrl();
    }

    public function setToken($token = null)
    {
        if($token === null){
            $data = $this->Token->getRow(['vendor' => 'infusionsoft']);
            $token = unserialize($data->token);
        }

        $this->infusionsoft->setToken($token);
    }

    public function getToken($code)
    {
        $token = $this->infusionsoft->requestAccessToken($code);
        $this->Token->updateOrInsert(
            ['vendor' => 'infusionsoft', 'token' => serialize($token)],
            ['vendor' => 'infusionsoft']
        );
        return $token;
    }

}