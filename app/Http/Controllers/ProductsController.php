<?php

namespace App\Http\Controllers;

use App\Repositories\BrandsRepository;
use App\Repositories\ProductsRepository;
use App\Http\Requests\ProductsRequest;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductsController extends Controller
{

    public function __construct(
        private readonly ProductsRepository $productsRepository,
        private readonly BrandsRepository $brandsRepository,
    ) {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        $user = Auth::user();
        $products = DB::table('products')->paginate(env('PAGINATION', 8));
        if (!$user || $user->role !== User::ADMIN_ROLE) {
            return redirect()->route('login');
        }
        return View('admin.products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $brands = $this->brandsRepository->getAllFromCache();

        return view('admin.products.create', [
            'brands' => $brands,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductsRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Products::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'more_infos' => $request->input('more_infos'),
            'price' => $request->input('price'),
            'brand' => $request->input('brand'),
        ]);

        return redirect()->route('products.index')->with('success', "Le produit a bien été enregistré");
    }

    /**
     * Display the specified resource.
     *
     * @param Products $products
     * @return void
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Products $product
     * @return View
     */
    public function edit(Products $product): View
    {
        $brands = $this->brandsRepository->getAllFromCache();
        return view('admin.products.edit', [
            'product' => $product,
            'brands' => $brands,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductsRequest $request
     * @param Products $product
     * @return RedirectResponse
     */
    public function update(Request $request, Products $product): RedirectResponse
    {
        $product->name = $request->input("name");
        $product->description = $request->input("description");
        $product->more_infos = $request->input("more_infos");
        $product->price = $request->input("price");
        $product->brand = $request->input("brand");
        $product->save();

        // Delete product properties from the cache
        // since we just updated them
        $this->productsRepository->deletePropertiesFromCacheById($product->id);

        return redirect()->route('products.index')->with('success', "Le produit a bien été mis à jour");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Products $product
     * @return RedirectResponse
     */
    public function destroy(Products $product): RedirectResponse
    {
        // Delete product properties from the cache
        $this->productsRepository->deletePropertiesFromCacheById($product->id);
        // before actually deleting it from the database
        $product->delete();

        return redirect()->route('products.index')->with('success', "Le produit a bien été supprimé");
    }
}
