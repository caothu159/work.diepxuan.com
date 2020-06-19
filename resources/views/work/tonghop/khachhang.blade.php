{{-- @deprecated --}}
@extends('work.tonghop')

@section('content')
    @include('work.tonghop.timer')

    <table class="table table-hover table-condensed table-sm text-monospace small">
        <tbody>
        @foreach($ctubanhangs as $ctubanhang)
            <tr>
                <td>{{ $ctubanhang->ten_kh ?: $ctubanhang->khachhang->ten_kh }}</td>
                <td>{{ $ctubanhang->ma_kho }}</td>
                <td class="text-nowrap text-right font-weight-bold">{{ number_format($ctubanhang->tien2, 0, ',', ' ') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
