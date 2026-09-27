<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = $request->user()->products()->latest()->paginate(10);
        $totalProducts = $request->user()->products()->count();
        $inventoryValue = $request->user()->products()->selectRaw('COALESCE(SUM(stock * price), 0) as total')->value('total');
        $attentionCount = $request->user()->products()->where('stock', '<=', 5)->count();

        return view('welcome', compact('products', 'totalProducts', 'inventoryValue', 'attentionCount'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules($request));
        $request->user()->products()->create($validated);

        return to_route('dashboard')->with('success', 'Product added to your inventory.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->ensureOwner($request, $product);
        $product->update($request->validate($this->rules($request, $product)));

        return to_route('dashboard')->with('success', 'Product updated.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $this->ensureOwner($request, $product);
        $product->delete();

        return to_route('dashboard')->with('success', 'Product deleted.');
    }

    /** @return array<string, array<int, string>> */
    private function rules(Request $request, ?Product $product = null): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku'.($product ? ','.$product->id.',id,user_id,'.$request->user()->id : '')],
            'category' => ['required', 'string', 'max:80'],
            'stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'variant' => ['nullable', 'string', 'max:120'],
        ];
    }

    private function ensureOwner(Request $request, Product $product): void
    {
        abort_unless($product->user_id === $request->user()->id, 403);
    }
}
