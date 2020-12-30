@auth
@php
$user = $service->getUser();
@endphp
<form method="post" action="{{ route('salaryuser.update', ['salaryuser' => $user->id?:0]) }}" class="row row-cols-lg-auto g-3 align-items-center">
    @method('PUT')
    @csrf
    <div class="form-group col-sm-6 col-md-2 row">
        <input type="number" class="form-control col-6 form-control-sm" name="thang" placeholder="{{ __('default.month') }}" value="{{$user->thang}}" />
        <input type="number" class="form-control col-6 form-control-sm" name="nam" placeholder="{{ __('default.year') }}" value="{{$user->nam}}" />
    </div>
    <div class="form-group col-auto">
        <input type="text" class="form-control form-control-sm" name="ten" placeholder="tên" value="{{$user->ten}}" />
    </div>
    <div class="form-group col-auto">
        <input type="text" class="form-control form-control-sm" name="luongcoban" placeholder="lương cơ bản" value="{{$user->luongcoban?:''}}" />
    </div>
    <div class="form-group col-auto">
        <input type="text" class="form-control form-control-sm" name="heso" placeholder="hệ số" value="{{$user->heso?:''}}" />
    </div>
    <div class="form-group col-auto">
        <input type="number" class="form-control form-control-sm" name="chitieu" placeholder="chỉ tiêu" value="{{$user->chitieu?:''}}" />
    </div>
    <div class="form-group col-auto">
        <input type="number" class="form-control form-control-sm" name="baohiem" placeholder="bảo hiểm" value="{{$user->baohiem?:''}}" />
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">{{ __('default.add') }}</button>
    </div>
</form>
@endauth
