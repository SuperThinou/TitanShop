<?php

namespace App\Http\Controllers\Products;

use App\ProductBase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductI18n;

class ProductBaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = ProductBase::where('isDeleted', 0)->get();

        return view('themes.default.pages.admin.products')->with(['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\CategoryBase::where('isDeleted', 0)->get();

        return view('themes.default.pages.admin.product', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'promoPrice' => 'nullable|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'title' => 'required|min:3',
            'description' => 'required|min:10',
        ]);

        $product = new ProductBase();
        $product->price = $request['price'];
        $product->promoPrice = $request['promoPrice'];
        $product->stock = $request['stock'];
        $product->isVisible = $request['isVisible'] ? 1 : 0;
        $product->save();

        $product->categories()->attach($request['category']);

        $productI18n = new ProductI18n();
        $productI18n->product_base_id = $product->id;
        $productI18n->lang = $request['lang'] ?? 'FR';
        $productI18n->title = trim($request['title']);
        $productI18n->description = trim($request['description']);
        $productI18n->save();

        $categories = \App\CategoryBase::where('isDeleted', 0)->get();

        return redirect(route('admin.product.edit', ['product' => $product]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductBase  $product
     * @return \Illuminate\Http\Response
     */
    public function show(ProductBase $product)
    {
        return view('themes.default.pages.public.product')->with(['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductBase  $productBase
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductBase $product)
    {
        $categories = \App\CategoryBase::where('isDeleted', 0)->get();

        return view('themes.default.pages.admin.product', [
            'categories' => $categories,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductBase  $productBase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductBase $product)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'promoPrice' => 'nullable|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'title' => 'required|min:3',
            'description' => 'required|min:10',
        ]);

        $product->price = $request['price'];
        $product->promoPrice = $request['promoPrice'];
        $product->stock = $request['stock'] ?? 0;
        $product->isVisible = $request['isVisible'] ? 1 : 0;
        $product->save();

        $product->categories()->detach();
        $product->categories()->attach($request['category']);

        $productI18n = $product->i18ns()->where('lang', $request['lang'])->first();
        $productI18n->product_base_id = $product->id;
        $productI18n->lang = $request['lang'] ?? 'FR';
        $productI18n->title = trim($request['title']);
        $productI18n->description = trim($request['description']);
        $productI18n->save();

        return redirect()->back()->with(['success' => ['Le produit a été modifié avec succés.']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductBase  $productBase
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductBase $product)
    {
        $product->isDeleted = true;
        $product->save();
    }
}
