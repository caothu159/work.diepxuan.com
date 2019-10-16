<table class="table col-sm-3 m-0 table-sm table-responsive-sm">
    @foreach ($controller->years() as $year)
        <?php $months = $controller->months( $year ); ?>
        <tr>
            <td rowspan="2"><span class="font-weight-bold">{{ "$year" }}</span></td>
            @foreach (array_keys(array_fill(1, 12, null)) as $i => $month)
                <td>

                    @if ($time['month']==$month && $time['year']==$year)
                        <span class="font-weight-lighter badge badge-success">{{ "$month" }}</span>
                    @elseif (in_array($month, $months))
                        <a class="text-success font-weight-bold"
                           href="{{ $controller->link($year, $month) }}">{{ "$month" }}</a>
                    @else
                        <span class="font-weight-lighter">{{ "$month" }}</span>
                    @endif

                </td>
                @if($i==5)
                    {!! "</tr><tr>" !!}
                @endif
            @endforeach
        </tr>
    @endforeach
</table>
