<div class="timer row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-body">
                <form class="form row" action="{{ route(Route::currentRouteName()) }}" method="POST">
                    @method('POST')
                    @csrf
                    <div class="input-group col-sm-6">
                        {{--                        <div class="input-group-prepend">--}}
                        {{--                            <span class="input-group-text" id="fromDate">from</span>--}}
                        {{--                        </div>--}}
                        {{--                        <input type="text"--}}
                        {{--                               name="from" value="{{ request()->get('from') }}"--}}
                        {{--                               class="form-control" placeholder="dd-mm-yyyy" aria-describedby="fromDate"/>--}}
                        {{ request()->get('from') }}
                        <datepicker name="from" :value="$this.stringToDate({{ request()->get('from') }})"
                                    format="dd-MM-yyyy"></datepicker>
                    </div>
                    <div class="input-group col-sm-6">
                        {{--                        <div class="input-group-prepend">--}}
                        {{--                            <span class="input-group-text" id="toDate">to</span>--}}
                        {{--                        </div>--}}
                        {{--                        <input type="text"--}}
                        {{--                               name="to" value="{{ request()->get('to') }}"--}}
                        {{--                               class="form-control" placeholder="dd-mm-yyyy" aria-describedby="toDate"/>--}}
                        {{ request()->get('to') }}
                        <datepicker name="to" :value="{{ request()->get('to') }}"
                                    format="dd-MM-yyyy"></datepicker>
                    </div>
                    @yield('work.components.timer.extend')
                    <div class="col-sm-12">
                        <button class="btn btn-outline-success" type="submit">{{ 'Lựa chọn' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
