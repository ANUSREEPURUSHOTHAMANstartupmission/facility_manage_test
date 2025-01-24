@component('mail::message')
# Booking Confirmation

Booking has been completed for following items.

@component('mail::table')
| Sl | Booked Items  |
|:--:|:------------- |
@foreach ($booking->facilities as $key => $facility)
| {{$key+1}} | {{$facility->name}}     |
@endforeach
@endcomponent
 
## Booking Details
|    |    |
|:-- |:-- |
| **Name:** | {{$booking->user->name}} |
| **Email:** | {{$booking->user->email}} |
| **Phone:** | {{$booking->user->phone}} |
| **Organisation:** | {{$booking->user->organisation}} |
@if($booking->type == "visit")
| **Visit Date:** | {{Carbon::parse($booking->start)->format('d M Y')}} |
| **Visitor Count:** | {{$booking->visitor_count}} |
| **Participant List:** | <a href="{{ Storage::url($booking->participants) }}" target="_blank">View List</a> |
@else
<?php
  $hours = BookingHelper::date_diff($booking->start, $booking->end)
?>
| **Start:** | {{Carbon::parse($booking->start)->toDayDateTimeString()}} |
| **End:** | {{Carbon::parse($booking->end)->toDayDateTimeString()}} |
| **Hours:** | {{ $hours }} Hours |
| **Purpose:** | {{$booking->purpose}} |
| **No. of Participant:** | {{$booking->participants}} |
@endif


 
<br><br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent