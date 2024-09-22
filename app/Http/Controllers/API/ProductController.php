<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = Product::get();
        
        return response()->json([
            'code' => 200,
            'success' => True,
            'message' => 'Product List.',
            'data' => $details
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 401,
                'success' => false,
                'message' => 'Validation Request Error.',
                'errors' => $validator->errors()
            ], 401);
        }

         // Retrieve the validated input...
         $validated = $validator->validated();

          // data Product
        $dataProduct = [
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'sold' => 0
        ];

         // create product
         $storeProudct = Product::create($dataProduct);

         if (!$storeProudct) {
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'Product Gagal disimpan di database',
            ], 500);
         }


        return response()->json([
            'code' => 200,
            'message' => 'Product created successfully.',
            
            'data' => [
                'id' => $storeProudct->id,
                'name' => $storeProudct->name,
                'price' => $storeProudct->price,
                'stock' => $storeProudct->stock,
                'sold' => $storeProudct->sold,
                'create_at' => $storeProudct->create_at,
                'update_at' => $storeProudct->update_at
            ]
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 401,
                'success' => false,
                'message' => 'Validation ID Error.',
                'errors' => $validator->errors()
            ], 401);
        }

        $details = Product::find($id);

        if (!$details) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'code' => 200,
            'success' => True,
            'message' => 'Product List.',
            'data' => $details
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatorId = Validator::make(['id' => $id], [
            'id' => 'required|numeric|min:1',
        ]);

        if ($validatorId->fails()) {
            return response()->json([
                'code' => 401,
                'success' => false,
                'message' => 'Validation ID Error.',
                'errors' => $validatorId->errors()
            ], 401);
        }

        $validatorRequest = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                Rule::unique('products')->ignore($id),
            ],
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:0',
        ]);

        if ($validatorRequest->fails()) {
            return response()->json([
                'code' => 401,
                'success' => false,
                'message' => 'Validation Request Error.',
                'errors' => $validatorRequest->errors()
            ], 401);
        }

        $dataUpdateProduct = [
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        $updateProduct = Product::find($id);

        if (!$updateProduct) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $updateProduct->update($dataUpdateProduct);

        return response()->json([
            'code' => 200,
            'success' => True,
            'message' => 'Product Berhasil di Update',
            'data' => $updateProduct
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validatorId = Validator::make(['id' => $id], [
            'id' => 'required|numeric|min:1',
        ]);

        if ($validatorId->fails()) {
            return response()->json([
                'code' => 401,
                'success' => false,
                'message' => 'Validation ID Error.',
                'errors' => $validatorId->errors()
            ], 401);
        }

        $deleteProduct = Product::find($id);

        if (!$deleteProduct) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $deleteProduct->delete();

        return response()->json([
            'code' => 200,
            'success' => True,
            'message' => 'Product Berhasil di hapus',
            'data' => $deleteProduct
        ], 200);
    }
}
