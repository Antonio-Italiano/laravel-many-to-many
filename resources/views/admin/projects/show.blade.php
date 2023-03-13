@extends('layouts.app')

@section('title', $project->title)

@section('content')
    <header>
        <div class="d-flex justify-content-between">
            <h1 class="my-5">{{$project->title}}</h1>
            <div class="my-5">
                <a class="btn btn-secondary" href="{{route('admin.projects.index')}}">Indietro</a>
            </div>
        </div>
    </header>
    <div class="clearfix">
        @if ($project->image)
        <img class="me-4 mb-4 float-start w-50" src="{{ asset('storage/' . $project->image) }}" alt="{{$project->slug}}">            
        @endif
        <p>{{$project->description}}</p>
        <div><strong> state: </strong> {{$project->is_published ? 'Published' : 'Draft'}}</div>
        <div><strong> type: </strong> {{$project->type?->label}}</div>
        <div>
            <strong> technology: </strong> 
            @forelse ($project->technologies as $technology)
                {{$technology->label}} @if (!$loop->last)
                  , 
                @else 
                  .
                @endif @empty Nessuno            
            @endforelse
        </div>
    </div>
    <hr>
    <div class="d-flex justify-content-between pb-3">
        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="delete-form"
            data-name="{{ $project->title }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminate</button>
        </form>
        <form action="{{route('admin.projects.toggle', $project->id) }}" method="POST">
            @method('PATCH')
            @csrf  
            {{-- toggle  --}}
            <button type=submit class="btn btn-outline-{{ $project->is_published ? 'danger' : 'success' }}">
                {{$project->is_published ? 'Metti in bozza' : 'Pubblica' }}
            </button>
        </form>
        <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-success">Edit</a>
    </div>
    
@endsection