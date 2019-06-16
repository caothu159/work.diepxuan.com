<form method="post" class="mb-1" action="{{ route('admin.'.$type, $time) }}">
    @method('POST')
    @csrf
    <button class="btn btn-link text-left p-0 m-0 border-0 text-decoration-none text-light" type="submit" name="import"
        value="import">
        {{ __($type) }}
    </button>
</form>
