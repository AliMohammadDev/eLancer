<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\Tag;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProjectsController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $user = Auth::user();
    $projects = $user
      ->projects()
      ->with(['category.parent', 'tags'])
      ->paginate();
    return view('client.projects.index', [
      'projects' => $projects
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {

    return view('client.projects.create', [
      'project' => new Project(),
      'types' => Project::types(),
      'categories' => $this->categories(),
      'tags' => [],
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ProjectRequest $request)
  {

    // $request->validate([
    //     'title'=>['required','string','max:255'],
    //     'description'=>['required','string'],
    //     'type'=>['required','in:hourly,fixed'],
    //     'budget'=>['nullable','numeric','min:0']
    // ]);
    $user = Auth::user();
    // $user = $request->user()->id;
    // $request->merge([
    //     'user_id'=>$user
    // ]);
    // $project = Project::create($request->all());

    $data = $request->except('attachments');
    $data['attachments'] = $this->uploadAttachments($request);

    $project = $user->projects()->create($data);
    $tags = explode(',', $request->input('tags'));
    $project->syncTags($tags);
    return redirect()->route('client.projects.index')
      ->with('Success', 'Project Created');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $user  = Auth::user();
    $project = $user->projects()->findOrFail($id);
    // $project = Project::where('user_id',$user)->findOrFail();
    return view('client.projects.show', compact('project'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $user = Auth::user();
    $project = $user->projects()->findOrFail($id);

    return view('client.projects.edit', [
      'project' => $project,
      'types' => Project::types(),
      'categories' => $this->categories(),
      'tags' => $project->tags()->pluck('name')->toArray(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ProjectRequest $request, string $id)
  {
    $user = Auth::user();
    $project = $user->projects()->findOrFail($id);

    $data = $request->except('attachments');
    $data['attachments'] = array_merge(($project->attachments ?? []), $this->uploadAttachments($request));



    $project->update($data);

    $tags = explode(',', $request->input('tags'));


    // $tags_id = [];
    // foreach ($tags as $tag_name) {
    //   $tag = Tag::firstOrCreate([
    //     'slug' => Str::slug($tag_name),
    //   ], [
    //     'name' => trim($tag_name)
    //   ]);
    //   $tags_id[] = $tag->id;
    // }
    // $project->tags()->sync($tags_id);

    $project->syncTags($tags);

    return redirect()->route('client.projects.index')
      ->with('Warning', 'Project Updated');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    // $user = Auth::user();
    // $user->projects()->where('id',$id)->delete();

    $project = Project::where('user_id', Auth::id())
      ->where('id', $id)
      ->delete();

    foreach ($project->attachments as $file) {
      // unlink(storage_path('app/public/' . $file));
      Storage::disk('public')->delete($file);
    }




    return redirect()->route('client.projects.index')
      ->with('Success', 'Project deleted');
  }

  protected function categories()
  {
    return Category::pluck('name', 'id')->toArray();
  }

  protected function uploadAttachments(Request $request)
  {
    if (!$request->hasFile('attachments')) {
      return;
    }
    $files = $request->file('attachments');
    $attachemnts = [];
    foreach ($files as $file) {
      if ($file->isValid()) {
        $path = $file->store('/attachments', [
          'disk' => 'uploads',
        ]);
        $attachemnts[] = $path;
      }
    }

    return $attachemnts;
  }
}
