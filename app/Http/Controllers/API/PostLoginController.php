<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\commonHelper;
use DB; 
use Validator;
use App\Models\Event;
use Hash;

class PostLoginController extends Controller
{

	public function userProfile(Request $request){
 
		try{
				
				$imagePath = "";
				if(!empty($request->user()->image)){
				  $imagePath = 	asset('uploads/users/'.$request->user()->image);
				}
				$result = [
					'name'=>$request->user()->name,
					'mobile'=>$request->user()->mobile,
					'gender'=>$request->user()->gender,
					'email'=>$request->user()->email,
					'age'=>$request->user()->age,
					'weight'=>$request->user()->weight,
					'emergencycontact_name'=>$request->user()->emergencycontact_name,
					'emergencycontact_relation'=>$request->user()->emergencycontact_relation,
					'emergencycontact_number'=>$request->user()->emergencycontact_number,
					'location'=>$request->user()->location,
					'allergies'=>$request->user()->allergies,
					'current_medication'=>$request->user()->current_medication,
					'past_medication'=>$request->user()->past_medication,
					'chronic_diseases'=>$request->user()->chronic_diseases,
					'injuries'=>$request->user()->injuries,
					'surgery'=>$request->user()->surgery,
					'smoking_habits'=>$request->user()->smoking_habits,
					'alcohol_consumption'=>$request->user()->alcohol_consumption,
					'activity_level'=>$request->user()->activity_level,
					'occupation'=>$request->user()->occupation,
					'food_preferences'=>$request->user()->food_preferences,
					'blood_group'=>$request->user()->blood_group,
					'image'=>$imagePath

				];
			
			return response(array('message'=>"Profile data fetched successfully.","result"=>$result),200);

			
		}catch (\Exception $e){
			
			return response(array("error"=>true, "message" => $e->getMessage()),200);  
		
		} 	 
		
	}
	
	public function updateProfile(Request $request){
	
		try{
			
				$user= \App\Models\User::find($request->user()->id);
				
				if($request->hasFile('image')){
					$imageData = $request->file('image');
					$image = strtotime(date('Y-m-d H:i:s')).'.'.$imageData->getClientOriginalExtension();
					$destinationPath = public_path('/uploads/users');
					$imageData->move($destinationPath, $image);
					
					$user->image=$image;
				}

				$user->name=$request->post('name');
				$user->gender=$request->post('gender');
				$user->email=$request->post('email');
				$user->age=$request->post('age');
				$user->weight=$request->post('weight');
				$user->emergencycontact_name=$request->post('emergencycontact_name');
				$user->emergencycontact_relation=$request->post('emergencycontact_relation');
				$user->emergencycontact_number=$request->post('emergencycontact_number');
				$user->location=$request->post('location');
				$user->allergies=$request->post('allergies');
				$user->current_medication=$request->post('current_medication');
				$user->past_medication=$request->post('past_medication');
				$user->chronic_diseases=$request->post('chronic_diseases');
				$user->injuries=$request->post('injuries');
				$user->surgery=$request->post('surgery');
				$user->smoking_habits=$request->post('smoking_habits');
				$user->alcohol_consumption=$request->post('alcohol_consumption');
				$user->activity_level=$request->post('activity_level');
				$user->occupation=$request->post('occupation');
				$user->food_preferences=$request->post('food_preferences');
				$user->blood_group=$request->post('blood_group');
				$user->save();
				
				return response(array('message'=>'Profile updated successfully.'),200);
				
			
		}catch (\Exception $e){
			
			return response(array("error"=>true, "message" => $e->getMessage()),200); 
			
		}
	}
	
	public function logout(Request $request){

		$request->user()->token()->revoke();

		return response(array('message'=>'Logout successfully.'),200);
	}

	
	public function categoryList(){

		try{

			$categoryResult = \App\Models\Category::where('status','1')->get();

			if($categoryResult->count()==0){

				return response(array("error"=>true,'message'=>'Data not found'),200);
				
			}else{
				$result=[];
				foreach($categoryResult as $val){
					
					$result[]=[
						'id'=>($val['id']),
						'name'=>($val['name'])
					];
				}
				return response(array('message'=>'category fatch successfully','result'=>$result),200);
			}
		}catch(\Exception $e){
			return response(array("error"=>true,'message'=> $e->getmessage()),200);
		}
	}

	public function productList(){

		try{

			$productResult = \App\Models\Product::where('status','1')->get();

			if($productResult->count()==0){

				return response(array("error"=>false,'message'=>'product not found'),200);
			}else{
				$result=[];
				foreach($productResult as $val){
					$result[]=[
						'id'=>($val['id']),
						'category_id'=>($val['category_id']),
						'name'=>(ucfirst($val['name'])),
						'size'=>($val['size']),
						'time'=>($val['time']),
						'price'=>($val['price']),
						'rating'=>($val['rating']),
						'description'=>($val['description']),
						'image'=>(asset('uploads/product/'.$val->image))
					];
				}
			}
			return response(array("error"=>false,'message'=>'Product fatch successfully','result'=>$result),200);
		}catch(\Exception $e){
			return response(array("error"=>true,'message'=> $e->getmessage()),200);
		}
	}

	public function getProductByCate(Request $request,$id){

		try{
				
			$result=\App\Models\Product::where('category_id',$id)->where('status','1')->get();

			if($result->count()==0){
				return response(array('error'=>false,'message'=>'data not found'),200);
			}else{
				$productResult=[];
				foreach($result as $val){
					$productResult[]=[
						'id'=>($val['id']),
						'category_id'=>($val['category_id']),
						'name'=>(ucfirst($val['name'])),
						'size'=>($val['size']),
						'time'=>($val['time']),
						'price'=>($val['price']),
						'rating'=>($val['rating']),
						'description'=>($val['description']),
						'image'=>(asset('uploads/product/'.$val->image))
					];
				}

				return response(array("error"=>false,'message'=>'Product fatch successfully','result'=>$productResult),200);

			}
		}catch(\Exception $e){
			return response(array("error"=>true,'message'=> $e->getmessage()),200);
		}
	}

	public function addToCart(Request $request){
		
		$rules=[
			'product_id'=>'required|exists:products,id',
			'qty'=>'required|numeric',
			'price'=>'required|numeric',
			'add_type'=>'required|in:add,update'
		];

		$validator = Validator::make($request->json()->all(), $rules);

		if($validator->fails()){
			$message='';
			$message_1 = json_decode(json_encode($validator->message()),true);
			foreach($message_1 as $msg){
				$message=$msg=[0];
				break;
			}

			return response(array("error"=>true,'message'=>$message),403);
		}else{

			try{

				$cart = \App\Models\AddtoCart::where([
												['user_id',\Auth::User()->id],
												['product_id',$request->json()->get('product_id')]
												])->first();
				if(!$cart){

					$cart = new \App\Models\AddtoCart();

					$cart->user_id=\Auth::User()->id;
					$cart->product_id=$request->json()->get('product_id');
					$cart->price=$request->json()->get('price');
					$cart->qty=$request->json()->get('qty');
				}else{
					
					if($request->json()->get('add_type')=='add'){

						$cart->qty+=$request->json()->get('qty');

					}else{

						$cart->qty=$request->json()->get('qty');
					}
					
				}
				$cart->save();
				
				if($request->json()->get('id')>0){
					
					return response(array("message" => "Cart updated successfully."),200); 
				}else{
					
					return response(array("message" => "Item successfully added into cart."),200); 
				}

			}catch(\Exception $e){
				return response(array("error"=>true,'message'=> $e->getmessage()),403);
			}
		}

	}


}
