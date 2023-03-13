{{-- Form --}}
@if ($type->exists)
  <form action="{{ route('admin.types.update', $type->id) }}" method="POST" enctype="multipart/form-data" novalidate>
    @method('PUT')
  @else
    <form action="{{ route('admin.types.store') }}" method="POST" enctype="multipart/form-data" novalidate>
@endif


  @csrf

  <div class="row pb-3">

    {{-- LABEL  --}}  
    <div class="col-6">
      <div class="my-4 w-75">
        <label for="label" class="form-label">Label</label>
        <input type="text" class="form-control @error('label') is-invalid @enderror" id="label"
        name="label" required value="{{ old('label', $type->label) }}">
        @error('label')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @else
        <small class="text-muted">Enter Label</small>
        @enderror
      </div>
    </div>   
  
    <hr>
    <div class="d-flex justify-content-between">
      <a class="btn btn-secondary" href="{{route('admin.types.index')}}">Indietro</a>
      <button type="submit" class="btn btn-success">Save</button>
    </div>
  </div>
  
</form>

@section('scripts')
 @vite(['resources/js/preview-slag.js'])    
@endsection