<?php
namespace Unengage;

class UnengageApiException extends \Exception
{
    protected $response;
    
    public function __construct($code, $response)
    {
        $this->response = json_decode($response,true);
        parent::__construct((isset($this->response['message'])?$this->response['message']:$response), $code);
    }

    public function getResponse()
    {
        return $this->response;
    }
}