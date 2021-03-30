@extends('layouts.app')

@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<div class="col-12">
    <div class="row align-items-stretch salary-container" id="accordionSalary">
        @include('salary/salary0221')
    </div>
</div>

@endsection

@section('sidebar.salary')
@endsection
