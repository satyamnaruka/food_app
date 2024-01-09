<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use \App\Models\Slider;

class SliderController extends Controller{

    public function add(Request $request){

		if($request->isMethod('post')){
			
			$rules=[
				'title'=>'required',
			];
			 
			if((int) $request->post('id')==0){
						
				$rules['image']='required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1921,height=929';

			}
					
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()){
				$message = "";
				$messages_l = json_decode(json_encode($validator->messages()), true);
				foreach ($messages_l as $msg) {
					$message= $msg[0];
					break;
				}
				
				return response(array('message'=>$message),403);
				
			}else{
				
				try{
					if((int) $request->post('id')>0){
						
						$slider=Slider::find($request->post('id'));
					}else{
						
						$slider=new Slider();
					
					}
					
					$image=$request->post('old_image');

					if($request->hasFile('image')){
						$imageData = $request->file('image');
						$image = strtotime(date('Y-m-d H:i:s')).'.'.$imageData->getClientOriginalExtension();
						$destinationPath = public_path('/uploads/sliders');
						$imageData->move($destinationPath, $image);
						$slider->image=$image;

					} 

					$slider->title=$request->post('title');
					$slider->save();
					
					if((int) $request->post('id')>0){
						
						return response(array('message'=>'Slider updated successfully.','reset'=>false),200);
					}else{
						
						return response(array('message'=>'Slider added successfully.','reset'=>true,'script'=>true),200);
					
					}
				}catch (\Exception $e){
			
					return response(array("message" => $e->getMessage()),403); 
				
				}
			}
			
			return response(array('message'=>'Data not found.'),403);
		}
		
		$result=[];
        return view('admin.slider.add',compact('result'));
    }
	
	public function sliderList(){
		
		$result=Slider::orderBy('id','ASC')->get();
		
		return view('admin.slider.list',compact('result'));
	}
	
	public function changeStatus(Request $request){
		
		Slider::where('id',$request->post('id'))->update(['status'=>$request->post('status')]);
		
		return response(array('message'=>'Slider status changed successfully.'),200);
	}
	
	
	public function updateSlider(Request $request,$id){
		
		$result=Slider::find($id);
		
		if($result){
			
			return view('admin.slider.add',compact('result'));
			
		}else{
			
			return redirect()->back()->with('5fernsadminerror','Something went wrong. Please try again.');
		}
		
	}
	
	
	public function deleteSlider(Request $request, $id){
		
		$checkResult=\App\Models\Slider::find($id);
		
		if($checkResult){

			\App\Models\Slider::where('id', $id)->delete();
			$request->session()->flash('5fernsadminsuccess','Slider deleted successfully.');
		}else{
			$request->session()->flash('5fernsadminerror','Something went wrong. Please try again.');
		}
		
		return redirect()->route('admin.slider.list');

    }

	public function changeOrder(Request $request){
		$allData = $request->allData;
		$i = 1;
		foreach ($request->allData as $key => $value) {
			\DB::table('sliders')->where('id',$value)->update(array('sort_order'=>$i));
			$i++;
		}
		echo "Success"; 
		die;
	}
	
}
