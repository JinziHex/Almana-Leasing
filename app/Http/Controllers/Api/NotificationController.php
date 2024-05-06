<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Notification;
use App\Models\Customer;
use Crypt;
use Auth;
use Hash;
use Carbon;
use Validator;


class NotificationController extends Controller
{
    public function listNotifications(Request $request)
    {
		$data = array();
    	try
    	{
    		$customerId = $request->customer_id;


    		$fetchCustData = Customer::where('customer_id','=',$customerId)->first();


    		if ($fetchCustData) {
    			
    			$fetchNotf = Notification::where('customer_id','=',$customerId)->limit(5)->get();
    			
    			if ($fetchNotf) {
    				$notfications = array();

    				foreach ($fetchNotf as $fetchNotfications) {
    					$notf['Id'] = $fetchNotfications->notification_id;
    					$notf['Title'] = $fetchNotfications->notification_title;
    					$notf['content'] = $fetchNotfications->notification_content;
    					if ($fetchNotfications->notification_status==0) {
    						$notf['Read_status'] = "Unread";
    						$notf['Read_status_code'] = "0";
    					}else{
							$notf['Read_status'] = "Read";
							$notf['Read_status_code'] = "1";
    					}
    					

    					array_push($notfications,$notf);
    				}
    				$data['status'] = "1";
    				$data['message'] = "Success";
    				$data['Notifications'] = $notfications;
    			}else{
    				$data['status'] = 0;
    			$data['message'] = "No Notifications Found";
    			}

    			
    		}else{
    			$data['status'] = "0";
    			$data['message'] = "No Customer Exist";
     		}
    		return response($data)->setStatusCode(200);
    	}catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];

            return response($response);
        }
    }

    public function updateStatus(Request $request)
    {
    	

    	$data = array();
    	try
    	{

    		$notfIds = $request->input('notification_id');

    	$expNotArray = explode(',', $notfIds);

    	Notification::whereIn('notification_id',$expNotArray)->update([

    			'notification_status' =>1

    	]);

    	$data['status'] = 1;
    	$data['message'] = "Status Updated";
    	$data['Id'] = $notfIds;
    		return response($data)->setStatusCode(200);
    	}catch (\Exception $e) {
           $response = ['status' => '0', 'message' => $e->getMessage()];
           return response($response);
        }catch (\Throwable $e) {
            $response = ['status' => '0','message' => $e->getMessage()];

            return response($response);
        }
    }



}
