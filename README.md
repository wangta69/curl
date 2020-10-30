# curl

## Installation
```
composer require wangta69/curl

composer require "wangta69/curl @dev"

```
## How to Use
```
use Wangta69\Curl\CurlService;

$body = ['name'=>'pondol'];
$headers = ['Connection: Keep-Alive', 'Content-type: application/x-www-form-urlencoded;charset=UTF-8'];

$headers[] = 'Host: shop-wiz.com'];
$headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0'];
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'];
$headers[] = 'Accept-Language: en-US,en;q=0.5'];
$headers[] = 'Accept-Encoding: gzip, deflate'];//#remove this line for readable/greppable formatting
$headers[] = 'Content-Encoding: gzip';//Transfer-Encoding
$headers[] = 'Referer: https://shop-wiz.com/tmp.php'];
$headers[] = 'Cookie: all required cookies will appear here'];
$headers[] = 'Connection: keep-alive'];


$curl = new CurlService();
$curl->request('GET', 'http://www.shop-wiz.com', ['body'=>$body, 'headers'=>$headers]);
echo $curl->body();


$curl = new CurlService();
$curl->request('POST', 'http://www.shop-wiz.com', ['body'=>$body, 'headers'=>$headers]);
echo $curl->body();

-- Cookie
$curl = new CurlService();
$curl->request('GET', 'http://www.shop-wiz.com', ['cookies'=>true]);
$curl->request('GET', 'http://www.shop-wiz.com', ['cookies'=>['filepath'=>'/tmp/my_cookie_file']]);
echo $curl->body();
```

### Request Json
```
use Wangta69\Curl\CurlService;

$body = json_encode(['name'=>'pondol']);

$curl = new CurlService();
$curl->requestJson('POST', 'http://www.shop-wiz.com', ['body'=>$body, 'headers'=>$headers]);
echo $curl->body();
```
