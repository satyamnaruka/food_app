<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
   public function add(Request $request){
    
        if($request->isMethod('post')){

            $rules=[
                'name'=>'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                $message='';
                $message_1 = json_decode(json_encode($validator->messages()), true);
                foreach($message_1 as $msg){
                    $message=$msg[0];
                    break;
                }

                return response(array('message'=>$message),403);
            }else{

                try{

                    if((int) $request->post('id')>0){
                        
                        $category=\App\Models\Category::find($request->post('id'));
                    }else{
                        $category= new \App\Models\Category();
                    }

                    $category->name=$request->post('name');
                    $category->save();

                    if((int) $request->post('id')>0){

                        return response(array('message'=>'Category update succesfully','reset'=>false),200);
                    }else{
                        return response(array('message'=>'Category add succesfully','reset'=>true),200);
                    }

                }catch( \Exception $e){
                    return response(array('message'=> $e->getmessage()),403);
                }
            }
        }

        $result=[];
        return view('admin.category.add',compact('result'));
    
   }

   public function list(){

        $result=\App\Models\Category::get();

        return view('admin.category.list',compact('result'));
    }


   public function update($id){

        $result=\App\Models\Category::find($id);

        if($result){

            return view('admin.category.add',compact('result'));
        }else{

            return redirect()->back()->with('5fernsadminerror','Something went wrong. Please try again.');
        }
   }

   public function delete(Request $request ,$id){

        $checkResult=\App\Models\Category::find($id);

        if($checkResult){
          
            \App\Models\Category::where('id',$checkResult->id)->delete();

			$request->session()->flash('5fernsadminsuccess','Category deleted successfully.');
		}else{
			$request->session()->flash('5fernsadminerror','Something went wrong. Please try again.');
		}
		
		return redirect()->route('admin.category.list');
   }

   public function status(Request $request){

    \App\Models\Category::where('id',$request->post('id'))->update(['status'=>$request->post('status')]);

    return response(array('message'=>'Category status change succesfully'));

   }
}
