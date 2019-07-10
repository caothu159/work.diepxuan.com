<?php ?>

<table class="table table-hover col-12 table-sm table-responsive-sm">
    @foreach (App\Http\Controllers\Admin\SalaryController::years() as $year)
        <tr>
            @foreach (array_keys(array_fill(1, 12, null)) as $month)
                <td>

                    @if (in_array($month, App\Http\Controllers\Admin\SalaryController::months($year)))
                        <a class="text-success font-weight-bold"
                           href="{{ App\Http\Controllers\Admin\SalaryController::link($year, $month) }}">{{ "$month/$year" }}</a>
                    @else
                        <span class="font-weight-lighter">{{ "$month/$year" }}</span>
                    @endif

                </td>
            @endforeach
        </tr>
    @endforeach
</table>
