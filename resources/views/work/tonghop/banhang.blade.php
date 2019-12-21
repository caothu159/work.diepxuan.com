@extends('work.tonghop')

@section('content')
    @if ($ctubanhangs)
        <table class="table table-hover table-condensed table-sm text-monospace small">
            <tbody>
            @foreach($ctubanhangs as $ctubanhang)
                <tr class="{{ $ctubanhang->similar < 0.6 ? 'text-danger ' : '' }}">
                    <td>{{ date('d/m/Y', strtotime($ctubanhang->ngay_ct)) }}</td>
                    <td>{{ $ctubanhang->ten_kh ?: $ctubanhang->khachhang->ten_kh }}</td>
                    <td>{{ $ctubanhang->dien_giai }}</td>
                    <td>{{ $ctubanhang->ma_kho }}</td>
                    <td class="text-nowrap text-right font-weight-bold">{{ number_format($ctubanhang->tien2, 0, ',', ' ') }}</td>
                    {{--                    <td>{{ $ctubanhang->luser }}</td>--}}
                    {{--                    <td>{{ $ctubanhang->so_ct }}</td>--}}
                    {{--                    <td>{{ $ctubanhang->isMua ? 'mua' : 'lui' }}</td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
