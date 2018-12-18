# linkedin-login
login with linkedin using php
# download using composer
composer require apisys/linkedin
# uses



```php
 require __DIR__.'/vendor/autoload.php';  //for core php
 $linkedin = new LinkedIn('YOUR-APIKEY-HERE','YOUR-API-SECRET', 'REDIRECT-URL');
 
 $userdata = $linkedin->process();
 
 if($userdata != null){
    /*
    do here what you want with $userdata object
    */
 }
```


