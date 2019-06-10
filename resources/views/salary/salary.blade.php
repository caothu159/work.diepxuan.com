<nav class="navbar navbar-light navbar-expand-lg">
    @include('salary/type', [ 'salary' => $salary, 'type' => 'employee' ])
    @include('salary/type', [ 'salary' => $salary, 'type' => 'presence' ])
    @include('salary/type', [ 'salary' => $salary, 'type' => 'division' ])
    @include('salary/type', [ 'salary' => $salary, 'type' => 'productivity' ])
</nav>
{{ $data->toJson() }}
