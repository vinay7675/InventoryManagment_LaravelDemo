<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {   
    $query = Product::query();

      if ($request->status && $request->status !== 'all') {
        $query->where('status', $request->status);
       }

      if ($request->sort_by) {
        $query->orderBy(
            $request->sort_by,
            $request->sort_dir === 'desc' ? 'desc' : 'asc'
        );
        }

    return $query->get();
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            //'product_code' => 'required|string|unique:products',
            'hsn_code' => 'nullable|string',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        $data['product_code'] = $this->generateProductCode();

        return Product::create($data);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'hsn_code' => 'nullable|string',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        $product->update($data);
        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        
        return response()->noContent();
    }

    private function generateProductCode(): string
    {
    $last = Product::orderBy('id', 'desc')->first();
    $next = $last ? $last->id + 1 : 1;

    return 'PM-PCE-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}
