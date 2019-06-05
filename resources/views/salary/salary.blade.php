<nav class="navbar navbar-light navbar-expand-lg bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggleExternalContent">
        <form class="form-inline" method="post" action>
            @method('POST')
            @csrf
            <input type="hidden" name="import" value="import">
            <button class="btn btn-outline-success" type="submit">import</button>
        </form>
    </div>
</nav>
{{ print_r($data, true) }}
