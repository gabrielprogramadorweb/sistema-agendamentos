@extends('Front.Layout.main')

@section('title')
    {{ $title }}
@endsection
@section('css')


@endsection
@section('content')
    <div class="container pt-5">
        <h1 class="mt-5">{{ $title }}</h1>
        <div class="row">
            <div class="col-md-12">
                <p class="lead">Escolha uma Unidade</p>
               <div>{!! $units !!}</div>
            </div>
        </div>
    </div>

@endsection

@section('js')


@endsection

