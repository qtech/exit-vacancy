<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Payment;

class PaymentDetailsController extends Controller
{
    public function get_paymentdetails(Request $request)
	{
		try
		{
			$collect = Payment::where(['hotel_owner_id' => $request->hotel_owner_id])->first();
			
			$data['hotel_owner_id'] = $collect['hotel_owner_id'];
			$data['account_name'] = $collect['account_name'];
			$data['account_type'] = $collect['account_type'];
			$data['routing_number'] = $collect['routing_number'];
			$data['account_number'] = $collect['account_number'];			    
			$data['email'] = $collect['email'];
			$data['day'] = $collect['day'];
			$data['month'] = $collect['month'];
			$data['year'] = $collect['year'];
			$data['fname'] = $collect['fname'];
			$data['lname'] = $collect['lname'];

			$response = [
				'msg' => "Available payment details",
				'status' => 1,
				'data' => $data
			];
		}
		catch(\Exception $e)
		{
			$response = [
				'msg' => $e->getMessage()." ".$e->getLine(),
				'status' => 0
			];	
		}
		return response()->json($response);
	}

	public function store_update_paymentdetails(Request $request)
	{
		try
		{
			\Stripe\Stripe::setApiKey("sk_test_KEUSUQH902gEBJ5ETpswMMjE");
			$get = Payment::where(['hotel_owner_id' => $request->hotel_owner_id])->first();

			if(count($get) > 0)
			{
				$details = Payment::find($get->payment_id);
				$details->hotel_owner_id = $request->hotel_owner_id;
				$details->account_name = $request->account_name;
				$details->account_type = $request->account_type;
				$details->routing_number = $request->routing_number;
				$details->account_number = $request->account_number;
				$details->email = $request->email;
				$details->day = $request->day;
				$details->month = $request->month;
				$details->year = $request->year;
				$details->fname = $request->fname;
				$details->lname = $request->lname;
				$details->save();

				$bank = \Stripe\Token::create([
				    "bank_account" => [
					    "country" => "US",
					    "currency" => "usd",
					    "account_holder_name" => $request->account_name, 
					    "account_holder_type" => $request->account_type, 
					    "routing_number" => $request->routing_number,
					    "account_number" => $request->account_number
					 ]
				]);

				$acc  = \Stripe\Account::create(array(
				  "country" => "US",
				  "email" => $request->email,
				  "type" => "custom"
				));
				
				$account = \Stripe\Account::retrieve($acc->id);
				$account->legal_entity->dob->day = $request->day;
		        $account->legal_entity->dob->month = $request->month;
		        $account->legal_entity->dob->year = $request->year;
		        $account->legal_entity->first_name = $request->fname;
		        $account->legal_entity->last_name = $request->lname;
		        $account->legal_entity->type = $request->account_type;
		        $account->external_account = $bank->id;
		        $account->save();

				$details->bank_id = $bank->id;
				$details->account_id = $account->id;
				$details->save();

				$status = User::where(['id' => $request->hotel_owner_id])->first();
				$status->bank_status = 1;
				$status->save();

				$response = [
					'msg' => "Your details have been updated successfully",
					'status' => 1
				];
			}
			else
			{
				$details = new Payment;
				$details->hotel_owner_id = $request->hotel_owner_id;
				$details->account_name = $request->account_name;
				$details->account_type = $request->account_type;
				$details->routing_number = $request->routing_number;
				$details->account_number = $request->account_number;
				$details->email = $request->email;
				$details->day = $request->day;
				$details->month = $request->month;
				$details->year = $request->year;
				$details->fname = $request->fname;
				$details->lname = $request->lname;
				$details->save();

				$bank = \Stripe\Token::create([
				    "bank_account" => [
					    "country" => "US",
					    "currency" => "usd",
					    "account_holder_name" => $details->account_name, 
					    "account_holder_type" => $details->account_type, 
					    "routing_number" => $details->routing_number,
					    "account_number" => $details->account_number
					 ]
				]);

				$acc  = \Stripe\Account::create(array(
				  "country" => "US",
				  "email" => $details->email,
				  "type" => "custom"
				));
				
				$account = \Stripe\Account::retrieve($acc->id);
				$account->legal_entity->dob->day = $request->day;
		        $account->legal_entity->dob->month = $request->month;
		        $account->legal_entity->dob->year = $request->year;
		        $account->legal_entity->first_name = $request->fname;
		        $account->legal_entity->last_name = $request->lname;
		        $account->legal_entity->type = $request->account_type;
		        $account->external_account = $bank->id;
		        $account->save();

				$details->bank_id = $bank->id;
				$details->account_id = $account->id;
				$details->save();

				$status = User::where(['id' => $request->hotel_owner_id])->first();
				$status->bank_status = 1;
				$status->save();

				$response = [
					'msg' => "Your details have been stored successfully",
					'status' => 1
				];
			}
		}
		catch(\Exception $e)
		{
			$response = [
				'msg' => $e->getMessage(),
				'status' => 0
			];	
		}
		return response()->json($response);
	}

