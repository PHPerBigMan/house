<?php

namespace App\Http\Controllers;

use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;
use Illuminate\Http\Request;
use iscms\AlismsSdk\AlibabaAliqinFcSmsNumSendRequest;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\SendBatchSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;
require_once dirname(__DIR__) . '/Common/api_sdk/vendor/autoload.php';
class AliSmsController extends Controller
{
    static $acsClient = null;
    /**
     * method: 阿里云发送短信
     * author: hongwenyang
     * param:
     */
    public function sms($phone,$signName,$code,$num)
    {
        $config = config('alisms');
        $client = new  Client($config);
        $sendSms = new SendSms();
        $sendSms->setPhoneNumbers($phone);
        $sendSms->setSignName("$signName");
        $sendSms->setTemplateCode("$code");
        $sendSms->setTemplateParam(['code' => $num]);
        $result = $client->execute($sendSms);

        if($result->Code == "OK"){
            return 200;
        }
        return 403;
    }

    /**
     * method: 发送审核通知
     * author: hongwenyang
     * param:
     */
    public function smsPass($phone,$signName,$code,$content)
    {
        $config = config('alisms');
        $client = new  Client($config);

        $sendSms = new SendSms();
        $sendSms->setPhoneNumbers($phone);
        $sendSms->setSignName("$signName");
        $sendSms->setTemplateCode("$code");
        $sendSms->setTemplateParam($content);
        $result = $client->execute($sendSms);

        if($result->Code == "OK"){
            return $result->BizId;
        }
        return 403;
    }



    public function Search()
    {

        $sms = new \SmsDemo();
        dd(32);

    }




    public static function querySendDetails($phone,$bizid) {
        $sms = new \SmsDemo();


        dd($sms->querySendDetails($phone,$bizid));
    }
}
