<form method="post" class="mb-1" action="{{ route('admin.'.$type, $time) }}">
    @method('POST')
    @csrf
    <button class="btn btn-outline-primary btn-sm btn-block" type="submit" name="import" value="import" >import {{ $type }}</button>
</form>
