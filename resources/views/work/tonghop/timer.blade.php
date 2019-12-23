@extends('work.components.timer')

@section('work.components.timer.extend')
    <div class="clearfix"></div>
    <div class="form-group col-sm-6">
        <label for="selectTuychon">{{ 'Tùy Chọn' }}</label>
        <select class="form-control" id="selectTuychon" name="tuychon">
            <option value="donhang" {{ request()->get('tuychon')=='donhang'?'selected':'' }}>
                {{ 'Đơn hàng' }}
            </option>
            <option value="khachhang" {{ request()->get('tuychon')=='khachhang'?'selected':'' }}>
                {{ 'Khách hàng' }}
            </option>
        </select>
    </div>

    <div class="form-group col-sm-6">
        <label for="selectKhohang">{{ 'Kho Hàng' }}</label>
        <select class="form-control" id="selectKhohang" name="khohang">
            <option value="{{ 'all' }}">{{ 'Tất cả' }}</option>
            @foreach($khohangs as $khohang)
                <option value="{{ $khohang->ma_kho }}" {{ request()->get('khohang')==$khohang->ma_kho?'selected':'' }}>
                    {{ $khohang->ten_kho }}
                </option>
            @endforeach
        </select>
    </div>
@endsection
