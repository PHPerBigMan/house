<?php

namespace App\Http\Controllers;

use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;
use Illuminate\Http\Request;
use iscms\AlismsSdk\AlibabaAliqinFcSmsNumSendRequest;

class AliSmsController extends Controller
{
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
            return 200;
        }
        return 403;
    }


    public function Search()
    {
        $config = config('alisms');
        $client = new  Client($config);
        $req = new AlibabaAliqinFcSmsNumSendRequest();
    }
}
