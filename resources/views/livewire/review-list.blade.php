<div class="review-container">
    @foreach($reviews as $review)
        <div class="review-item">
            <div class="avatar-wrapper">
                @if($review->user?->userInfo?->avatar)
                    <img draggable="false" src="{{ Storage::url($review->user->userInfo->avatar) }}" alt="Аватар" class="rounded-circle">
                @else
                    <img draggable="false" src="{{ asset('img/Group30.svg') }}" alt="Аватар по умолчанию" class="rounded-circle">
                @endif
            </div>
            <div class="content">
                <div class="author-name">
                    {{ $review->user?->userInfo?->name ?? 'Аноним' }}
                    <p>{{$review ->link_to_media}} </p>
                </div>
                <p>{{ $review->comment }}</p>
                <div class="footer">
                    <livewire:review-like-button :review-id="$review->id" />
                </div>
            </div>
        </div>
    @endforeach
</div>
