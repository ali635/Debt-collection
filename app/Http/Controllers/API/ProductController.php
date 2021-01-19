<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use App\Http\Resources\Product as ProductResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\products;

class ProductController extends BaseController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = products::all();
        return $this->sendResponse(ProductResource::collection($products),
          'تم ارسال جميع المنتجات');
    }

    public function store(Request $request)
    {
       $input = $request->all();
       $validator = Validator::make($input , [
        'Product_name'  => 'required|max:255',
        'section_id'    => 'nullable|exists:sections,id',
        'description'   => 'required',
       ] );

       if ($validator->fails()) {
        return $this->sendError('Please validate error' ,$validator->errors() );
          }
    $product = products::create($input);
    return $this->sendResponse(new ProductResource($product) ,'تم اضافة المنتج بنجاح ' );

    }


    public function show($id)
    {
        $product = products::find($id);
        if ( is_null($product) ) {
            return $this->sendError('Product not found'  );
              }
              return $this->sendResponse(new ProductResource($product) ,'Product found successfully' );

    }

    public function update(Request $request, products $product)
    {
        $input = $request->all();
        $validator = Validator::make($input , [
          'Product_name'  => 'required|max:255',
          'section_id'    => 'nullable|exists:sections,id',
          'description'   => 'required',
        ]  );

        if ($validator->fails()) {
         return $this->sendError('Please validate error' ,$validator->errors() );
           }
     $product->Product_name = $input['Product_name'];
     $product->section_id = $input['section_id'];
     $product->description = $input['description'];
     $product->save();
     return $this->sendResponse(new ProductResource($product) ,'تم تعديل المنتج بنجاح' );

    }


    public function destroy(products $product)
    {
        $product->delete();
        return $this->sendResponse(new ProductResource($product) ,'تم حذف المنتج بنجاح' );

    }
}
