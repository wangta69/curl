<?php
namespace Pondol\Curl;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Response;
use Pondol\Curl\CurlResponse;

/*
GET, POST, HEAD, PUT, DELETE Enable

$curl = new \Pondol\Curl('GET', 'http://www.shop-wiz.com/');
$curl = new \Pondol\Curl('POST', 'http://www.shop-wiz.com/', $params);

## options

$params['headers'][] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg, application/json';
$params['headers'][] = 'Connection: Keep-Alive';
$params['headers'][] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
 
$params['proxy'] = 'tcp://localhost:1111', 
 
$params['body'] = string or array

$params['encoding'] = 'gzip'// "identity", "deflate", and "gzip
 
// 'json' => ['foo' => 'bar'], 'timeout' => 3.14]);

$params['agent'] = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';

$params['cookies'] = [filepath=''] , if [cookies=>[]] path willbe /tmp/filename

*/

class CurlService
{
    private $ch;
    private $response;
    
    public function __construct() {
        $this->response = new CurlResponse(); 
    }
    
    public function request($method, $url, $options=array()){
        
        $this->ch = curl_init();
        
        curl_setopt($this->ch, CURLOPT_AUTOREFERER, true);//TRUE to automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($this->ch, CURLOPT_HEADER, true);//TRUE to include the header in the output.
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);//TRUE to return the raw output when CURLOPT_RETURNTRANSFER is used.
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
         
        isset($options['headers']) ?  $this->set_header($options['headers']):null;
        isset($options['agent']) ?  $this->set_agent($options['agent']):null;
        isset($options['cookies']) ?  $this->set_cookies($options['cookies']):null;
        isset($options['encoding']) ?  $this->set_encoding($options['encoding']):null;
        isset($options['timeout']) ?  $this->set_timeout($options['timeout']):null;
        isset($options['proxy']) ?  $this->set_proxy($options['proxy']):null;
        
      //  
        
        switch(strtoupper($method)){
            case "POST":
                
                curl_setopt($this->ch, CURLOPT_URL, $url);
                curl_setopt($this->ch, CURLOPT_POST, true);
                isset($options['body']) ?  $this->set_body($options['body']):null;
                break;
            case "GET":
                curl_setopt($this->ch, CURLOPT_URL, $this->build_http_get_url($url, $options));
                break;
            case "HEAD":
                curl_setopt($this->ch, CURLOPT_URL, $url);
                curl_setopt( $this->ch, CURLOPT_NOBODY, true );
                curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);//PUT, DELETE, HEAD
                break;
            default:
                curl_setopt($this->ch, CURLOPT_URL, $url);
                curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);//PUT, DELETE, HEAD
                break;
        }

        $this->response->set_response(curl_exec($this->ch));
        
        if (!curl_errno($this->ch)) {
          $this->response->set_info(curl_getinfo($this->ch));
        }else{
            $this->response->err_code = curl_errno($this->ch);
        }

        curl_close($this->ch);
    } 
    
    /**
     * request as body data is json
     * if you want to request Json, set Content-Type and Length;
     */
    public function requestJson($method, $url, $options=array()){
        $options['headers'][] = 'Content-Type: application/json';
        $options['headers'][] = 'Content-Length: ' . strlen($options['body']);
        $this->request($method, $url, $options);
    }
    

    private function build_query($body){
        return is_array($body) ? http_build_query($body):null;
    }
    
    private function build_http_get_url($url, $options=[]){
        if(isset($options['body'])){
            $query = $this->build_query($options['body']);
            return $url.'?'.$query;
        }else
            return $url;
    }
    
    private function set_header($headers){
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
    }
    
    private function set_body($body){
        if(is_array($body))
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($body));
        else
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $body);
    }
                
    
    private function set_agent($agent){
        echo "set_agent:".$agent.PHP_EOL;
        curl_setopt($this->ch, CURLOPT_USERAGENT, $agent);
    }
     
     /**
      * @param Array cookies = [filepath='']
      */
     private function set_cookies($cookies){
        $filepath = isset($cookies['filepath']) ? $cookies['filepath']:$this->get_cookie_path();
         
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->cookie_file);//makes curl to store the cookies in a file at the and of the curl session
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, $this->cookie_file);//makes curl to use the given file as source for the cookies to send to the server. 
        
    }
    
    private function get_cookie_path(){
        return tempnam( "/tmp", 'cookie_');
    }
     /**
      * The contents of the "Accept-Encoding: " header. This enables decoding of the response. 
      * Supported encodings are "identity", "deflate", br, and "gzip". If an empty string, "", is set, a header containing all supported encoding types is sent.
      */
    private function set_encoding($encoding){
        curl_setopt($this->ch,CURLOPT_ENCODING , $encoding);
    }

    
    /**
     * The maximum number of seconds to allow cURL functions to execute.
     */
    private function set_timeout($timeout){
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);
    }
    
    /**
     * The HTTP proxy to tunnel requests through.
     */
    private function set_proxy($proxy){
        curl_setopt($this->ch, CURLOPT_PROXY, $proxy);
    }
    
    
    // return 
    public function get_response(){
        return $this->response;
    }
    
    public function info(){
        return $this->response->info();
    }
    
     public function http_code(){
        return $this->response->http_code();
    }
    
    public function header_size(){
        return $this->response->header_size();
    }
    
    public function header(){
        return $this->response->header();
    }
    
    public function body(){
        return $this->response->body();
    }
    
    public function err_message(){
        return $this->response->err_message();
    }


}