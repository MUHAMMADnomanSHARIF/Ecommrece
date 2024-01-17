<?php


use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\TempImagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use Illuminate\Http\Request;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/login',[AdminLoginController::class,'index'])->name('admin.login');

Route::group(['prefix' => 'admin'],function(){

    Route::group(['middleware' => 'admin.guest'],function(){
        Route::get('/login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('/authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');


    });

    Route::group(['middleware' => 'admin.auth'],function(){

        Route::get('/dashboard',[HomeController::class,'index'])->name('admin.dashbord');
        Route::get('/logout',[HomeController::class,'logout'])->name('admin.logout');
        // categories Route
        Route::get('/categories/create',[CategoryController::class,'create'])->name('categories.create');
        Route::post('/categories/store',[CategoryController::class,'store'])->name('categories.store');
        Route::get('/categories',[CategoryController::class,'index'])->name('categories.index');
        Route::get('/categories/{category}/edit',[CategoryController::class,'edit'])->name('categories.edit');

        Route::put('/categories/{category}',[CategoryController::class,'update'])->name('categories.update');
        Route::delete('/categories/{category}',[CategoryController::class,'destroy'])->name('categories.delete');


        // sub Category Routse
        Route::get('/sub-categories/create',[SubCategoryController::class,'create'])->name('sub-categories.create');
        Route::post('/sub-categories',[SubCategoryController::class,'store'])->name('sub-categories.store');
        Route::get('/sub-categories/index',[SubCategoryController::class,'index'])->name('sub-categories.index');
        Route::get('/sub-categories/{category}/edit',[SubCategoryController::class,'edit'])->name('sub-categories.edit');
        Route::put('/sub-categories/{subcategory}',[SubCategoryController::class,'update'])->name('sub-categories.update');
        Route::delete('/sub-categories/{subCategory}',[SubCategoryController::class,'destroy'])->name('sub-categories.delete');


         // Brands Routes

         Route::post('/brands',[BrandController::class,'store'])->name('brands.store');
         Route::get('/brands/create',[BrandController::class,'create'])->name('brands.create');
         Route::get('/brands/index',[BrandController::class,'index'])->name('brands.index');
         Route::get('/brands/{brand}/edit',[BrandController::class,'edit'])->name('brands.edit');

    Route::put('/brands/{brand}',[BrandController::class,'update'])->name('brands.update');
    Route::delete('/brands/{brand}',[BrandController::class,'destroy'])->name('brands.delete');





    // product Routs
    Route::get('/product/create',[ProductController::class,'create'])->name('products.create');
    Route::post('/products',[ProductController::class,'store'])->name('products.store');

    Route::get('/product-subcategories',[ProductSubCategoryController::class,'index'])->name('product-subcategories.index');


        // Image route
        Route::post('/upload-temp-image',[TempImagesController::class,'create'])->name('temp-images.create');




        Route::get('/getSlug',function(Request $request){
            $slug = '';
            if(!empty($request->title)){
                $slug = Str::slug($request->title);
            }

            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);})->name('getSlug');

    });


    // subcategory

    Route::post('/upload-temp-image',[TempImagesController::class,'create'])->name('temp-images.create');







    });



