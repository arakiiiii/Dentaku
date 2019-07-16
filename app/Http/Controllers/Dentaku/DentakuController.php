<?php

namespace App\Http\Controllers\Dentaku;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Session;

class DentakuController extends Controller
{
    /**
     * 履歴表示アクション
     */
    public function home(Request $request){
        //履歴を取得
        \Log::info(__METHOD__);
        $logic = new \App\Http\Logic\Dentaku\DentakuLogic;
        $histories = $logic->showHistoryLogic();

        // dd($histories->getForView($request));
		return view('dentaku.home', $histories->getForView($request));
    }

    /**
     * 履歴にデータを追加する
     */
    public function sendData(Request $request){

        \Log::info(__METHOD__);

        //送られたデータを計算
        $logic = new \App\Http\Logic\Dentaku\DentakuLogic;
        $results = $logic->validate($request);
		if ($results->getStatus() === \App\Http\Logic\LogicResultDTO::SUCCESS) {
            // エラー出ない場合は計算を実行する
            $results = $logic->saveDataLogic($request);
            // VIEW用の配列に詰めて終了
			return $results->getForView($request);
		} else {
            // エラーの場合、エラー内容をVIEW用の配列を詰めて終了
            return view("dentaku.error",$results->getForView($request));
        }

    }

    /**
     * 履歴をすべて消去する
     */
    public function deleteData(Request $request){
        \Log::info(__METHOD__);

        //データを削除
        $logic = new \App\Http\Logic\Dentaku\DentakuLogic;
        $logic->deleteDataLogic();
        return;
    }
}
