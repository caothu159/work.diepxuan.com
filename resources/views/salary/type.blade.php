<ul class="nav flex-column">
    @foreach (['employee', 'presence', 'division', 'productivity', 'salary'] as $t)
    <li class="nav-item">
        <a class="nav-link{{ $t == 'type' ? ' active' : '' }}"
           href="{{ $salary->link($salary->getYear(), $salary->getMonth(), $t) }}">{{ $t }}</a>
    </li>
    @endforeach
</ul>
