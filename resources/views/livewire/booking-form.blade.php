<div>
    <button wire:click="openModal" class="custom-modal-button">
        Хочу фотосессию
    </button>

    @if(session()->has('message'))
        <div class="booking-success-overlay" x-data x-init="setTimeout(() => $el.remove(), 2000)">
            <div class="booking-success-message">
                {{ session('message') }}
            </div>
        </div>
    @endif

    @if($showModal)
        @if(session()->has('message'))
            <div class="alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="booking-modal-overlay" wire:click="closeModal">
            <div class="booking-modal-content" wire:click.stop>
                <div class="booking-modal-header">
                    <h2>Записаться на фотосессию</h2>
                    <button wire:click="closeModal" class="modal-close-btn">&times;</button>
                </div>

                <form wire:submit.prevent="submit" class="booking-modal-form">
                    <div class="form-group">
                        <label for="service">Выберите услугу</label>
                        <select wire:model="selectedServiceId" id="service">
                            <option value="">-- Выберите услугу --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->title }} ({{ $service->price }} руб.)</option>
                            @endforeach
                        </select>
                        @error('selectedServiceId') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="date">Дата и время</label>
                        <input type="datetime-local" wire:model="selectedDate" id="date">
                        @error('selectedDate') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="promoCode">Промокод (необязательно)</label>
                        <input
                            type="text"
                            wire:model="promoCode"
                            id="promoCode"
                            placeholder="Введите промокод"
                            @if($promoCode) wire:loading.attr="disabled" @endif
                        >

                        <span wire:loading wire:target="promoCode" style="font-size: 0.9rem; color: #E7CFCD;">Проверка промокода...</span>

                        @error('promoCode')
                            <span class="text-danger" style="font-size: 0.9rem;">{{ $message }}</span>
                        @enderror
                    </div>

                    @if($selectedServiceId)
                        <div class="form-group">
                            <strong>Цена:</strong> {{ $services->firstWhere('id', $selectedServiceId)?->price ?? '—' }} руб.
                        </div>
                    @endif
                    @error('auth')
                    <div class="text-danger" style="margin-bottom: 1rem; text-align: center;">
                        {{ $message }}
                    </div>
                    @enderror

                    <button type="submit" class="submit-btn">Отправить заявку</button>
                </form>
            </div>
        </div>
    @endif
</div>
