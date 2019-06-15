@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-between">
        <div class="col-md-3 pr-4">
            <div class="card border-primary">
                <div class="card-body border-primary">
                    @include('salary/sidebar')
                </div>
            </div>
        </div>

        <div class="col-md-9">
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
@include('salary/type', [ 'type' => 'employee' ])
@include('salary/type', [ 'type' => 'presence' ])
@include('salary/type', [ 'type' => 'division' ])
@include('salary/type', [ 'type' => 'productivity' ])
@endsection
