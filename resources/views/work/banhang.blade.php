@extends('layouts.app')

@section('menu.left')
    @include('work.components.menu')
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if ($ctubanhangs)
        @include('work.banhang.chungtu')
    @endif

@endsection
