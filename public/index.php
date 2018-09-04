<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';
require_once __DIR__.'/../app/Http/Common/function.php';
//require_once __DIR__.'/../app/Http/Common/SmsDemo.php';
define("NAME","FLGY");
// 签名名称
define("SIGNNAMETEST","测试项目");
define("SIGNNAME","");
// 模板编号
define("PASSCODE","SMS_141581161");
define("NOPASS","SMS_141580244");
define("PASS1","SMS_141581161");
define("MESSAGESEND","SMS_143711416");
define("NOPASSOTHER","SMS_141580244");
define("HOUSENAME","CNHD");
define("DEBUG",0);
define("URL",'http://falangongyuan.shoufangpai.com/storage/');
define("URL1",'http://falangongyuan.shoufangpai.com/');
// 是否限购
define("ISBUY",1);
// 0:银行存款证明  1:银行冻结证明
define("BANKIMGTYPE",1);
define("LEN",6);
// 开始登记时间
define("STARTTIME",1535673600);
// 是否可看楼盘详情
define("FLOORREAD",1);
// 销售公示方案
define("SELL",0);
// 摇号结果
define("RESULT",0);
// 是否为测试开发中
define("TESTDEBUG",0);
/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
