{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><span class="fa fa-check-circle"></span></strong>
    {{ Session::get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Error!</strong>
    {{ Session::get('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif --}}

<script>
@if (Session::has('success'))
   toastr.success("{{ Session::get('success') }}")
@endif

@if (Session::has('error'))
   toastr.error("{{ Session::get('error') }}")
@endif

</script>

@if ($errors->any())
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Error!</strong>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- <span class="response"></span> --}}