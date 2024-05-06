<?php

namespace App\Helpers;

use App\Coupon;
use Illuminate\Support\Str;
use Crypt;
use  Carbon\Carbon;
use App\Models\Mode_rate;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;
use Validator;


class Helper {

    public static function dateFormat()
    {
        return \Carbon\Carbon::now();
    }

    public static function decryptSting($decrypt)
    {
        return Crypt::decryptString($decrypt);
    }

    public static function nameSlug($title)
    {
        $slugFormat = Str::of($title)->slug('-');
        $trimSlug = Str::of($slugFormat)->trim();
        return  $trimSlug;
    }

    public static function parseCarbon($date)
    {
        return Carbon::parse($date);
    }
    public static function setType($days)
    {
        if($days/30 >= 1) //monthly
        {
            $type = [8];

        // }elseif($days/14 >= 1){ //fortnight

        //     $type = [3];
        }elseif($days/7 >= 1){ //weekly
            $type = [2];
            
        }else{ //daily
            $type = [1];
        }
        
        return $type;
    }
//new helper calculation
public static function showList($days, $rate)
{
    if ($days >= 30) {
        // Monthly rate
        $monthlyRate = $rate;
        $perDayRate = $monthlyRate / 30;
        $totalAmount = $monthlyRate;

        if ($days > 30) {
            
            $remainingDays = $days - 30;
            if ($remainingDays >= 7) {
                // Apply weekly rate
                $totalAmount += ($remainingDays / 7) * ($rate / 4);
            } else {
                // Apply daily rate
                $totalAmount += $remainingDays * $perDayRate;
            }
        }
    } elseif ($days >= 7) {
        // Weekly rate
        $weeklyRate = $rate;
        $perDayRate = $weeklyRate / 7;
        $totalAmount = $weeklyRate;

        if ($days > 7) {
            // Apply daily rate
            $remainingDays = $days - 7;
            $totalAmount += $remainingDays * $perDayRate;
        }
    } else {
        // Daily rate
        $dailyRate = $rate;
        $perDayRate = $dailyRate;
        $totalAmount = $dailyRate * $days;
    }

    $perDayRate = number_format($perDayRate, 2, '.', '');
    $totalAmount = number_format($totalAmount, 2, '.', '');

    return [
        'perDayRate' => number_format((float)$perDayRate, 2, '.', ''),
        'totValue' => number_format((float)$totalAmount, 2, '.', ''),
    ];
}
    // public static function showList($days,$rate)
    // {
    //     if($days/30 >= 1) //monthly
    //     {
    //         $weeklyRate = $rate; //get the monthly rate of the model
    //         $perDayRate = $weeklyRate/30; //calculateper day rate based on monthly rate 
    //         $value = number_format($perDayRate*$days, 2, '.', '');

    //     // }elseif($days/14 >= 1){ //fortnight

    //     //      $weeklyRate = $rate; //get the fortnight rate of the model
    //     //           $perDayRate = $weeklyRate/14; //calculate per day rate based on fortnight rate
    //     //           $value = number_format($perDayRate*$days, 2, '.', '');

    //     }elseif($days/7 >= 1){ //weekly
            
    //          $weeklyRate = $rate; // get the weekly rate of the model 
    //               $perDayRate = $weeklyRate/7; //calculate per day rate based on weekly rate
    //               $value = number_format($perDayRate*$days, 2, '.', '');
    //     }else{ //daily
    //          $weeklyRate = $rate; //get the daily rate of the model
    //               $perDayRate = $weeklyRate/1; //calculate per day rate based on daily rate
    //               $value = number_format($perDayRate*$days, 2, '.', '');

    //     }
    //     $valuert = array();
    //     $valuert['perDayRate'] = (float)$perDayRate;
    //     $valuert['totValue'] = $value;
    //     return $valuert;
    // }

