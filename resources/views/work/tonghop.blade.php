@extends('work.work')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div id="work-content">
        @yield('content')
    </div>

@endsection
