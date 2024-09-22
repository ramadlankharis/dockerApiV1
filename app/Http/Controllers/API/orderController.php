<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class orderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataQuery = Order::with('dataJual')->get();

        return response()->json([
            'code' => 200,
            'message' => 'Order List.',
            
            'data' => $dataQuery
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
            'products' => 'required|array', // Pastikan 'items' adalah array
            'products.*.id' => 'required|numeric', // Validasi bahwa setiap item memiliki field 'name' bertipe string
            'products.*.quantity' => 'required|numeric|min:1' // Validasi bahwa setiap item memiliki field 'price' bertipe angka dan minimal 0
        ]);
    
        // Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'code' => 400,
                'success' => false,
                'errors' => $validator->errors()
            ], 400); // 400 Bad Request jika validasi gagal
        }

        $products = $request->input('products');

        $lastRow = Order::latest()->first();

        $count = !$lastRow ? 1 : $lastRow->order_number + 1;

        foreach ($products as $product) {
            // Cari produk berdasarkan id_product
            $productRecord = Product::find($product['id']);

            // Jika produk ditemukan, kurangi stoknya
            if ($productRecord) {
                $newStock = $productRecord->stock - $product['quantity'];

                // Cek apakah stok cukup
                if ($newStock >= 0) {
                    $productRecord->stock = $newStock;
                    
                    $productRecord->save();

                    // Increment nilai sold berdasarkan quantity
                    $productRecord->increment('sold', $product['quantity']);

                     // Simpan ke tabel orders
                     Order::create([
                        'order_number' => $count,
                        'product_id' => $product['id'],
                    ]);

                } else {
                    return response()->json([
                        'code' => 400,
                        'success' => false,
                        'message' => 'Stock Tidak Ada Stock product ID ' . $product['id'],
                    ], 400); // 400 Bad Request jika validasi gagal
                }
            } else {
                return response()->json([
                    'code' => 404,
                    'success' => false,
                    'message' => 'Stock Tidak Ditemukan product ID ' . $product['id'],
                ], 404); // 400 Bad Request jika validasi gagal
            }
        }

        // query return data
        $dataQuery = Order::with('dataJual')
        ->where('order_number', $count)
        ->get();

        return response()->json([
            'code' => 200,
            'message' => 'Product created successfully.',
            
            'data' => $dataQuery
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $dataQuery = Order::with('dataJual')->find($id);
        $dataQuery = Order::with('dataJual')
        ->where('order_number', $id)
        ->get();

        if ($dataQuery->isEmpty()) {
            // Jika data tidak ditemukan
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        } 

        return response()->json([
            'code' => 200,
            'message' => 'Order List.',
            
            'data' => $dataQuery
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $flagData = Order::with('dataJual')->find($id);

        $dataQuery = Order::with('dataJual')
        ->where('order_number', $id)
        ->get();

       
        if ($dataQuery->isEmpty()) {
            // Jika data tidak ditemukan
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        } 

        $deleted = Order::where('order_number', $id)->delete();

        if (!$deleted) {
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'Server error!',
            ], 500);
        }
        return response()->json([
            'code' => 200,
            'message' => 'Order deleted successfully.',
            
            'data' => $dataQuery
        ], 200);
    }
}
