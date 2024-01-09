<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\commonHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use merge;

class PreLoginController extends Controller
{

    public function emailRegistration(Request $request){
		
		$rules = [
			'email' => 'required|email',   
			'mobile' => 'required|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|min:10', 
            'password' => 'required|min:6', 
		];
		
		$validator = Validator::make($request->json()->all(), $rules);
		
		if ($validator->fails()) {
			$message = [];
			$messages_l = json_decode(json_encode($validator->messages()), true);
			foreach ($messages_l as $msg) {
				$message= $msg[0];
				break;
			}
			
			return response(array("error"=> true, "message"=>$message),200); 

		}else{

			try{
				
				//chk unique mobile
				$userResult=\App\Models\User::where([
											['mobile','=',$request->json()->get('mobile')],
											['email','=',$request->json()->get('email')]
											])->first();
				if(!$userResult){

					$otp = \App\Helpers\commonHelper::getOtp($request->json()->get('mobile'));

					$user=new \App\Models\User();
					$user->email=$request->json()->get('email');
					$user->mobile=$request->json()->get('mobile');
					$user->password=\Hash::make($request->json()->get('password'));
					$user->otp=$otp;
					$user->otp_verify='0';
					$user->user_type='Customer';
					$user->designation_id='2';
					$user->save();

					return response(array("error"=> true,'message'=>'Sent otp on your mobile number',"verify"=>true), 200);

				}else if($userResult['block_user']=='1'){
					
					return response(array("error"=> false, "message"=>"User is blocked. Please contact to administration"),200);
					
				}else{
					
					if(\Hash::check($request->json()->get('password'), $userResult->password)){

						if($userResult->otp_verify=='1'){
						
							$userResult->save();
	
							return response(array('error'=>false,"message"=>'Login Successfully',"token"=>$userResult->createToken('authToken')->accessToken,"verify"=>true,"result"=>$userResult->toArray()),200);
	
						}else{
							
							$otp = \App\Helpers\commonHelper::getOtp($request->json()->get('mobile'));
							
							return response(array("error"=> true,"message"=>"OTP verification is pending. So please first verify your account"),200);
							
						}
						
					}else{
						
						return response(array("error"=> true,"message"=>"Password incorrect. So please try again","verify"=>false),200);
						
					}
				}

			}catch (\Exception $e){
				
				return response(array("error" 
					=> true, "message" => $e->getMessage()),200); 
				
			}
		}
	}
	
	public function sendOtpOnMobile(Request $request){
		
		$rules = [
			'phone_code'=>'required',
            'mobile'=>'required|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|min:10', 
		];

		$validator = Validator::make($request->json()->all(), $rules);
		 
		if ($validator->fails()) {
			$message = [];
			$messages_l = json_decode(json_encode($validator->messages()), true);
			foreach ($messages_l as $msg) {
				$message= $msg[0];
				break;
			}
			
			return response(array("error"=> true, "message"=>$message),200); 
		}else{

			try{
				
				//chk unique email
				$emailResult=\App\Models\User::where([
										['phone_code','=',$request->json()->get('phone_code')],
										['mobile','=',$request->json()->get('mobile')]
										])->first();
										
				if(!$emailResult){
					
					return response(array("error"=> true, 'message'=>'Mobile is not registered with us. Please try another Mobile no.'),200);
				
				}elseif($emailResult->block_user==1){
					
					return response(array("error"=> false, 'message'=>'User is blocked. So please contact your administrator.'),200);
				
				}else{
					
					$otp=\App\Helpers\commonHelper::getOtp();
					
					\App\Models\User::where([
								['mobile','=',$request->json()->get('mobile')]
								])->update(['otp'=>$otp]);
								
					
					
					return response(array("error"=> false,'message'=>'OTP sent successfully on your registered Mobile no.'),200);
					
				}
				
			}catch (\Exception $e){
				
				return response(array("error" 
						=> true, "message" => $e->getMessage()),200); 
			
			}
		}
		
	}
	public function validateOtp(Request $request){
		
		$rules['mobile'] = 'required|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|min:10';
		$rules['otp'] = 'required|size:4';
		
		$validator = Validator::make($request->json()->all(), $rules);
		
		if ($validator->fails()) {
			$message = [];
			$messages_l = json_decode(json_encode($validator->messages()), true);
			foreach ($messages_l as $msg) {
				$message= $msg[0];
				break;
			}
			
			return response(array("error"=> true, "message"=>$message),200); 

		}else{

			try{
				
				if($request->json()->get('mobile')){
				
					//chk unique email
					$userResult=\App\Models\User::where([
														['mobile','=',$request->json()->get('mobile')],
														['otp','=',$request->json()->get('otp')],
														])->first();
						
				}

				if(!$userResult){
					
					return response(array("error"=> true, "message"=>"OTP doesn't exist. Please try again."),200);

				}elseif($userResult->block_user==1){
					
					return response(array("error"=> false, "message"=>'User is blocked. So please contact your administrator.'),200);
				
				}else{
					
					$userResult->otp='0';
					$userResult->status='1';
					$userResult->otp_verify='1';
					$userResult->save();
					
					return response(array("error"=> false, "message"=>"OTP matched successfully.","token"=>$userResult->createToken('authToken')->accessToken,"result"=>$userResult->toArray()),200);
					
				}
			}catch (\Exception $e){
				
				return response(array("error" 
						=> true, "message" => $e->getMessage()),200); 
			
			}
		}
	}

