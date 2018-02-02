# coin_exchange_api

## Installation
```
composer require wangta69/coin_exchange_api

composer require "wangta69/coin_exchange_api @dev"

```

Step 1) Add ServiceProvider to the providers array in `config/app.php`.
```
Pondol\CoinExchange\CoinExchangeServiceProvider::class,
```

javascript Sample
- 빗썸 API : 참조 URL :  https://www.bithumb.com/u1/US127
```
var exchanger = 'bithumb';
var api_url = '/info/user_transactions';
var connect_key = "xxxxxx";
var secret_key = "xxxxxxxx";
var reqParams = {currency : 'XRP', searchGb : '0'};

$(function() {
    
    var callApi = function(){
        $.post("/api/coin-exchange/call", {exchanger:exchanger, api_url:api_url, key:connect_key, secret:secret_key, reqParams:reqParams}, function(data){
           console.log(data); 
        });
    }
});
```