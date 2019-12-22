@extends('work.banhang')

@section('content')
    @include('work.components.timer')
    <table class="table table-hover table-condensed table-sm text-monospace small">
        <tbody>
        @foreach($ctumuahangs as $ctumuahang)
            <tr>
                <td>{{ date('d/m/Y', strtotime($ctumuahang->ngay_ct)) }}</td>
                <td>{{ $ctumuahang->ma_kh }}</td>
                <td>{{ $ctumuahang->dien_giai }}</td>
                <td>{{ $ctumuahang->ma_kho }}</td>
                <td>{{ $ctumuahang->ten_vt }}</td>
                <td class="text-nowrap">{{ number_format($ctumuahang->so_luong, 0, ',', ' ') }}</td>
                <td>{{ $ctumuahang->dvt }}</td>
                <td class="text-nowrap text-right">{{ number_format($ctumuahang->gia, 0, ',', ' ') }}</td>
                <td class="text-nowrap text-right">{{ number_format($ctumuahang->tien, 0, ',', ' ') }}</td>
                <td>{{ $ctumuahang->so_ct }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
