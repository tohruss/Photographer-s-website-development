<div>
    <div class="leave-review-button">
        <button wire:click="openModal">Оставить отзыв</button>
    </div>
    @if($message)
        <div class="review-success-message" x-data x-init="setTimeout(() => $el.remove(), 2000)">
            {{ $message }}
        </div>
    @endif

    @if($showModal)
        <div class="review-modal-overlay" wire:click="closeModal">
            <div class="review-modal-content" wire:click.stop>
                <div class="review-modal-header">
                    <h2>Ваш отзыв</h2>
                    <button wire:click="closeModal">&times;</button>
                </div>

                <form wire:submit.prevent="submit" class="review-modal-form">
                    <div class="form-group">
                        <label for="link_to_media">Ссылка на соц.сеть (опционально)</label>
                        <input
                            type="text"
                            wire:model="link_to_media"
                            id="link_to_media"
                            placeholder="@tohruss"
                        />
                        @error('link_to_media') <span class="error" style="color: red; font-size: 0.9rem;">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="comment">Отзыв</label>
                        <textarea
                            wire:model="comment"
                            id="comment"
                            placeholder="Ваш отзыв..."
                        ></textarea>
                        @error('comment') <span class="error" style="color: red; font-size: 0.9rem;">{{ $message }}</span> @enderror
                    </div>

                    <div class="review-modal-footer">
                        <button type="submit">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