	public function storeCard(Request $request)
	{
		try
		{
			\Stripe\Stripe::setApiKey("sk_test_KEUSUQH902gEBJ5ETpswMMjE");

			$storecard = User::find($request->user_id);

			/*$token = \Stripe\Token::create(array(
			  "card" => [
			  	"name" => "Shreeraj Jadeja",
			    "number" => "4000056655665556",
			    "exp_month" => 5,
			    "exp_year" => 2019,
			    "cvc" => "314"
			  ]
			));*/

			$customer = \Stripe\Customer::create([
			  	"description" => "ExitVacancy User",
			  	"source" => $request->token
			]);
			
			$storecard->customer_id = $customer->id;
			$storecard->save();

			$response = [
				'msg' => "Success",
				'status' => 1
			];
		}
		catch(\Exception $e)
		{
			$response = [
				'msg' => $e->getMessage(),
				'status' => 0
			];	
		}
		return response()->json($response);
	}

	public function getCard_details(Request $request)
	{
		try
		{
			\Stripe\Stripe::setApiKey("sk_test_KEUSUQH902gEBJ5ETpswMMjE");

			$getcard = User::find($request->user_id);

			if($getcard->customer_id != NULL)
			{
				$customer = \Stripe\Customer::retrieve($getcard->customer_id);
				$card = $customer->sources->retrieve($customer->sources->data['0']->id);

				$data = [
					'name' => ($card->name != NULL) ? $card->name : '',
					'exp_month' => $card->exp_month,
					'exp_year' => $card->exp_year,
					'last4' => $card->last4
				];

				$response = [
					'msg' => "Your card details",
					'status' => 1,
					'data' => $data
				];
					
			}
			else
			{
				$response = [
					'msg' => "You haven't added any Card details yet",
					'status' => 0
				];
			}
		}
		catch(\Exception $e)
		{
			$response = [
				'msg' => $e->getMessage(),
				'status' => 0
			];	
		}
		return response()->json($response);
	}

	public function split_payment_live(Request $request)
	{
		try
    	{	
    		\Stripe\Stripe::setApiKey("sk_test_KEUSUQH902gEBJ5ETpswMMjE");
            $check_user = User::find($request->user_id);
            $admin = User::find(1);
    		
			$account = Payment::where(['hotel_owner_id' => $request->hotel_owner_id])->first();
            $amount = $request->amount * 100;
            $hotel_percentage = (100 - $admin->lname);
			$hotel_payment = ($hotel_percentage / 100) * $amount;

			$charge = \Stripe\Charge::create([
			  "amount" => $amount,
			  "currency" => "usd",
			  "customer" => $check_user->customer_id,
			  "destination" => [
			    "amount" => $hotel_payment,
			    "account" => $account->account_id,
			  ],
			]);	

			$response = [
				'msg' => "Payment successfully done",
				'status' => 1,
				'data' => $charge
			];
    	}
    	catch(\Exception $e)
    	{
			$response = [
				'msg' => $e->getMessage(),
				'status' => 0
			];	
    	}

    	return response()->json($response);
	}
}