    public static function validateBooking($valid)
    {
        $validate = Validator::make($valid, [   
                'book_from_date' =>'required',
                'book_to_date'=>'required',
                'book_pickup_time' => 'required',
                'book_return_time' =>'required',
                'book_car_model'   =>'required',
                'book_daily_rate'=>'required',
                'book_total_rate' =>'required',
                'book_cust_id' => 'required',
                'book_bill_cust_fname' =>  'required|string',
                'book_bill_cust_lname' =>   'required|string',
                'book_bill_cust_mobile_code' => 'required|max:3',
                'book_bill_cust_mobile' =>  'required',
                // 'book_bill_cust_qatar_id' =>  'required|max:12',
                // 'book_bill_cust_qatar_id'=>'nullable|sometimes|min:11|max:11',
                // 'cust_passport' =>'required_without:book_bill_cust_qatar_id|nullable|sometimes',
                'book_bill_cust_nationality' => 'required',
                'book_bill_cust_address_1' => 'required',
                'book_bill_cust_city' =>  'required|integer',
                // 'book_bill_cust_state' => 'required',
                // 'book_bill_cust_zipcode' => 'required',
                'book_bill_cust_location' =>  'required|integer',

            ],
            [   
                'book_from_date.required' => "From Date is Required",
                'book_to_date.required' => "To Date is Required",
                'book_pickup_time.required' => "Pickup Time should be selected",
                'book_return_time.required'=> 'Return Time should be selected',
                'book_car_model.required' => 'Car Model field cannot be empty',
                'book_daily_rate.required' => 'Daily Rate is Required',
                'book_total_rate.required' => 'Total Rate is Required',
                'book_cust_id.required' => 'Customer Id cannot be null',
                'book_bill_cust_fname.required'=>'First name is required',
                'book_bill_cust_lname.required' => 'Last name is required',
                'book_bill_cust_mobile_code.required' => 'Mobile code is required',
                'book_bill_cust_mobile.required' => 'Mobile Number is required',
                // 'book_bill_cust_qatar_id.required' => 'Id Number is required',
                'book_bill_cust_nationality.required' => 'Nationality is required',
                'book_bill_cust_address_1.required' => 'Address field cannot be empty',
                'book_bill_cust_city.required' => 'City is required',
                // 'book_bill_cust_state.required' => 'State is required',
                // 'book_bill_cust_zipcode.required' => 'Zipcode is required',
                'book_bill_cust_location.required' => 'Location is required',

            ]);
        return $validate;
    }

public static function CouponCurrentStatus($id)
{
    $coupon=Coupon::where('id',$id);
    if($coupon->exists())
    {
        if($coupon->first()->is_active==1)
        {
            if(date('Y-m-d')<=$coupon->first()->end_date)
            {
              return "Active";
            } 
            else
            {
              return "Expired";
            }

        }
        else
        {
            return "Inactive";
        }
       
    }
    else
    {
        return "Fail";
    }

}

public static  function checkOffer($model_rate_id,$model_id)
{
  $model_rate=Mode_rate::findOrFail($model_rate_id);
  $promotion=DB::table('promotions')->where('modal_id',$model_id)
            ->where('start_date', '<=', date("Y-m-d"))
            ->where('end_date', '>=', date("Y-m-d"))
            ->whereNull('deleted_at');
  //return $model_rate_id;
  if($promotion->exists())
  {
    
    $offer_rate=$model_rate->rate-$model_rate->rate*($promotion->first()->price/100);
    return $offer_rate;
  }
  else
  {
     return $model_rate->rate;
  }
    
}
  public static function customerNotification($device_id, $title, $body, $clickAction, $type)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $api_key = 'AAAAoZLmpxE:APA91bGq9TOkFr0LkT0mGJt6v0ULvWCSRyrvW1-rnpJmSi5g1YaUXuYX7AG0xkNGEAAJoRMtNa7juyEhJx3bsFXFVlRvPTZj9phjobLXuz5o_8xoi7DpaZBrCl-RRe3_2-nyHsEmIBte';
        
        $fields = array(
            'to' => $device_id,
            'notification' => array('title' => $title, 'body' => $body,'click_action' => $clickAction),
            'data' => array('title' => $title, 'body' => $body, 'type' => $type),
        );
        
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $api_key
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        

        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }

        curl_close($ch);
        return $result;
    }
    
}
