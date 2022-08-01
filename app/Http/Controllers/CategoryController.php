<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Show categories index page.
     *
     * @return View
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(5);
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('categories.create');
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
            'name' => 'required'
        ]);

        $category = new Category;
        $category->name = $request->name;

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Categoria criada com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */

    public function show($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return abort(404);
        }
        return view('categories.show', compact('category'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return View
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
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
            'name' => 'required'
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();
        return redirect()->route('admin.categories.index')->with('success', 'category atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'categoria deletada com sucesso');
    }
}
