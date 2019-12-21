<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="banhangDropdown" role="button" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">
        {{ __('Tổng Hợp') }}
    </a>
    <div class="dropdown-menu" aria-labelledby="banhangDropdown">
        <a class="dropdown-item"
           href="{{ route('tonghop', [ 'from' => $from, 'to' => $to ]) }}">{{ __('Ban Hang') }}</a>
        <div class="dropdown-divider"></div>
    </div>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="banhangDropdown" role="button" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">
        {{ __('Bán Hàng') }}
    </a>
    <div class="dropdown-menu" aria-labelledby="banhangDropdown">
        <a class="dropdown-item"
           href="{{ route('banhang', [ 'from' => $from, 'to' => $to ]) }}">{{ __('Hóa đơn bán hàng') }}</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('banhang') }}">{{ __('Phiếu nhập trả hàng') }}</a>
    </div>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="muahangDropdown" role="button" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">
        {{ __('Mua Hàng') }}
    </a>
    <div class="dropdown-menu" aria-labelledby="muahangDropdown">
        <a class="dropdown-item"
           href="{{ route('muahang', [ 'from' => $from, 'to' => $to ]) }}">{{ __('Hóa đơn mua hàng') }}</a>
        <div class="dropdown-divider"></div>
    </div>
</li>
