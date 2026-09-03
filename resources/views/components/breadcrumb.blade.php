@props(['links' => []])

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
        @foreach($links as $label => $url)
            @if($loop->last)
                <li class="breadcrumb-item active fw-bold" style="color: #1a3a2a;">
                    {{ $label }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $url }}" style="color: #c9a84c; text-decoration: none; font-weight: 600;">
                        {{ $label }}
                    </a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>