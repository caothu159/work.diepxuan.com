{{--{{ dd($salary->month) }}--}}
{{--{{ dd($salary->presences) }}--}}
{{--{{ dd($salary->presences->get(1)) }}--}}
<?php
$day = 0;
$week = 0;
?>
<table class="table table-sm table-borderless text-center text-small mb-0 text-monospace">
    <tr>
        <td colspan="{{$salary->weekstart - 1}}"></td>
        @while ($day <= $salary->presences->keys()->last())
            <td class="table-{{ $salary->presences->get($day)->presence==1?'success':'danger' }} pb-0 pt-0">
                {{--                <span>{{ $salary->presences->get($day)->week }}</span>--}}
                <span>{{ $salary->presences->get($day)->datetime }}</span>
            </td>

            @if ($salary->presences->get($day)->week==0)
                {!! '</tr><tr>' !!}
            @endif

            <?php $day += 1; ?>
        @endwhile
    </tr>
</table>
