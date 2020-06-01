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
        @if ($table['status']==0)
        <a href="/table/{{$table->code}}" title="" class="col-xs-6 col-sm-4 table-container" >{{$table->code}}

            <br> {{$table['name']}}-{{$table['phone']}}
            <br> 
            {{$table->member}}
        </a>
        @elseif ($table['status'] == 1)
        <a href="/table/{{$table->code}}" title="" class="col-xs-6 col-sm-4 table-container" style="background-color: #00c0ef;">{{$table->code}}

            <br> 
            {{$table['name']}}-{{$table['phone']}}
            <br> 
            {{$table->member}}
        </a>
        @else
        <a href="/table/{{$table->code}}" title="" class="col-xs-6 col-sm-4 table-container" style="background-color: #ec971f;">{{$table->code}}

            <br> 
            {{$table['name']}}-{{$table['phone']}}
            
            <br> 
            {{$table->member}}
        </a>
        @endif
        @endforeach
    </div>
</div>
@endsection
