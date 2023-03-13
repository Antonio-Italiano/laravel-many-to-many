@extends('layouts.app')

@section('title', 'Types')
    
@section('content')
    <header class="d-flex align-items-center justify-content-between my-5">
        <h1>Types</h1>
        <a href="{{ route('admin.types.create')}}" class="btn btn-success">Added Type</a>
    </header>

    <table class="table table-light table-striped">
        <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Label</th>
              <th scope="col">Updated at</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($types as $type)                
            <tr>
                <th scope="row">{{$type->id}}</th>
                <td>{{$type->label}}</td>
                <td>{{$type->updated_at}}</td>
                <td>
                    {{-- BUTTON  --}}
                    <div class="d-flex">
                        <form action="{{ route('admin.types.destroy', $type->id) }}" method="POST" class="delete-form"
                            data-name="{{ $type->title }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminate</button>
                        </form>
                        <a href="{{ route('admin.types.edit', $type->id) }}" class="btn btn-success mx-2">Edit</a>
                    </div>

                </td>
            </tr>
            @empty
            <tr>
                <th scope="row" colspan="3" class="text-center">There are no types</th>
            </tr>
                
            @endforelse
          </tbody>
    </table>    
@endsection