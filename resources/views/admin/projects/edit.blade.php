@extends('layouts.admin')


@section('content')

<h1 class="py-3">Edit {{$project->title}}</h1>


@include('partials.validation_errors')

<form action="{{route('admin.projects.update', $project)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" aria-describedby="titleHelper" placeholder="Learn php" value="{{ old('title', $url_project->title) }}">
        <small id="titleHelper" class="form-text text-muted">Type the project title max 150 characters - must be unique</small>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Categories</label>
        <select class="form-select @error('category_id') is-invalid @enderror" name=" category_id" id="category_id">
            <option value="">Select a category</option>
            @foreach ($categories as $category)
            <option value="{{$category->id}}" {{ $category->id  == old('category_id', $project->category->id) ? 'selected' : '' }}>{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="url_project" class="form-label">Image</label>
        <input type="text" class="form-control @error('url_project') is-invalid @enderror" name="url_project" id="url_project" aria-describedby="url_projectHelper" placeholder="Learn php" value="{{ old('url_project', $project->url_project) }}">
        <small id="url_projectHelper" class="form-text text-muted">Type the project url_project max 150 characters - must be unique</small>
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" rows="3">{{old('content', $project->content)}}</textarea>
    </div>


    <button type="submit" class="btn btn-dark">Update</button>

</form>


@endsection
