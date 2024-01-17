<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class BrandController extends Controller
{

    public function index(Request $request){
        $brands =  Brand::latest('id');

        if($request->get('keyword')) {
          $brands = $brands->where('name', 'like', '%'.$request->keyword.'%');
        }


        $brands = $brands->paginate(10);

        return view('admin.brands.list', compact('brands'));


    }
    public function create(){
        return view('admin.brands.create');
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:brands',

        ]);
        if($validator->passes()){
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            $request->session()->flash('success','Brand added successfully');


            return response()->json([
                'status' => true,
                'message' => 'Brand added successfully'
            ]);

       }else{
            return response()->json([
                'status' => false,
                'errors'=> $validator->errors()
        ]);
       }

    }

    public function edit($id, Request $request){

    $brand = Brand::find($id);


            if(empty($brand)){
                $request->session()->flash('error', 'Record Not Found.');
                return redirect()->route('brands.index');
                }


                return view('admin.brands.edit', compact('brand'));



    }

    public function update($id, Request $request){


        $Brands = Brand::find($id);

        if(empty($Brands)){
         $request->session()->flash('error', 'SubCategory Not found');
         return response([
             'status' =>false,
             'notFound' => true
         ]);

          }

         $validator = Validator::make($request->all(),[
             'name' => 'required',

             'slug' => 'required|unique:sub_categories,slug,'.$Brands->id.',id',
             'status' => 'required'
         ]);
         if($validator->passes()){



         $Brands->name = $request->name;
         $Brands->slug = $request->slug;
         $Brands->status = $request->status;
         $Brands->save();
         $request->session()->flash('success', 'Brand Updated Successfully');

         return response([
             'status' => true,
             'message' => 'Brand Updated successfully'

         ]);


         }else{
             return response([
                 'status' => false,
                 'errors' => $validator->errors()
             ]);
         }

       }

       public function destroy($id, Request $request){
        $brand = Brand::find($id);

        if(empty($brand)){
         // return redirect()->route('categories.index');
         $request->session()->flash('error','Category DoseNot Found');


         return response()->json([
          'status' => true,
          'message' => 'Category dose not found'
         ]);



        }



        $brand->delete();

        $request->session()->flash('success','Brands Deleted Successfully');

        return response()->json([
         'status' => true,
         'message' => 'Brands deleted successfully'
        ]);




     }
}
