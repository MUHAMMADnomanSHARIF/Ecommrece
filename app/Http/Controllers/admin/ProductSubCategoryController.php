<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductSubCategoryController extends Controller
{
    public function index(Request $request){

        $subcategory = SubCategory::where('category_id',$request->id)->orderBy('name','ASC')->get();

                if (!empty($request->category_id)) {

                    return response()->json([
                        'status' => true,
                        'subCategories' => $subcategory
                    ]);

                }
                else{
                    return response()->json([
                        'status' => true,
                        'subCategories' => $subcategory

                    ]);


                }


    }


}
