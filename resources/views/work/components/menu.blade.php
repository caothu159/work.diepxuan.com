@extends('layouts.app')

@section('menu.left')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('muahang') }}">{{ __('Mua Hàng') }}</a>
    </li>
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if ($ctubanhangs)
        @include('work.muahang.chungtu')
    @endif

@endsection
