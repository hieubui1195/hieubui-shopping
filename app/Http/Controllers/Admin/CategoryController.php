<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Lang;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::allCategories();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = Input::get('type');

        if ($type == config('custom.form_type.create_main')) {
            return view('admin.categories.main');
        } elseif ($type == config('custom.form_type.create_sub')) {
            $mainCategories  = Category::mainCategories();

            return view('admin.categories.sub', compact('mainCategories'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parentId,
        ]);

        return redirect()->route('admin.category.index')
                        ->with('msg', Lang::get('custom.msg.category_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            
            if ($category->parent_id == config('custom.default_parent')) {
                return view('admin.categories.editMain', compact('category'));
            } else {
                $mainCategories  = Category::mainCategories();

                return view('admin.categories.editSub', compact('category', 'mainCategories'));
            }
        } catch (ModelNotFoundException $e) {
            return view('admin.partials.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        Category::find($id)->update([
            'name' => $request->name,
            'parent_id' => $request->parentId,
        ]);

        return redirect()->route('admin.category.index')
                        ->with('msg', Lang::get('custom.msg.category_edited'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subIds = Category::subIds($id);
        if(count($subIds) > 0) {
            Category::destroy($subIds);
        }
        Category::destroy($id);

        return redirect()->back()->with('msg', Lang::get('custom.msg.category_deleted'));
    }

}
