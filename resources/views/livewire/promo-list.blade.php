<div class="promocods">
    <h2>ПРОМОКОДЫ</h2>
    <div class="promo-list">
        @if($promocodes->count() > 0)
            @foreach($promocodes as $promo)
                <div class="promo-card" data-promo="{{ $promo->name }}">
                    <img draggable="false"
                         src="{{ $promo->image ? Storage::url($promo->image) : asset('img/default-promo.png') }}"
                         alt="Промокод {{ $promo->name }}"
                         style="width:100%; display:block;">
                    <div class="copy-feedback">Скопировано!</div>

                    @if(Auth::user()?->isAdmin())
                        <button wire:click="deactivate({{ $promo->id }})" class="delete-btn">&times;</button>
                    @endif
                </div>
            @endforeach
        @else
            <p>Нет доступных промокодов.</p>
        @endif
    </div>
</div>
