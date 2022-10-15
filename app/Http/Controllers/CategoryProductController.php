<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\CategoryProduct;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCategoryProductRequest;
use App\Http\Requests\UpdateCategoryProductRequest;
use GuzzleHttp\Psr7\Request;

class CategoryProductController extends Controller
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
            if (!CategoryProduct::exists()) {
                throw new Exception('Category Product not found');
            }
            return ResponseFormatter::success(
                CategoryProduct::paginate(5),
                'Category Product Found'
            );
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
     * @param  \App\Http\Requests\StoreCategoryProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryProductRequest $request)
    {
        //
        $validator = Validator::make($request->all(), ['name' => 'required|unique:category_products|string|max:255']);
        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Validation Error');
        }
        $categoryProduct = CategoryProduct::create($request->all());
        return ResponseFormatter::success(
            ['data' => $categoryProduct],
            'Category Product Created'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryProduct $categoryProduct)
    {
        //
        try {
            //code...
            if ($categoryProduct->findorFail($categoryProduct->id)) {
                throw new Exception('Category Product not found');
            }
            return ResponseFormatter::success(
                $categoryProduct,
                'Category Product Found'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(null, $error->getMessage(), 500);
        }
    }
    // {
    //     //
    //     // if (sizeof($categoryProduct) == 0) {
    //     //     # code...
    //     //     return 'Category Product not found';
    //     // }
    //     if(CategoryProduct::find($categoryProduct->id)){
    //         return ResponseFormatter::success(
    //             ['data' => $categoryProduct],
    //             'Category Product Found'
    //         );
    //     }else{
    //         return ResponseFormatter::error(null, 'Category Product not found', 404);
    //     }
    //     // try {
    //     //     //code...
    //     //     if ($categoryProduct->exists()) {
    //     //         return ResponseFormatter::success(
    //     //             ['data' => $categoryProduct],
    //     //             'Category Product Found'
    //     //         );
    //     //     } else {
    //     //         throw new Exception('Category Product not found');
    //     //     }
    //     // } catch (Exception $error) {
    //     //     return ResponseFormatter::error(null, $error->getMessage(), 500);
    //     // }
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryProductRequest  $request
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryProductRequest $request, CategoryProduct $categoryProduct)
    {
        //
        $categoryProduct->update([
            'name' => $request->name,
        ]);
        return ResponseFormatter::success(
            ['data' => $categoryProduct],
            'Category Product Updated'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryProduct $categoryProduct)
    {
        //
        $categoryProduct->delete();
        return ResponseFormatter::success(
            null,
            'Category Product Deleted'
        );
    }
}
