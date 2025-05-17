<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\filterRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    protected $rules = [
        'name' => ['required', 'string', 'between:2,255'],
        'parent_id' => ['nullable', 'int', 'exists:categories,id'],
        'description' => ['nullable', 'string'],
        'art_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp']
    ];
    protected  $message = [
      'art_file.image' => 'The :attribute must be an image type.',
      'art_file.mimes' => 'The :attribute must be a file of type: jpeg, png, jpg, gif, svg, webp.',
      'name.required' => 'The :attribute is required.',
        // 'description.required'=>'the :attribute is required.'
    ];

    //Actions
    public function index()
    {
        // $categories = DB::table('categories')->get();
        // $categories = Category::get();
        $categories = Category::leftJoin(
            'categories as parents',
            'parents.id',
            '=',
            'categories.parent_id'
)->select('categories.*', 'parents.name as parent_name')
            // ->simplePaginate('3');
            ->paginate('5','*','page');
        return view('categories.index', [
            'categories' => $categories,
            'title' => 'categories',
            'flashMessage' =>   Session::get('Success')
        ]);
    }

    public function show(Category $category)
    {
        // $category = DB::table('categories')
        //     ->where('id', '=', $id)
        //     ->first();
        // $category = Category::findOrFail($id);
        return view('categories.show', [
            'category' => $category,
            'title' => 'categories'
        ]);
    }        

    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('categories.create', compact('parents', 'category'));
    }

    public function store(Request $request)
    {
        $clean = $request->validate($this->rules(), $this->message);
        // $clean = $this->validate($request, $rules);
        // $validator = Validator::make($request->all(),$rules);
        // $clean = $validator->validate();

        //   $category = DB::table('categories')->insert([]);

        // $category = new Category();
        // $category->name = $request->input('name');
        // $category->description = $request->input('description');
        // $category->parent_id = $request->input('parent_id');
        // $category->slug = Str::slug($category->name);
        // $category->save();

        $data = $request->except('art_file');
        $data['art_file'] = $this->uploadAttachments($request);

        if (!$data['slug']) {
            $data['slug'] = Str::slug($data['name']);
        }
        $category = Category::create(
            $data
        );


        //PRG Post Redirect Get
        return redirect('dashboard/categories')
            ->with('Success', 'Category Created');
    }
    public function edit(Category $category)
    {
        // $category = Category::find($id);
        $parents = Category::get();
        return view('categories.edit', [
            'category' => $category,
            'parents' => $parents
        ]);
    }
    public function update(Request $request, Category $category)
    {
        // $category = Category::findOrFail($id);

        $clean = $request->validate($this->rules(), $this->message);

        // $category->name = $request->input('name');
        // $category->description = $request->input('description');
        // $category->parent_id = $request->input('parent_id');
        // $category->slug = Str::slug($category->name);
        // $category->save();

        $category->update($request->all());

        return redirect('dashboard/categories')
        
            ->with('Warning', 'Category Updated');
    }

    public function destroy(Category $category)
    {
        // Category::destroy($id);
        $category->delete();
        // $category = Category::findOrFail($id);
        // $category->delete();
        // session()->flash('Success', 'Category Deleted');
        Session::flash('Success', 'Category Deleted');
        // Session::put('Success', 'Category Deleted');
        return redirect('dashboard/categories');
        // ->with('Success', 'Category Deleted');
    }

    public function rules()
    {
        $rules = $this->rules;
        // $rules['name'][] = function ($attribute, $value, $fail) {
        //     if ($value == 'god') {
        //         $fail('this word is not allowed');
        //     }
        // };
        $rules['name'][] = new filterRule;
        return $rules;
    }

    protected function uploadAttachments(Request $request)
    {
      if (!$request->hasFile('art_file')) {
        return;
      }
      $file = $request->file('art_file');
        if ($file->isValid()) {
          $path = $file->store('/art_file', [
            'disk' => 'uploads',
          ]);
          return $path;
        }
    }


}
