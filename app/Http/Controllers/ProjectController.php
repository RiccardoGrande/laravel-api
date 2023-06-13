<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderByDesc('id')->paginate(8);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderByDesc('id')->get();

        $technologies = Technology::orderByDesc('id')->get();

        return view('admin.projects.create', compact('categories', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        //dd($request->all());
        // validate the request
        $val_data = $request->validated();
        //dd($val_data);

        // generate the title slug
        $slug = Project::generateSlug($val_data['title']);
        //dd($slug);
        $val_data['slug'] = $slug;
        //dd($val_data);

        // Create the new Post
        $new_project = Post::create($val_data);

        // Attach the checked tags
        if ($request->has('technologies')) {
            $new_project->technologies()->attach($request->technologies);
        }

        // redirect back
        return to_route('admin.projects.index')->with('message', 'Project Created Successfully');

        if ($request->hasFile('cover_image')) {
            $image_path = Storage::put('uploads', $request->cover_image);
            //dd($image_path);
            $val_data['cover_image'] = $image_path;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $categories = Category::orderByDesc('id')->get();
        $technologies = Technology::orderByDesc('id')->get();

        return view('admin.projects.edit', compact('project', 'categories', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        $val_data = $request->validated();
        //dd($val_data);

        /* TODO:
        What happens if i update the post title ?
         */
        // Checks if the request has a key called title
        //dd($request->has('title'));

        // generate the title slug
        $slug = Project::generateSlug($val_data['title']);
        //dd($slug);
        $val_data['slug'] = $slug;
        //dd($val_data);

        $post->update($val_data);

        if ($request->has('technologies')) {
            $project->technologies()->sync($request->technologies);
        }

        if ($request->hasFile('cover_image')) {
            //dd('here');

            //if post->cover_image
            // delete the previous image

            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }

            // Save the file in the storage and get its path
            $image_path = Storage::put('uploads', $request->cover_image);
            //dd($image_path);
            $val_data['cover_image'] = $image_path;
        }

        return to_route('admin.projects.index')->with('message', 'Project: ' . $project->title . 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->cover_image) {
            Storage::delete($project->cover_image);
        }

        $project->delete();
        return to_route('admin.projects.index')->with('message', 'Project: ' . $project->title . 'Deleted');
    }
}
