<?php

namespace App\Http\Controllers;
use App\Models\Url;
use App\Models\Checkurl;
use Illuminate\Http\Request;
use App\Jobs\CheckUrlJob;

class UrlController extends Controller
{
    public function createUrlPost(Request $request){

        /** Валидируем данные, если все ок, шлем в базу **/
        $validatedData = $request->validate([
            'url' => 'required|url|max:255',
            'check_periodicity' => 'required|integer',
            'repeat_periodicity' => 'required|integer',
        ]);

        $newUrl = new Url($validatedData);

        try {
            $newUrl->save();
            //тут надо запустить очередь на проверку
            dispatch(new CHeckUrlJob($newUrl))->delay(now()->addSeconds(2));
            //--------------------------------------------
            return response()->json(['status'=>'successful', 'error'=>null], 200);
        } catch (\Exception $e) {
            return response()->json(['status'=>'unsuccessful','error' => 'Failed to save record.'], 422);
        }

    }

    public function showUrlsPost() {
        $urls = Url::all();
        return response()->json(['data' => $urls], 200);
    }

    public function getChecksPost(Request $request){
        try {
            $checkResults = CheckUrl::where('url_id', 'like', $request->id)->get();
            return response()->json(['status'=>'successful','data'=>$checkResults, 'error'=>null]);
        } catch (\Exception $e) {
            return response()->json(['status'=>'unSuccessful','data'=>null, 'error'=>'Failed to get info']);
        }
    }
}
