@extends('work.components.timer')

@section('work.components.timer.extend')
    <div class="form-check form-check-inline mr-sm-2">
        <input class="form-check-input" type="radio" name="tuychon" id="tuychon1"
               value="donhang" {{ $tuychon=='donhang'?'checked':'' }}>
        <label class="form-check-label" for="tuychon1">{{ 'Đơn hàng' }}</label>
    </div>
    <div class="form-check form-check-inline mr-sm-2">
        <input class="form-check-input" type="radio" name="tuychon" id="tuychon2"
               value="khachhang" {{ $tuychon=='khachhang'?'checked':'' }}>
        <label class="form-check-label" for="tuychon2">{{ 'Khách hàng' }}</label>
    </div>
    <div class="form-check form-check-inline mr-sm-2">
        <input class="form-check-input" type="radio" name="tuychon" id="tuychon3"
               value="bophan" {{ $tuychon=='bophan'?'checked':'' }} disabled>
        <label class="form-check-label" for="tuychon3">{{ 'Bộ phận (disabled)' }}</label>
    </div>

    <div class="form-group">
        <label for="selectKhohang">{{ 'Kho Hàng' }}</label>
        <select class="form-control" id="selectKhohang">
            @foreach($khohangs as $khohang)
                <option value="{{ $khohang->ma_kho }}">{{ $khohang->ten_kho }}</option>
            @endforeach
        </select>
    </div>
@endsection
