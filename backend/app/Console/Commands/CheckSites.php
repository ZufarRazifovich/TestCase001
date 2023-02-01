<?php

namespace App\Console\Commands;

use App\Helpers\TranslitClass;
use App\Models\Point;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzleClient;
use Exception;
class CheckSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:sites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $endpoint = "https://mk-zoloto-lombard.kz/api/ru/layout-data";
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', $endpoint);

        $statusCode = $response->getStatusCode();
        $content = $response->getBody();
        //5558194873:AAE7PgNLE9N95tIrhaKMl5kWeJxkhayedIA
        $endpointTelega = 'https://api.telegram.org/bot5558194873:AAE7PgNLE9N95tIrhaKMl5kWeJxkhayedIA/sendMessage?chat_id=-755039911&text=Здравствуйте, сайт не работает';
        $clientTelega = new \GuzzleHttp\Client();
        if($statusCode != 200){
            $responsetelega = $clientTelega->request('get', $endpointTelega);

        Log::error('hi zufar, status status send message = '.$responsetelega->getStatusCode());
        }



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        

        $endpoint2 = "http://10.10.52.14/NSI/hs/CINSI/checkInternalNSI";
        // $endpoint2 = "http://192.168.2.53/NSITest/hs/CINSI/checkInternalNSI";

        $client2 = new \GuzzleHttp\Client();


        
        try {
            $response2 = $client2->request('GET', $endpoint2, ['auth' => ['onlineuser', 'negswuK~']]);
            Log::error($response2->getBody());
        } catch (Exception $e) {

            $endpointTelega2 = 'https://api.telegram.org/bot5558194873:AAE7PgNLE9N95tIrhaKMl5kWeJxkhayedIA/sendMessage?chat_id=-755039911&text=НСИ НЕ ПАХАЕТ!!!!!';
            $clientTelega = new \GuzzleHttp\Client();
            $responsetelega = $clientTelega->request('get', $endpointTelega2);

        } finally {
            echo "Первый блок finally.\n";
        }




        



        
        Log::error('hi zufar, status checksites 2 = '.$statusCode);
        
    
    }



    public function translateCity($city)
    {
        $tr = array(
            "А"=>"a", "Б"=>"b", "В"=>"v", "Г"=>"g", "Д"=>"d",
            "Е"=>"e", "Ё"=>"yo", "Ж"=>"zh", "З"=>"z", "И"=>"i",
            "Й"=>"y", "К"=>"k", "Л"=>"l", "М"=>"m", "Н"=>"n",
            "О"=>"o", "П"=>"p", "Р"=>"r", "С"=>"s", "Т"=>"t",
            "У"=>"u", "Ф"=>"f", "Х"=>"kh", "Ц"=>"ts", "Ч"=>"ch",
            "Ш"=>"sh", "Щ"=>"sch", "Ъ"=>"", "Ы"=>"y", "Ь"=>"",
            "Э"=>"e", "Ю"=>"yu", "Я"=>"ya", "а"=>"a", "б"=>"b",
            "в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"yo",
            "ж"=>"zh", "з"=>"z", "и"=>"i", "й"=>"y", "к"=>"k",
            "л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p",
            "р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f",
            "х"=>"kh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch",
            "ъ"=>"", "ы"=>"y", "ь"=>"", "э"=>"e", "ю"=>"yu",
            "я"=>"ya", " "=>"-", "."=>"", ","=>"", "/"=>"-",
            ":"=>"", ";"=>"","—"=>"", "–"=>"-"
        );
        $city_en = strtr($city,$tr);
        return $city_en;
    }




    
}
