<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{
    //

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => ['required', 'integer'],
            'price' => ['required', 'integer'],
        ]);
       
        $filePath = storage_path('app/products.json');

        if (!File::exists($filePath)) {
            File::put($filePath, json_encode([]));
        }

        // Load existing products
        $products = json_decode(File::get($filePath), true);

        $new_product = [
            'id' => uniqid(), // Generate a unique ID
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
        ];

         // Add new product to the array
         $products[] = $new_product;

        // Save updated array back to the file
        File::put($filePath, json_encode($products));

        return response()->json(['success' => true, 'product' => $new_product]);


    }
}
