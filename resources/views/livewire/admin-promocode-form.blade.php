<div>
    <div class="create-promo-button">
        <button wire:click="openModal">Создать промокод</button>
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
                    <h2>Создать промокод</h2>
                    <button wire:click="closeModal">&times;</button>
                </div>

                <form wire:submit.prevent="createPromocode" class="review-modal-form">
                    <div class="form-group">
                        <label for="image">Изображение промокода</label>
                        <input type="file" wire:model="image" id="image" accept="image/*"/>
                        @error('image') <span class="error" style="color: red; font-size: 0.9rem;">{{ $message }}</span> @enderror

                        @if($image)
                            <div class="image-preview">
                                <p>Предпросмотр:</p>
                                <img src="{{ $image->temporaryUrl() }}" alt="Предпросмотр" style="max-width: 150px; margin-top: 10px;">
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="name">Название промокода</label>
                        <input
                            type="text"
                            wire:model="name"
                            id="name"
                            placeholder="Например: PHOTO2025"
                        />
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="discount">Скидка (в рублях)</label>
                        <input
                            type="number"
                            step="0.01"
                            wire:model="discount"
                            id="discount"
                            placeholder="Например: 500"
                        />
                        @error('discount') <span class="error" style="color: red; font-size: 0.9rem;"> {{ $message }}</span> @enderror
                    </div>

                    <div class="review-modal-footer">
                        <button type="submit">Создать</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
