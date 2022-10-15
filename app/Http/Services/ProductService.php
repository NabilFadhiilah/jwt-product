<?php 
namespace App\Http\Services;

use App\Helpers\ResponseFormatter;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    public function fetch()
    {
        if (!Product::exists()) {
            return ResponseFormatter::error(null, 'Product Not Exist', 404);
        }
        return ResponseFormatter::success(Product::paginate(15), 'Product Found');
    }

    public function store($request, $path)
    {
        $product = Product::create([
            'name' => $request->name,
            'image' => isset($path) ? $path : '',
            'price' => $request->price,
            'product_category_id' => $request->product_category_id,
        ]);
        return $product;
    }

    public function update($request, $product)
    {
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete($product->image);
            }
            $path = $request->file('image')->store('public/product/images');
        }
        $product = Product::find($product->id);
        $product->update([
            'name' => $request->name,
            'image' => isset($path) ? $path : '',
            'price' => $request->price,
            'product_category_id' => $request->product_category_id,
        ]);
        if (!$product) {
            return ResponseFormatter::error(null, 'Product Not Found', 404);
        }
        return $product;
    }
}