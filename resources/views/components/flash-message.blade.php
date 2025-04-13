@if (Session::has('Success'))
<div class="alert alert-success">
    {{ Session::get('Success') }}
</div>
@endif
@if (Session::has('Info'))
<div class="alert alert-info">
    {{ Session::get('Info') }}
</div>
@endif
@if (Session::has('Error'))
<div class="alert alert-danger">
    {{ Session::get('Error') }}
</div>
@endif
@if (Session::has('Warning'))
<div class="alert alert-warning">
    {{ Session::get('Warning') }}
</div>
@endif
