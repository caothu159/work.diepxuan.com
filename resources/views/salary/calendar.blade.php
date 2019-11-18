<?php
$day = 0;
$week = 0;
?>
<table class="table table-sm table-borderless text-center text-small mb-0 text-monospace">
    <tr>
        <td colspan="{{$salary->weekstart - 1}}"></td>
        @while ($day <= $salary->presences->keys()->last())
            <?php
            $presence = $salary->presences->get( $day );
            $presencePoint = $presence ? $presence->presence : 0;
            $presenceCss = $presencePoint == 1 ? 'success' : 'danger';
            $presenceWeek = $presence ? $presence->week : 0;
            ?>
            <td class="table-{{ $presenceCss }} pb-0 pt-0">
                <span>{{ $presencePoint }}</span>
            </td>

            @if ($presenceWeek==0)
                {!! '</tr><tr>' !!}
            @endif

            <?php $day += 1; ?>
        @endwhile
    </tr>
</table>
