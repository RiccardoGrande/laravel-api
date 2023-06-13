@extends('layouts.admin')


@section('content')

<div class="py-5">

    <div class="row row-cols-1 row-cols-md-2">
        <div class="col">
            <img class="img-fluid" src="{{$project->url_project}}" alt="{{$project->title}}">
        </div>
        <div class="col">
            <div class="content">
                <h1>{{$project->title}}</h1>
                <div class="meta">
                    <span class="badge bg-primary">{{$project->category?->name}}</span>
                </div>
                <p>{{$project->content}}</p>
            </div>

        </div>
    </div>



</div>









@endsection
