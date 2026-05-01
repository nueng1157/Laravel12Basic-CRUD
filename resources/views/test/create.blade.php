@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-sm-9">

            <h3> :: form Add :: </h3>


<form action="/test/" method="post">
@csrf


<div class="form-group row mb-2">
    <label class="col-sm-2"> Name 1 </label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="name" required placeholder="Name1" minlength="3"  value="{{ old('name') }}">
        @if(isset($errors))
            @if($errors->has('name'))
                <div class="text-danger"> {{ $errors->first('name') }}</div>
            @endif 
        @endif
    </div>
</div>

<div class="form-group row mb-2">
    <label class="col-sm-2"> Name 2 </label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="name2" required placeholder="Name2" minlength="3"  value="{{ old('name2') }}">
        @if(isset($errors))
            @if($errors->has('name2'))
                <div class="text-danger"> {{ $errors->first('name2') }}</div>
            @endif 
        @endif
    </div>
</div>


<div class="form-group row mb-2">
    <label class="col-sm-2">  </label>
    <div class="col-sm-5">
       
       <button type="submit" class="btn btn-primary"> Insert  </button> 
       <a href="/test" class="btn btn-danger">cancel</a>
    </div>
</div>

</form>

</div> <!--  / <div class="col-sm-9 col-md-9"> -->


@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

@section('js_before')
@endsection