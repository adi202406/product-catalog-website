<div>
    <div>
        @if($url_logo)
            <img src="{{ Storage::url($url_logo) }}" alt="{{ $name }} Logo" class="h-8 w-auto">
        @endif
        <span>{{ $name }}</span>
    </div>
</div>
