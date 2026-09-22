<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q') ?? $request->input('search');

        $cacheKey = 'products_search_' . md5((string) $query);

        $products = Cache::remember($cacheKey, 300, function () use ($query) {
            return Product::query()
                ->with(['unit'])
                ->where('quantity', '>', 0)
                ->when($query, function ($q) use ($query) {
                    $q->where(function ($inner) use ($query) {
                        $inner->where('name', 'like', "%{$query}%")
                            ->orWhere('sku', 'like', "%{$query}%")
                            ->orWhere('barcode', 'like', "%{$query}%");
                    });
                })
                ->limit(50)
                ->get()
                ->map(fn (Product $product) => $this->mapProduct($product));
        });

        return response()->json($products);
    }

    /**
     * Exact match by barcode or SKU (for barcode scanners).
     */
    public function lookup(Request $request)
    {
        $code = trim((string) ($request->input('code') ?? $request->input('q') ?? ''));

        if ($code === '') {
            return response()->json(['message' => 'Code is required.'], 422);
        }

        $product = Product::query()
            ->with(['unit'])
            ->where(function ($q) use ($code) {
                $q->where('barcode', $code)
                    ->orWhere('sku', $code);
            })
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        return response()->json($this->mapProduct($product));
    }

    private function mapProduct(Product $product): array
    {
        return [
            'value' => $product->id,
            'id' => $product->id,
            'text' => $product->name,
            'name' => $product->name,
            'price' => $product->purchase_price,
            'selling_price' => $product->selling_price,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'quantity' => $product->quantity,
            'unit' => $product->unit ? [
                'symbol' => $product->unit->symbol,
                'name' => $product->unit->name,
            ] : null,
        ];
    }
}
