<?php

namespace App\Livewire;

use App\Models\Promocode;
use App\Models\Service;
use App\Models\BookingRequest;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BookingForm extends Component
{
    public $showModal = false;
    public $selectedServiceId = null;
    public $selectedDate = '';
    public $promoCode = '';
    public $services = [];
    public $appliedPromoName = null;
    public $finalPrice = 0;

    protected $rules = [
        'selectedServiceId' => 'required|exists:services,id',
        'selectedDate' => 'required|date|after_or_equal:today',
        'promoCode' => 'nullable|string',
    ];

    public function mount()
    {
        $this->services = Service::where('is_available', true)->get();
    }

    public function openModal()
    {
        $this->reset([
            'selectedServiceId', 'selectedDate', 'promoCode',
            'finalPrice', 'appliedPromoName'
        ]);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset([
            'selectedServiceId', 'selectedDate', 'promoCode',
            'finalPrice', 'appliedPromoName'
        ]);
    }

    public function updatedSelectedServiceId()
    {
        $this->updateFinalPrice();
    }

    public function updatedPromoCode()
    {
        $this->resetValidation('promoCode');
        $this->appliedPromoName = null;

        if (!empty($this->promoCode)) {
            $promo = Promocode::where('name', $this->promoCode)
                ->where('is_active', true)
                ->first();

            if ($promo) {
                $this->appliedPromoName = $promo->name;
            } else {
                $this->addError('promoCode', 'Промокод недействителен.');
            }
        }

        $this->updateFinalPrice();
    }


    private function updateFinalPrice()
    {
        if ($this->selectedServiceId) {
            $service = Service::find($this->selectedServiceId);
            if ($service) {
                $this->finalPrice = $service->price;

                if ($this->appliedPromoName) {
                    $promo = Promocode::where('name', $this->promoCode)
                        ->where('is_active', true)
                        ->first();
                    if ($promo) {
                        $this->finalPrice = max(0, $this->finalPrice - $promo->discount);
                    } else {
                        $this->appliedPromoName = null;
                    }
                }
            }
        }
    }

    public function submit()
    {
        if (!Auth::check()) {
            $this->addError('auth', 'Вы должны быть авторизованы, чтобы оставить заявку.');
            return;
        }

        $this->validate();

        $service = Service::find($this->selectedServiceId);
        if (!$service || !$service->is_available) {
            $this->addError('selectedServiceId', 'Выбранная услуга недоступна.');
            return;
        }

        if (strtotime($this->selectedDate) < strtotime('today')) {
            $this->addError('selectedDate', 'Дата должна быть сегодня или позже.');
            return;
        }

        $promocode = null;
        if (!empty($this->promoCode)) {
            $promocode = Promocode::where('name', strtoupper(trim($this->promoCode)))
                ->where('is_active', true)
                ->first();

            if (!$promocode) {
                $this->addError('promoCode', 'Промокод недействителен.');
                return;
            }

            if (BookingRequest::where('user_id', Auth::id())
                ->where('promocode_id', $promocode->id)
                ->exists()) {
                $this->addError('promoCode', 'Вы уже использовали этот промокод.');
                return;
            }
        }

        $this->finalPrice = $service->price;
        if ($promocode) {
            $this->finalPrice = max(0, $this->finalPrice - $promocode->discount);
        }

        $booking = new BookingRequest();
        $booking->user_id = Auth::id();
        $booking->service_id = $this->selectedServiceId;
        $booking->date = $this->selectedDate;
        $booking->promocode_id = $promocode?->id;
        $booking->sale_price = $this->finalPrice;
        $booking->save();

        $this->sendNotificationEmail($booking);

        if ($promocode) {
            session()->flash('message', "Ваша заявка успешно отправлена! Применён промокод «{$promocode->name}». Итоговая цена: {$this->finalPrice} руб.");
        } else {
            session()->flash('message', "Ваша заявка успешно отправлена! Стоимость: {$this->finalPrice} руб.");
        }

        $this->closeModal();
        $this->dispatch('bookingSubmitted');
    }

    private function sendNotificationEmail($booking)
    {
        $adminEmail = 't8enty@ya.ru';
        $userInfo = $booking->user->userInfo;
        $userName = $userInfo?->name ?? 'Не указано';
        $userSurname = $userInfo?->surname ?? 'Не указано';
        $userPhone = $userInfo?->tel ?? 'Не указан';

        \Mail::raw(
            "Новая заявка на фотосессию!\n\n" .
            "Имя: {$userName}\n" .
            "Фамилия: {$userSurname}\n" .
            "Email: {$booking->user->email}\n" .
            "Телефон: {$userPhone}\n\n" .
            "Услуга: {$booking->service->title}\n" .
            "Дата: {$booking->date}\n" .
            "Цена: {$booking->sale_price} руб.\n" .
            "Промокод: " . ($booking->promocode ? $booking->promocode->name : 'Не использован'),
            function ($message) use ($adminEmail) {
                $message->to($adminEmail)->subject('Новая заявка на фотосессию');
            }
        );
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
