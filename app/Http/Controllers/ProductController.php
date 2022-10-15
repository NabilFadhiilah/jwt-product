<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use GuzzleHttp\Psr7\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            //code...
            if (!Product::exists()) {
                throw new Exception('Product not found');
            }
            return ResponseFormatter::success(Product::paginate(15), 'Product Found');
        } catch (Exception $error) {
            return ResponseFormatter::error(null, $error->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        //
        try {
            $niceNames=[
                'name' => 'Name',
                'image' => 'Image',
                'price' => 'Price',
                'product_category_id' => 'Product Category Id',
            ];

            $messages = [
                'required' => ':attribute is required',
                'string' => ':attribute must be a string',
                'max' => ':attribute must be less than :max',
                'unique' => ':attribute already exists',
            ];

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:products|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'product_category_id' => 'required|numeric',
            ], $messages, $niceNames);

            if($validator->fails()){
                return ResponseFormatter::error($validator->errors(), 'Validation Error');
            }

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('public/product/images');
            }

            $product = Product::create([
                'name' => $request->name,
                'image' => isset($path) ? $path : '',
                'price' => $request->price,
                'product_category_id' => $request->product_category_id,
            ]);
            if (!$product) {
                throw new Exception('Product not created');
            }
            return ResponseFormatter::success($product, 'Product Created');
        } catch (Exception $error) {
            return ResponseFormatter::error(null, $error->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try {
            //code...
            $product=Product::find($id);
            if (!$product) {
                throw new Exception('Product not found');
            }
            return ResponseFormatter::success($product, 'Product Found');
        } catch (Exception $error) {
            return ResponseFormatter::error(null, $error->getMessage(), 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        return ResponseFormatter::success(null, 'Product Deleted');
    }
}