	public function forgotPassword(Request $request){

		$rules = [
            'new_password' => 'required|min:8', 
            'confirm_password' => 'required_with:new_password|same:new_password|min:8'
		];

		$validator = \Validator::make($request->json()->all(),$rules);

		if ($validator->fails()) {
			$message = [];
			$messages_l = json_decode(json_encode($validator->messages()), true);
			foreach ($messages_l as $msg) {
				$message= $msg[0];
				break;
			}
			
			return response(array("error"=>true, 'message'=>$message), 403);
			
		}else{

			try{

				$user = \Auth::user();

				if(!$user){

					return response(array("error"=> true, "message"=>"Account doesn't exist. Please try again."),200);

				}else{

					$user->update([
						'password' => \Hash::make($request->json()->get('new_password')),
					]);
	
					return response(array("error"=>true,'message'=>'Password reset successful'),200);
				}


			}catch (\Exception $e){
						
				return response(array("error" 
						=> true, "message" => $e->getMessage()),200); 
			
			}
		}
	}

	public function serviceRegistration(Request $request){                                                                                                                                                                                                                                                                                                                                                  
		
		$rules = [
			'shop_name' => 'required', 
			'owner_name' => 'required', 
			'mobile' => 'required|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|min:10', 
			'email' => 'nullable|email', 
            'password' => 'required|min:6', 
		];
		
		$validator = Validator::make($request->json()->all(), $rules);
		
		if ($validator->fails()) {
			$message = [];
			$messages_l = json_decode(json_encode($validator->messages()), true);
			foreach ($messages_l as $msg) {
				$message= $msg[0];
				break;
			}
			
			return response(array("error"=> true, "message"=>$message),200); 

		}else{

			try{
				
				//chk unique email
				$userResult=\App\Models\User::where([
											['mobile','=',$request->json()->get('mobile')],
											['email','=',$request->json()->get('email')]
											])->first();

				if(!$userResult){

					$otp = \App\Helpers\commonHelper::getOtp($request->json()->get('mobile'));

					$user=new \App\Models\User();
					$user->shop_name=$request->json()->get('shop_name');
					$user->owner_name=$request->json()->get('owner_name');
					$user->mobile=$request->json()->get('mobile');
					$user->email=$request->json()->get('email');
					$user->password=\Hash::make($request->json()->get('password'));
					$user->otp=$otp;
					$user->otp_verify='0';
					$user->user_type='ServicePartner';
					$user->designation_id='3';
					$user->save();

					return response(array("error"=> true,'message'=>'Sent otp on your mobile',"verify"=>true), 200);

				}else if($userResult['block_user']=='1'){
					
					return response(array("error"=> false, "message"=>"User is blocked. Please contact to administration"),200);
					
				}else{
					
					if(\Hash::check($request->json()->get('password'), $userResult->password)){

						if($userResult->otp_verify=='1'){
						
							$userResult->save();
	
							return response(array('error'=>false,"message"=>'Service partner login successfully',"token"=>$userResult->createToken('authToken')->accessToken,"verify"=>true,"result"=>$userResult->toArray()),200);
	
						}else{
							
							$otp = \App\Helpers\commonHelper::getOtp($request->json()->get('email'));
							
							return response(array("error"=> true,"message"=>"OTP verification is pending. So please first verify your account"),200);
							
						}
						
					}else{
						
						return response(array("error"=> true,"message"=>"Password incorrect. So please try again","verify"=>false),200);
						
					}
				}

			}catch (\Exception $e){
				
				return response(array("error" 
					=> true, "message" => $e->getMessage()),200); 
				
			}
		}
	}
	
}
