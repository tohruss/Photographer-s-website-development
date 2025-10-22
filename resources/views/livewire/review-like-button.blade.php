<div>
    <button wire:click="toggleLike" class="like-button">
        @if($isLiked)
            <img src="{{ asset('img/heart-active.png') }}" alt="Лайк" class="heart-icon">
        @else
            <img src="{{ asset('img/heart-stock.png') }}" alt="Не лайк" class="heart-icon">
        @endif
        <span class="likes-count">{{ $likesCount }}</span>
    </button>
</div>
