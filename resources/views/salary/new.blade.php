@auth
<?php $user = $service->getUser(); ?>
<form method="post" action="{{ route('salary.store') }}" class="row row-cols-lg-auto g-3 align-items-center">
    @method('POST')
    @csrf
    <div class="form-group col-sm-6 col-md-2 row">
        <input type="number" class="form-control col-4 form-control-sm" name="ngay" placeholder="{{ __('default.day') }}" />
        <input type="number" class="form-control col-4 form-control-sm" name="thang" placeholder="{{ __('default.month') }}" value="{{$user->thang}}" />
        <input type="number" class="form-control col-4 form-control-sm" name="nam" placeholder="{{ __('default.year') }}" value="{{$user->nam}}" />
    </div>
    <div class="form-group col-auto">
        <input type="text" class="form-control form-control-sm" name="ten" placeholder="tên" value="{{$user->ten}}" />
    </div>
    <div class="form-group col-auto">
        <input type="text" class="form-control form-control-sm" name="chamcong" placeholder="chấm công" />
    </div>
    <div class="form-group col-auto">
        <input type="text" class="form-control form-control-sm" name="diadiem" placeholder="địa điểm" />
    </div>
    <div class="form-group col-auto">
        <input type="number" class="form-control form-control-sm" name="doanhso" placeholder="doanh số" />
    </div>
    <div class="form-group col-auto">
        <input type="number" class="form-control form-control-sm" name="chono" placeholder="cho nợ" />
    </div>
    <div class="form-group col-auto">
        <input type="number" class="form-control form-control-sm" name="thuno" placeholder="thu nợ" />
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">{{ __('default.add') }}</button>
    </div>
</form>
@endauth
