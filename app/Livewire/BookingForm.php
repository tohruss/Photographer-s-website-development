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
    public $promocodeInfo = null;
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
        $this->reset(['selectedServiceId', 'selectedDate', 'promoCode', 'promocodeInfo', 'finalPrice']);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['selectedServiceId', 'selectedDate', 'promoCode', 'promocodeInfo', 'finalPrice']);
    }

    public function updatedSelectedServiceId()
    {
        $this->updateFinalPrice();
    }

    public function updatedPromoCode()
    {
        $this->validateOnly('promoCode');

        if (!empty($this->promoCode)) {
            $this->promocodeInfo = Promocode::where('name', $this->promoCode)
                ->where('is_active', true)
                ->first();

            if (!$this->promocodeInfo) {
                $this->addError('promoCode', 'Промокод недействителен или неактивен.');
                $this->promocodeInfo = null;
            }
        } else {
            $this->promocodeInfo = null;
        }

        $this->updateFinalPrice();
    }

    private function updateFinalPrice()
    {
        if ($this->selectedServiceId) {
            $service = Service::find($this->selectedServiceId);
            if ($service) {
                $this->finalPrice = $service->price;

                if ($this->promocodeInfo) {
                    $this->finalPrice -= $this->promocodeInfo->discount;
                    $this->finalPrice = max(0, $this->finalPrice);
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
        if ($this->promocodeInfo) {
            if (BookingRequest::where('user_id', Auth::id())
                ->where('promocode_id', $this->promocodeInfo->id)
                ->exists()) {
                $this->addError('promoCode', 'Вы уже использовали этот промокод.');
                return;
            }
        }

        $booking = new BookingRequest();
        $booking->user_id = Auth::id();
        $booking->service_id = $this->selectedServiceId;
        $booking->date = $this->selectedDate;
        $booking->promocode_id = $this->promocodeInfo ? $this->promocodeInfo->id : null;
        $booking->updateSalePrice();
        $booking->save();

        $this->sendNotificationEmail($booking);

        session()->flash('message', 'Ваша заявка успешно отправлена!');
        $this->closeModal(); // ← закрываем модалку
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
