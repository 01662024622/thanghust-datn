@extends('layouts.app')

@section('css')
<style type="text/css" media="screen">
    .table-container{
        background-color: #449d44;
        margin:30px;
        color: white;
        font-size: 30px;
        font-weight: 900;
        text-align: center;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        @foreach($tables as $table)
        
        @endforeach
    </div>
</div>
@endsection
