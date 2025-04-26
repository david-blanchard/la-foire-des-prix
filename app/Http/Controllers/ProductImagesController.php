<?php

namespace App\Http\Controllers;

use App\Repositories\BrandsRepository;
use App\Repositories\ImagesRepository;
use App\Repositories\ProductsRepository;
use App\Models\Images;
use App\Models\ProductImages;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductImagesController extends Controller
{
    public function __construct(
        private readonly ProductsRepository $productsRepository,
        private readonly BrandsRepository $brandsRepository,
        private readonly ImagesRepository $imagesRepository,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();
        $products = DB::table('products')->paginate(20);

        if (!$user || $user->role !== User::ADMIN_ROLE) {
            return redirect()->route('login');
        }
        return View('admin.product_images.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Products $product): View
    {
        $productId = $product['id'];
        $productName = $product['name'];
        $brand = $this->brandsRepository->getBrandNameById($product['brand']);
        $associatedImages = $this->imagesRepository->getImagesByProductId($productId);

        return View('admin.product_images.create', [
            'productId' => $productId,
            'productName' => $productName,
            'assocImages' => $associatedImages,
            'brand' => $brand,
            'images' => Images::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $productId = $request->input('product');
        ProductImages::create([
            'product' => $productId,
            'image' => $request->input('image'),
        ]);
        $this->productsRepository->deletePropertiesFromCacheById($productId);

        return redirect()->route('product_images.create', $productId);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductImages  $productImages
     * @return \Illuminate\Http\Response
     */
    public function show(ProductImages $productImages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductImages  $productImages
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductImages $productImages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductImages  $productImages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductImages $productImages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductImages  $productImages
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductImages $productImages)
    {
        //
    }
}
