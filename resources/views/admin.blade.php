@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-between">
        <div class="col-md-2 pr-4">
            <div class="card border-primary">
                <div class="card-body border-primary p-2">
                    @include('salary/sidebar')
                </div>
            </div>
        </div>

        <div class="col-md-10">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <div class="row" id="accordionSalary">
                @include('salary/salary')
            </div>
        </div>
    </div>
</div>
@endsection

@section('sidebar.salary')
<form method="post" class="mb-1" action="{{ route('admin.salary', $time) }}">
    @method('POST')
    @csrf
    <button class="btn btn-link text-left p-0 m-0 border-0 text-decoration-none text-light text-capitalize"
        type="submit" name="import" value="import">
        {{ __('load data from cloud') }}
    </button>
</form>
@endsection
