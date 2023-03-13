@if (session('message'))
  <div class="alert alert-{{ session('type') }} mt-5">
    {{ session('message') }}
  </div>
@endif
