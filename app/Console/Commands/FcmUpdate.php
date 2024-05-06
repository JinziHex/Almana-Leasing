<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;

use App\Models\Modal;

use App\Models\Mode_rate;

use App\Models\Rate_type;

use App\Models\Model_group;

class FcmUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcm:update';

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
     * @return int
     */
    public function handle()
    {
        Log::info('updating');
        //DB::table('test_tb')->insert(['name'=>"test1"]);
        $client = new \GuzzleHttp\Client();
            $api = $client->get('http://130.61.97.192:201/F_CAR_MODEL_VIEW');
            
            $data = $api->getBody()->getContents();
            $response = json_decode($data, true); 
            
            
            foreach($response['Items'] as $element) {
                $makerId = $element['FCM_MAKE_NO'];
                $modelId=$element['FCM_MODEL_NO'];
                $modelName = $element['FCM_ENAME'];
                $modelCategory = $element['FCM_CATEGORY_CODE'];
                $groupCode =  $element['FCM_GROUP'];
                $rdyCount =  $element['RDY_COUNT'];
                $fetchGroup = Model_group::where('group_code','=',$groupCode)->first();
                $groupId = @$fetchGroup['group_id'];
                
                
                Modal::updateOrCreate(
                    [
                        'model_number'=>$modelId,
                        'makers' => $makerId,
                        'modal_category' => $modelCategory,
                        
                    ],
                     [
                        'model_number'=>$modelId,
                        'modal_name' => $modelName,
                        'modal_category' => $modelCategory,
                        'makers' => $makerId,
                        'group_id' => $groupId,
                        'rdy_count' => $rdyCount,
                        
                    ]);
                
            }
            
            $client2 = new \GuzzleHttp\Client();
            $api2 = $client2->get('http://130.61.97.192:201/MODEL_RATES_VIEW');
            $data2 = $api2->getBody()->getContents();
            $response2 = json_decode($data2, true); 
            
            foreach($response2['Items'] as $element2) {
                $makerId = $element2['MAKE'];
                $modelId = $element2['MODEL'];
                $modelYear = $element2['MODEL_YEAR'];
                $rateTypeCode = $element2['RATE_CODE'];
                $fetchRateType = Rate_type::where('rate_type_code','=',$rateTypeCode)->first();
                $rateTypeId = $fetchRateType['rate_type_id'];
                $rate =  $element2['RATE'];
                $minRate = $element2['MIN_RATE'];
                
                Mode_rate::updateOrCreate(
                    [
                        'maker_id' => $makerId,
                        'model_id' => $modelId,
                        'model_year' => $modelYear,
                        'rate_type_id' => $rateTypeId,
                        'rate_code' => $rateTypeCode,
                    ],
                    [
                        'maker_id' => $makerId,
                        'model_id' => $modelId,
                        'model_year' => $modelYear,
                        'rate_type_id' => $rateTypeId,
                        'rate_code' => $rateTypeCode,
                        'rate' =>$rate,
                        'model_min_rate' => $minRate,
                    ]);
                
            }
    }
}
