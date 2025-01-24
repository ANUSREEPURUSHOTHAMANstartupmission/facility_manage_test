<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class BookingApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $booking;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // $total = $this->booking->facilities->reduce(function($carry, $item){
        //     return $carry + $item->pivot->amount;
        // });

        // $discount = ($total * ($this->booking->discount??0))/100;
        // $paid = $this->booking->payments()->where('status','paid')->sum('amount');
        // $balance = $total-$discount-$paid;

        if($this->booking->balance > 0){
            return (new MailMessage)
                ->subject('Payment Required | Booking Approved - '.$this->booking->location->name)
                ->line('Thank you for your interest in booking a facility at '.$this->booking->location->name.'. Your booking has been accepted. Kindly make the payment to confirm your booking.')
                ->action('View Booking', route('booking.view',[$this->booking]))
                ->line('Your booking is confirmed only after successfull payment');
        }
        else{
            $this->booking->status = "confirmed";
            $this->booking->save();

            //:: Notifiaction to facility manager
            $fusers = $this->booking->facilities->map(function($facility){
                return $facility->users;
            })->flatten()->pluck('email')->unique();
            
            if($fusers->count())
                FacadesNotification::route('mail', $fusers)->notify(new FacilityBookedNotification($this->booking));

            return (new MailMessage)
                ->subject('Booking Confirmed - '.$this->booking->location->name)
                ->markdown('mail.booking', [ 'booking' => $this->booking ]);
        }
        
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
