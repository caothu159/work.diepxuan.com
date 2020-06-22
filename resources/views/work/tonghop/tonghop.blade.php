@extends('work.tonghop')

@section('content')
    @include('work.components.timer')

    <div class="container">
        <form class="form row" action="{{ route(Route::currentRouteName()) }}" method="POST">
            @method('POST')
            @csrf
        </form>
    </div>

    <table class="table table-hover table-condensed table-sm text-monospace small">
        <tbody>
        </tbody>
    </table>
    {{--    <pre>{{ print_r($data,true) }}</pre>--}}

    <table class="table table-hover table-condensed table-sm text-left text-small" id="accordionCtbh">
        @foreach($data as $ctbh)
            <thead id="heading{{ $ctbh->stt_rec }}">
            <tr href="#collapse{{ $ctbh->stt_rec }}" aria-controls="collapse{{ $ctbh->stt_rec }}"
                data-toggle="collapse" aria-expanded="false" class="isPointer">
                <th>{{$ctbh->ngay_ct}}</th>
                <th>{{$ctbh->stt_rec}}</th>
                <th>{{$ctbh->dien_giai}}</th>
                <th>{{$ctbh->t_tien2}}</th>
            </tr>
            </thead>
            <tbody class="collapse" id="collapse{{ $ctbh->stt_rec }}" aria-labelledby="heading{{ $ctbh->stt_rec }}"
                   data-parent="#accordionCtbh">

            @foreach($ctbh->vattus as $vt)
                <tr>
                    <td>{{$vt->ten_vt}}</td>
                    <td>{{$vt->so_luong}}</td>
                    <td>{{$vt->gia2}}</td>
                    <td>{{$vt->tt}}</td>
                </tr>
            @endforeach

            </tbody>
        @endforeach
    </table>
@endsection
