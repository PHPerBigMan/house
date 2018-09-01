<?php

namespace App\Http\Controllers;

use App\Model\Buy;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function allData(){
        $dataFirst = Buy::where([
            ['name','=',NULL],
            ['household','<>','']
        ])->count();

        $dataSecond = Buy::where([
            ['name','<>',""],
            ['status','=',6]
        ])
            ->count();

        $dataGet = Buy::whereIn('status',[
            0,1,2,3,4,5
        ])->count();

        // 总人数
        $dataAll = Buy::count();

        // 审核通过
        $dataPass= Buy::where('status',5)->count();

        $data = json_encode([
            $dataAll,$dataSecond,$dataFirst,$dataPass
        ]);


        return view("Back.Data",compact("data"));
    }
}
