<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function add(Request $request){

        if($request->isMethod('post')){

            $rules=[
                'category_id'=>'required',
                'name'=>'required',
                'price'=>'required',
                'time'=>'required',
                'size'=>'required',
                'description'=>'required',
                'rating'=>'required'
            ];

            if((int) $request->post('id')==0){

                $rules['image']='required';
            }

            $validator = Validator::make($request->all(),$rules);

            if($validator->fails()){
                $message='';
                $message_1= json_decode(json_encode($validator->messages(),true));
                foreach($message_1 as $msg){
                    $message=$msg[0];
                    break;
                }

                return response(array('message'=>$message),403);
            }else{

                try{
                    if((int) $request->post('id')>0){

                        $product = Product::find($request->post('id'));
                    }else{
    
                        $product = new Product();
                    }
                    $image=$request->post('old_image');

                    if($request->hasFile('image')){
                        $imageName = $request->file('image');
                        $image= strtotime(date('Y-m-d H:i:s')).'.'.$imageName->getClientOriginalExtension();
                        $destinationPath = public_path('uploads/product');
                        $imageName->move($destinationPath, $image);

                        $product->image=$image;
                    }
    
                    $product->category_id=$request->post('category_id');
                    $product->name=$request->post('name');
                    $product->size=$request->post('size');
                    $product->time=$request->post('time');
                    $product->rating=$request->post('rating');
                    $product->price=$request->post('price');
                    $product->description=$request->post('description');
                    $product->save();
    
                    if((int) $request->post('id')>0){
    
                        return response(array('message'=>'Category update succesfully','reset'=>false),200);
                    }else{
                        return response(array('message'=>'Category add succesfully.','reset'=>true,'script'=>true),200);
                    }
                }catch( \Exception $e){
                    return response(array('message'=> $e->getmessage()),403);
                }
            }
        }
        $category=\App\Models\Category::where('status','1')->get();
        $result=[];
        return view('admin.product.add',compact('result','category'));
    }   
    
    public function list(){

        $result=Product::orderBy('id','desc')->get();

        return view('admin.product.list',compact('result'));
    }


    public function update(Request $request, $id){

        $result = Product::find($id);

        if($result){
            $category=\App\Models\Category::where('status','1')->get();

            return view('admin.product.add',compact('result','category'));
        }else{

            return redirect()->back()->with('5fernsadminerror','somthing wron please try again');
        }
    }

    public function delete(Request $request, $id){

        $checkResult= Product::find($id);
        if($checkResult){

            Product::where('id',$id)->delete();

            $request->session()->flash('5fernsadminsuccess','Product deleted successfully');
        }else{
            $request->session()->flash('5fernsadminerror','something went wrong please try again');
        }

        return redirect()->route('admin.product.list');

    }

    public function changeStatus(Request $request){

        // print_r($request->post('status'));die;
        Product::where('id',$request->post('id'))->update(['status'=>$request->post('status')]);

        return response(array('message'=>'Product status change successfuly'),200);
    }


}
