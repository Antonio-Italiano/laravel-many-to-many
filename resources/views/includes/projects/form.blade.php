{{-- Form --}}
@if ($project->exists)
  <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" novalidate>
    @method('PUT')
  @else
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" novalidate>
@endif


  @csrf

  <div class="row pb-3">

    {{-- TITLE  --}}  
    <div class="col-6">
      <div class="my-4 w-75">
        <label for="title" class="form-label"><h6>Title</h6></label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
        name="title" required value="{{ old('title', $project->title) }}">
        @error('title')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @else
        <small class="text-muted">Enter title</small>
        @enderror
      </div>
    </div>

    {{-- SLUG PREVIEW  --}}  
    <div class="col-6">
      <div class="my-4 w-75">
        <label for="slug" class="form-label"><h6>Slug</h6></label>
        <input type="text" class="form-control" id="slug"
        name="slug" disabled value="{{ Str::slug(old('slug', $project->slug), '-') }}">
      </div>
    </div>   

    {{-- Type-Select  --}}
    <div class="col-3">
      <div class="mb-5 w-50">        
        
        <label for="type_id" class="form-label"><h6>Type</h6></label>
        <select class="form-select @error('type_id') is-invalid @enderror" name="type_id" id="type_id" >
          <option value="">Nessuna Type</option>
          @foreach($types as $type)
            <option @if (old('type_id', $project->type_id) == $type->id) selected @endif value="{{ $type->id }}">
              {{ $type->label }}
            </option>
          @endforeach
        </select>
        @error('type_id')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    {{-- PUBLISHED  --}}
    <div class="col-3">
      <div class="mt-4">        
        <div class="form-check form-switch">
          <input class="fs-3 form-check-input" type="checkbox" role="switch" id="is_published" name="is_published"
          @if(old('is_published', $project->is_published)) checked @endif>
          <label class="mt-2 form-check-label" for="is_published"><h6>Published</h6></label>
        </div>
      </div>
    </div>

    {{-- URL  --}}
    <div class="col-6">
      <div class="mb-5">
        <label for="url" class="form-label"><h6>Url Search</h6></label>
        <input type="url" class="form-control @error('url') is-invalid @enderror" id="url"
        name="url" value="{{ old('url', $project->url) }}">
        @error('url')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @else
        <small class="text-muted">Enter Search Url</small>
        @enderror 
      </div>
    </div>

    {{-- DESCRIPTION  --}}
    <div class="col-6">
      <div class="mb-3 w-75">
        <label for="description" class="form-label"><h6>Description</h6></label>
        <textarea name="description" id="description" cols="80" rows="8"
          class="form-control @error('description') is-invalid @enderror">{{ old('description', $project->description) }}</textarea>
          @error('description')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @else
        <small class="text-muted">Enter Description</small>
        @enderror 
      </div>
    </div>

    {{-- IMAGE  --}}
    <div class="col-6 d-flex flex-column align-items-center">
      <div class="col-12">
        <div class="mb-5 w-75">
          <label for="image" class="form-label"><h6>Image</h6></label>
          <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
          name="image" value="{{ old('image', $project->image) }}">
          @error('image')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
          @else
          <small class="text-muted">Enter image Url</small>
          @enderror 
        </div>
      </div>

      {{-- IMAGE PREVIEW --}} 
      <div class="col-4">
        <div class="mb-5">
          <img src="{{ old('image', asset('storage/' . $project->image)) }}" id="image-preview"
            alt="preview" class="img-fluid" width="100">
        </div>
      </div>  
    </div>

    {{-- Technology --}}
    <div class="col-12">
      <div class="mb-5">
        <h6>Technology</h6>
        @foreach ($technologies as $technology)
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="tag-{{$technology->id}}" value="{{$technology->id}}"
           name="technologies[]" @if(in_array($technology->id, old('technologies', $project_technologies ?? []))) checked  @endif>
          <label class="form-check-label" for="tag-{{$technology->id}}">{{$technology->label}} </label>
        </div>
        @endforeach
        @error('technologies')
         <small class="invalid-feedback d-block">{{$message}}</small>            
        @enderror
      </div>
    </div>

    
  
    <hr>
    <div class="d-flex justify-content-between">
      <a class="btn btn-secondary" href="{{route('admin.projects.index')}}">Indietro</a>
      <button type="submit" class="btn btn-success">Save</button>
    </div>
  </div>
  
</form>

@section('scripts')
 @vite(['resources/js/preview-slag.js'])    
 {{-- @vite(['resources/js/preview-img.js'])     --}}
@endsection