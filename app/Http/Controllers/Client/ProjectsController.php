<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Models\Category;
use App\Models\Project;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $projects = $user->projects()->paginate();
        return view('client.projects.index', [
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.projects.create',[
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
        $project = $user->projects()->create($request->all());
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
        return view('client.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, string $id)
    {
        $user = Auth::user();
        $project = $user->projects()->findOrFail($id);

        $project->update($request->all());
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

        Project::where('user_id',Auth::id())
        ->where('id',$id)
        ->delete();


        return redirect()->route('client.projects.index')
            ->with('Success', 'Project deleted');
    }

    protected function categories()
    {
        return Category::pluck('name', 'id')->toArray();
    }
}
