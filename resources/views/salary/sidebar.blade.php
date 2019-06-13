<?php use App\Http\Controllers\Admin\SalaryController;?>

@foreach (SalaryController::years() as $year)
<details open>
    <summary>{{ $year }}</summary>
    @foreach (SalaryController::months($year) as $month)
    <a href="{{ SalaryController::link($year, $month) }}">{{ $month }}</a>
    @endforeach
</details>
@endforeach
