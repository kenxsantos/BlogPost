@if (!isset($show) || $show)
    <span class="badge bg-{{ $type ?? 'success' }}">
        {{ $slot }}
    </span>
@endif
