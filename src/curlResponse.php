<?php
namespace Pondol\Curl;


class CurlResponse
{

    public $response;
    public $info;
    
    //private $header_size;
    //public $header_size;
    //public $header;
    //public $body;
    public function set_response($response){
        $this->response = $response;
    }
    
    public function set_info($info){
        $this->info = $info;
        $this->header_size = $info['header_size'];
    }
    
    public function info(){
        return $this->info;
    }
    
    public function http_code(){
        return $this->info['http_code'];
    }
    
    public function header_size(){
        return $this->info['header_size'];
    }
    
    public function header(){
        return substr($this->response, 0, $this->info['header_size']);
    }
    
    public function body(){
        return substr($this->response, $this->info['header_size']);
    }

        
}