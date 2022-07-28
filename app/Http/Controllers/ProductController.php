<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{

    /**
     * Show index products view
     *
     * @return View
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $categories = Category::get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->amount = $request->amount;
        $product->cost_price = str_replace(',', '.', str_replace('.', '', $request->cost_price));
        $product->sale_price = str_replace(',', '.', str_replace('.', '', $request->sale_price));
        $product->main_photo = $request->main_photo;

        if ($request->file('main_photo')) {
            $destinationPath = 'uploads/imagens';
            $extension = $request->file('main_photo')->getClientOriginalExtension();
            $originalname = $request->file('main_photo')->getClientOriginalName();
            $fileName = md5($originalname . date('Y-m-d H:i:s')) . '.' . $extension;
            $request->file('main_photo')->move($destinationPath, $fileName);
            $product->main_photo = $destinationPath . '/' . $fileName;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Produto criado com sucesso.');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show(int $id)
    {
        $product = Product::find($id);
        //   echo '<pre>';print_r($product);exit;

        if (is_null($product)) {
            return abort(404);
        }

        return view('products.show', [
            'product' => $product,
            'addresses' => $product->addresses,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product)
    {
        $categories = Category::get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'amount' => 'required',
        ]);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->amount = $request->amount;
        $product->cost_price = str_replace(',', '.', str_replace('.', '', $request->cost_price));
        $product->sale_price = str_replace(',', '.', str_replace('.', '', $request->sale_price));

        if ($request->file('main_photo')) {
            $destinationPath = 'uploads/imagens';
            $extension = $request->file('main_photo')->getClientOriginalExtension();
            $originalname = $request->file('main_photo')->getClientOriginalName();
            $fileName = md5($originalname . date('Y-m-d H:i:s')) . '.' . $extension;
            $request->file('main_photo')->move($destinationPath, $fileName);
            $product->main_photo = $destinationPath . '/' . $fileName;
        }

        $product->save();
        return redirect()->route('admin.products.index')
            ->with('success', 'Produto atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        $product = Product::find($id);

        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Produto deletado com sucesso');
    }
}
