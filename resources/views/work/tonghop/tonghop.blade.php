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
                <th>{{$ctbh->ngay_ct->format('d/m/Y')}}</th>
                {{--                <th>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$ctbh->ngay_ct)->format('d/m/Y')}}</th>--}}
                <th>{{$ctbh->stt_rec}}</th>
                <th colspan="2">{{$ctbh->dien_giai}}</th>
                <th class="text-right">{{number_format($ctbh->t_tien2,0,","," ")}}</th>
            </tr>
            </thead>
            <tbody class="collapse" id="collapse{{ $ctbh->stt_rec }}" aria-labelledby="heading{{ $ctbh->stt_rec }}"
                   data-parent="#accordionCtbh">

            @foreach($ctbh->vattus as $vt)
                <tr>
                    <td></td>
                    <td>{{$vt->ten_vt}}</td>
                    <td class="text-right">{{number_format($vt->so_luong)}}</td>
                    <td class="text-right">{{number_format($vt->gia2,0,","," ")}}</td>
                    <td class="text-right">{{number_format($vt->tt,0,","," ")}}</td>
                </tr>
            @endforeach

            </tbody>
        @endforeach
    </table>
@endsection
