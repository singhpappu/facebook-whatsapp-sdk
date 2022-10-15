<?php

namespace LaravelNotification\Whatsapp;

use Exception;
use LaravelNotification\Whatsapp\Traits\SharedObjects;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use LaravelNotification\Whatsapp\Exceptions\WhatsappException;

class Whatsapp
{

    use SharedObjects;

    /** 
     * Http client 
     * @var HttpClient
     * */
    protected $http;

    /**
     * whatsapp graph end point
     * @var string 
     * */
    protected $apiUrl;

    public function __construct(string $phone_number_id = null, string $token = null)
    {


        if (empty($phone_number_id)) {
            throw new \Exception("Whatsapp phone number id not provided.");
        }

        if (empty($token)) {
            throw new \Exception("Whatsapp access token not provided.");
        }

        $this->setPhoneNumberId(config('whatsapp.phone_number_id'));

        $this->setToken($token);

        $this->setApiUrl("https://graph.facebook.com");

        $this->setHttp(new HttpClient([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ]));
    }

    /**
     * Get the value of http
     */
    public function getHttp()
    {
        return $this->http;
    }

    /**
     * Set the value of http
     *
     * @return  self
     */
    public function setHttp($http)
    {
        $this->http = $http;

        return $this;
    }

    /**
     * Get whatsapp graph end point
     *
     * @return  string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * Set whatsapp graph end point
     *
     * @param  string  $apiUrl  whatsapp graph end point
     *
     * @return  self
     */
    public function setApiUrl(string $apiUrl)
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    public function sendTextMessage(array $params)
    {
       return $this->sendHttpRequest("messages", $params);
    }

    protected function sendHttpRequest(string $endpoint, array $params)
    {
        $apiUrl = sprintf("%s/%s/%s/%s", $this->apiUrl, $this->version, $this->phoneNumberId, $endpoint);

        try {
            return $this->http->post($apiUrl, [
                'form_params' => $params,
            ]);
        } catch (ClientException $exception) {
            throw WhatsappException::facebookGraphErrorResponse($exception);
        } catch (Exception $exception) {
            throw WhatsappException::comunicationWithFacebookGraphNotEstablished($exception);
        }
    }
}
