@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-between">
        {{-- <div class="col-md-2 pr-4"> --}}
        @include('salary/sidebar')
        {{-- </div> --}}

        {{-- <div class="col-md-12"> --}}
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
        <div class="row align-items-stretch" id="accordionSalary">
            @include('salary/salary')
        </div>
        {{-- </div> --}}
    </div>
</div>
@endsection

@section('sidebar.salary')
<li>
    <form method="post" class="mb-1" action="{{ route('admin.salary', $time) }}">
        @method('POST')
        @csrf
        <button class="btn btn-link text-left p-0 m-0 border-0 text-decoration-none text-light text-capitalize"
            type="submit" name="import" value="import">
            {{ __('from cloud') }}
        </button>
    </form>
</li>
@endsection
