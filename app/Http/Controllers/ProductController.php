<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{

    public function index(){
        $products = Product::orderBy('id', 'desc')->paginate(5);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function create(Request $dados)
    public function create()
    {
        // echo"create";exit;
        $categories = Category::get();
        return view('products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //echo '<pre>';print_r(request()->get('quantidade'));exit;

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'amount' => 'required'
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->amount = $request->amount;
        $product->cost_price = $request->cost_price;
        $product->sale_price = $request->sale_price;


        if ($request->file('main_photo')) {
            $destinationPath = 'uploads/imagens';
            $extension = $request->file('main_photo')->getClientOriginalExtension();
            $originalname = $request->file('main_photo')->getClientOriginalName();
            $fileName = md5($originalname . date('Y-m-d H:i:s')) . '.' . $extension;
            $request->file('main_photo')->move($destinationPath, $fileName);
            $product->main_photo = $destinationPath . '/' . $fileName;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::get();
        return view('products.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        $product->cost_price = $request->cost_price;
        $product->sale_price = $request->sale_price;
        $product->save();
        return redirect()->route('products.index')
            ->with('success', 'Produto atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Produto deletado com sucesso');
    }
}
