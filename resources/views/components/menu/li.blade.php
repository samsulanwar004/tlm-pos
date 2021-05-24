@props(['route', 'label', 'menu' => null, 'icon' => 'far fa-circle'])
@can($menu)
<li class="nav-item pl-3" menu="{{ $menu }}">
    <a href="{{ route($route) }}" class="nav-link">
        <i class="{{ $icon }} nav-icon"></i>
        <p>{{ $label }}</p>
    </a>
</li>
@endcan
