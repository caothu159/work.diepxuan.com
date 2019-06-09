<nav class="navbar navbar-light navbar-expand-lg bg-light">
    @include('salary/type', [ 'salary' => $salary, 'type' => 'employee' ])
    @include('salary/type', [ 'salary' => $salary, 'type' => 'presence' ])
    @include('salary/type', [ 'salary' => $salary, 'type' => 'division' ])
    @include('salary/type', [ 'salary' => $salary, 'type' => 'productivity' ])
</nav>
{{ print_r($data->toArray(),true) }}
