<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use App\Jobs\CheckUrlJob;
use App\Models\Checkurl;
use App\Models\Url;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckUrlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $urlObj;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($urlObj)
    {
        $this->urlObj = $urlObj;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $check = $this->CheckCreate($this->urlObj);
        try {
            if($check == false){exit();}
            $response = Http::get($this->urlObj['url']);
            if ($response->status() == 200) {
                $check->http_code = $response->status();
                $check->save();

                $this->resetJob($this->urlObj);

                Log::error('Сайт доступен');
            }
        } catch (\Exception $e) {
            Log::error($e);
            Log::error('Сайт не доступен');
            $check->http_code = 500;
            $check->save();
            $this->resetJobAfterError($this->urlObj);
        }
    }
    public function CheckCreate($obj){
            $selectedUrl = Checkurl::where('url_id', 'like', $obj['id'])->orderByDesc('id')->first();   //Проверяем были ли проверки, если да то тянем последнюю
            if(isset($selectedUrl)){
                if($selectedUrl->attempt_number >= $obj['repeat_periodicity']){
                    return false;
                }
            }
             if(isset($selectedUrl)){
                 $newUrl = new Checkurl();
                 $newUrl->url_id = $obj['id'];
                 $newUrl->http_code = 0;
                 $newUrl->attempt_number = $selectedUrl->attempt_number + 1;
                 $newUrl->save(); return $newUrl;
             }else{
                 $newUrl = new Checkurl();
                 $newUrl->url_id = $obj['id'];
                 $newUrl->http_code = 0;
                 $newUrl->attempt_number = 1;
                 $newUrl->save(); return $newUrl;
            }

    }
    public function resetJobAfterError($obj){
        dispatch(new CHeckUrlJob($obj))->delay(now()->addSeconds(60));
    }
    public function resetJob($obj){
        dispatch(new CHeckUrlJob($obj))->delay(now()->addMinutes($obj->check_periodicity));
    }
}

// 1. Создаем запись checkurl()
// 2. Проводим проверку, если успех, тогда записываем Url() - как успешный
// 3. Если проверка прошла безуспешно, проверяем сколько раз мы должны его проверять(repeat_periodicity)
// 4. если лимит еще есть создаем еще одно задание, через время которое указано в url (check_periodicity)
//
//
//