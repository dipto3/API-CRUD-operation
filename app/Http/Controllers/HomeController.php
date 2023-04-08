<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function store(Request $request){
        $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();


        $product= Product::create([
                'name' => $request->name,
                'image' => $imageName,
                'description' => $request->description,
            ]);
            // Save Image in Storage folder
            Storage::disk('public')->put($imageName, file_get_contents($request->image));
            return response()->json(['message'=>'Product Stored Successfully','data'=>$product]);
    }

    public function index(){
        $products = Product::all();
        return response()->json(['message'=>'All Products ','data'=>$products]);
    }

    public function show($id)
    {
       // Product Detail
       $product = Product::find($id);
       if(!$product){
         return response()->json([
            'message'=>'Product Not Found.'
         ],404);
       }

       // Return Json Response
       return response()->json([
          'product' => $product
       ],200);
    }


    // public function update(ProductStoreRequest $request, $id)
    // {

    //         // Find product
    //         $product = Product::find($id);
    //         if(!$product){
    //           return response()->json([
    //             'message'=>'Product Not Found.'],404);
    //         }

    //         $product->name = $request->name;
    //         $product->description = $request->description;

    //         if($request->image) {
    //             // Public storage
    //             $storage = Storage::disk('public');

    //             // Old iamge delete
    //             if($storage->exists($product->image))
    //                 $storage->delete($product->image);

    //             // Image name
    //             $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
    //             $product->image = $imageName;

    //             // Image save in public folder
    //             $storage->put($imageName, file_get_contents($request->image));
    //         }

    //         // Update Product
    //         $product->save();

    //         // Return Json Response
    //         return response()->json([
    //             'message' => "Product successfully updated."]);

    // }

    public function destroy($id)
    {

        $product = Product::find($id);
        if(!$product){
          return response()->json([
             'message'=>'Product Not Found.'],404);
        }

        $storage = Storage::disk('public');

        if($storage->exists($product->image))
            $storage->delete($product->image);

        $product->delete();
        return response()->json([
            'message' => "Product successfully deleted."],200);
    }

    public function update(ProductStoreRequest $request, $id){
        $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();


        $product= Product::where('id',$id)->update([
                'name' => $request->name,
                'image' => $imageName,
                'description' => $request->description,
            ]);
            // Save Image in Storage folder
            Storage::disk('public')->put($imageName, file_get_contents($request->image));
            return response()->json(['message'=>'Product updated Successfully']);
    }







}
