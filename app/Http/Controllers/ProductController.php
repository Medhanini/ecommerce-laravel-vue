<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Product::all(),200);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'units' => $request->units,
            'price' => $request->price,
            'image' => $request->image
        ]);

        return response()->json([
            'status' => (bool) $product,
            'data'   => $product,
            'message' => $product ? 'Product Created!' : 'Error Creating Product'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json($product,200); 
    }
    public function uploadFile(Request $request)
    {
        if($request->hasFile('image')){
            $name = time()."_".$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $name);
        }
        return response()->json(asset("images/$name"),201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $status = $product->update(
            $request->only(['name', 'description', 'units', 'price', 'image'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Updated!' : 'Error Updating Product'
        ]);
    }
    public function updateUnits(Request $request, Product $product)
        {
            $product->units = $product->units + $request->get('units');
            $status = $product->save();

            return response()->json([
                'status' => $status,
                'message' => $status ? 'Units Added!' : 'Error Adding Product Units'
            ]);
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
        {
            $status = $product->delete();

            return response()->json([
                'status' => $status,
                'message' => $status ? 'Product Deleted!' : 'Error Deleting Product'
            ]);
        }
}
