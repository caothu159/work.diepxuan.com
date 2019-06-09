<form class="form-inline" method="post" action="{{ route($type, ['year' => $salary->getYear(), 'month' => $salary->getMonth()]) }}">
    @method('POST')
    @csrf
    <button class="btn btn-outline-success" type="submit" name="import" value="import" >import {{ $type }}</button>
</form>
