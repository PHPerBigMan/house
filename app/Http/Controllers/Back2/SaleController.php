<?php

namespace App\Http\Controllers\Back2;

use App\Model\Sale;
use App\Model\SaleCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    public function index(Request $request){
        $pageFrom = $request->input('pageFrom');
        if($pageFrom == null){
            $pageFrom = 1;
        }
        $data   = Sale::paginate(50,['*'],'sPage');
        $title  = "sale";
        // 销售推广码
        $saleCodesale = SaleCode::where('type',0)
            ->orderBy('is_send','asc')
            ->paginate(50,['*'],'csPage');
        // 中介推广码
        $midCodesale = SaleCode::where('type',1)
            ->orderBy('is_send','asc')
            ->paginate(50,['*'],'msPage');
        return view('Back2.Sale.index',compact('data','title','saleCodesale','pageFrom','midCodesale'));
    }

    /**
     * method: 推广数据
     * author: hongwenyang
     * param:
     */
    public function saleData($id){
        $openid = Sale::where('user_id',$id)->value('open_id');
        $data = Sale::extensionList($openid);
        return view('Back2.Sale.data',compact('data'));
    }
}
