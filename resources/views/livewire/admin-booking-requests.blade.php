<div class="booking-requests">
    <h2>Управление заявками</h2>

    @if($bookings->isEmpty())
        <p style="text-align: center; font-size: 18px; color: #666;">Нет новых заявок.</p>
    @else
        <div class="booking-list">
            @foreach($bookings as $booking)
                <div class="booking-card">
                    <button
                        class="delete-btn"
                        wire:click="delete({{ $booking->id }})"
                        wire:confirm="Удалить заявку от {{ $booking->user->login }} на {{ $booking->date->format('d.m.Y') }}?"
                        title="Удалить заявку"
                    >
                        &times;
                    </button>

                    <div class="booking-header">
                        <strong>Дата и время: {{ $booking->date->format('d.m.Y в H:i') }}</strong>
                        <span class="price">{{ $booking->sale_price }} руб.</span>
                    </div>

                    <div class="booking-client">
                        <strong>Клиент:</strong>
                        {{ $booking->user->userInfo?->name ?? '—' }}
                        {{ $booking->user->userInfo?->surname ?? '' }}
                        ({{ $booking->user->login }})
                    </div>

                    <div class="booking-contact">
                        Email: {{ $booking->user->email }}<br>
                        Тел: {{ $booking->user->userInfo?->tel ?? 'Не указан' }}
                    </div>

                    <div class="booking-service">
                        <strong>Услуга:</strong> {{ $booking->service->title ?? '—' }}
                    </div>

                    @if($booking->promocode)
                        <div class="booking-promo">
                            Промокод: {{ $booking->promocode->name }}
                            (–{{ $booking->promocode->discount }} руб.)
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
