<form class="form-inline" action="{{ route(($router?:'banhang').'.index') }}">
    @method('POST')
    @csrf
    <div class="input-group mr-sm-2">
        <div class="input-group-prepend">
            <span class="input-group-text" id="fromDate">from</span>
        </div>
        <input type="text"
               name="from" value="{{ $from }}"
               class="form-control"
               placeholder="dd-mm-yyyy" aria-describedby="fromDate"/>
    </div>
    <div class="input-group mr-sm-2">
        <div class="input-group-prepend">
            <span class="input-group-text" id="toDate">to</span>
        </div>
        <input type="text"
               name="to" value="{{ $to }}"
               class="form-control" placeholder="dd-mm-yyyy" aria-describedby="toDate"/>
    </div>
    @yield('work.components.timer.extend')
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{{ 'Lọc' }}</button>
</form>
