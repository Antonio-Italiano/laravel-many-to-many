@extends('layouts.app')

@section('title', 'Projects')
    
@section('content')
    <header class="d-flex align-items-center justify-content-between my-5">
        <h1>Projects</h1>
        <a href="{{ route('admin.projects.create')}}" class="btn btn-success">Added Project</a>
    </header>

    <table class="table table-dark table-striped">
        <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Type</th>
              <th scope="col">Published</th>
              <th scope="col">Technologies</th>              
              <th scope="col">Description</th>
              {{-- <th scope="col">Image</th> --}}
              {{-- <th scope="col">Slug</th> --}}
              <th scope="col">Url</th>
              <th scope="col">Updated at</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($projects as $project)                
            <tr>
                <th scope="row">{{$project->id}}</th>
                <td>{{$project->title}}</td>
                <td>{{$project->type?->label}}</td>
                <td>
                    <form action="{{route('admin.projects.toggle', $project->id) }}" method="POST">
                        @method('PATCH')
                        @csrf
                        {{-- toggle  --}}
                        <button type=submit class="btn btn-outline">
                            <i class="fas fa-toggle-{{$project->is_published ? 'on' : 'off' }} {{ $project->is_published ? 'text-success' : 'text-danger' }}"></i>
                        </button>
                    </form>
                </td>
                <td>
                    @forelse ($project->technologies as $technology)
                        <span class="badge rounded-pill me-2 text-bg-{{ $technology->color }}">{{ $technology->label }}</span>
                    @empty
                        -
                    @endforelse
                </td>                
                <td>{{$project->description}}</td>
                {{-- <td>{{$project->image}}</td> --}}
                {{-- <td>{{$project->slug}}</td> --}}
                <td>{{$project->url}}</td>
                <td>{{$project->updated_at}}</td>
                <td>

                    {{-- BUTTON  --}}
                    <div class="d-flex">
                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="delete-form"
                            data-name="{{ $project->title }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminate</button>
                        </form>
                        <a href="{{ route('admin.projects.show', $project->id)}}" class="btn btn-primary mx-2">View</a>
                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-success">Edit</a>
                    </div>

                </td>
            </tr>
            @empty
            <tr>
                <th scope="row" colspan="7" class="text-center">There are no Projects</th>
            </tr>
                
            @endforelse
          </tbody>
    </table>    
@endsection