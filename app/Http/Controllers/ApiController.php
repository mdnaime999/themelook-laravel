<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\ProductColor;
use App\Models\ProductSize;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Arr;

class ApiController extends Controller
{

    function products(Request $request)
    {
        $products = Product::where('status', 1)->get();
        foreach($products as $product){
            foreach($product->details as $detail){
                $detail->color_id = $detail->color;
                $detail->size_id = $detail->size;
            }
            $product->details = $product->details;

            $product->images = ProductImage::where('product_id', $product->id)->where('status', 1)->get();
        }
        return $products;
    }

    // function colors(Request $request)
    // {
    //     $colors = ProductColor::where('status', 1)->get();
    //     return $colors;
    // }

    // function sizes(Request $request)
    // {
    //     $sizes = ProductSize::where('status', 1)->get();
    //     return $sizes;
    // }

    function product_insert(Request $request)
    {
        $product = new Product();

        $product->name = $request->name;
        $product->description = $request->description;

        if($product->save()){
            $pro_details = json_decode($request->product_details);
            if(count($pro_details) > 0 && $product->id){
                foreach($pro_details as $req_details){
                    $details = new ProductDetail();
                    $details->product_id = $product->id;
                    $details->color_id = $req_details->color_id;
                    $details->size_id = $req_details->size_id;
                    $details->price = $req_details->price;
                    $details->save();
                }
            }
            if($product->id){
                $pro_images = new ProductImage();
                $img = $request->file('images');
                $rename = time() . Arr::random([1, 2, 3, 4, 5, 6, 7, 8, 9]) .'.'. $img->getClientOriginalExtension();
                $location = public_path('images/' . $rename);
                Image::make($img)->save($location); // resize image add resize(1920, 960)

                $pro_images->product_id = $product->id;
                $pro_images->name = $rename;
                $pro_images->save();
            }
            return $product->id;
        }else{
            return response()->json(['data' => $product], 404);
        }



        // return $rename;
    }
    

    function colors(Request $request){
        return ProductColor::where('status', 1)->get();
    }

    function sizes(Request $request){
        return ProductSize::where('status', 1)->get();
    }

}
