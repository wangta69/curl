# curl

## Installation
```
composer require wangta69/curl

composer require "wangta69/curl @dev"

```
## How to Use
```
use Pondol\Curl\CurlService;

$body = ['name'=>'pondol'];
$headers = ['Connection: Keep-Alive', 'Content-type: application/x-www-form-urlencoded;charset=UTF-8'];

$curl = new CurlService();
$curl->request('POST', 'http://www.shop-wiz.com', ['body'=>$body, 'headers'=>$headers]);
echo $curl->body();
```

### Request Json
```
use Pondol\Curl\CurlService;

$body = json_encode(['name'=>'pondol']);

$curl = new CurlService();
$curl->requestJson('POST', 'http://www.shop-wiz.com', ['body'=>$body, 'headers'=>$headers]);
echo $curl->body();
```