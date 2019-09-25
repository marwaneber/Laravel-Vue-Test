@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <add-item ></add-item>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <items-app></items-app>
        </div>
    </div>
</div>
@endsection
