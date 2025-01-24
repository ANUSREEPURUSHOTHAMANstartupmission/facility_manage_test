<style>
			.invoice-box {
				/* max-width: 800px; */
				margin: auto;
				/* padding: 30px; */
				/* border: 1px solid #eee; */
				/* box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); */
				font-size: 16px;
				line-height: 24px;
				font-family: sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

      .invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr td:nth-child(3) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

      .invoice-box table tr.total td:nth-child(3) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

      .invoice-box table tr.subtotal td:nth-child(2) {
				border-top: 2px solid #eee;
			}

      .invoice-box table tr.subtotal td:nth-child(3) {
				border-top: 2px solid #eee;
			}

      .invoice-box table.pay_heading tr th{
        background: #eee;
        font-weight: bold;
        text-align: center;
        padding: 5px;
      }

      .invoice-box table.pay_heading tr td{
        text-align: center !important;
      }

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}

      .space{
        height: 3rem;
      }

      .space td{
        padding-top: 1rem !important;
      }
</style>

<div class="invoice-box">
  <table cellpadding="0" cellspacing="0">
    <tr class="top">
      <td colspan="3">
        <table>
          <tr>
            <td class="title">
              <img src="{{public_path('/img/logo.svg')}}" style="height: 4rem;" />
            </td>

            <td>
              Ref #: {{$booking->id}}<br />
              Created On: {{$booking->created_at}}<br />
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr class="space">
      <td colspan="3" style="text-align: center; font-weight: bold; font-size: 2rem;">Invoice</td>
    </tr>

    <tr class="information">
      <td colspan="3">
        <table>
          <tr>
            <td>
              {{$booking->user->name}}<br />
              {{$booking->user->organisation}}<br />
            </td>
            <td>
              Booked from : <b>{{$booking->start}}</b> <br/>
              Booked to : <b>{{$booking->end}}</b>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr class="space">
      <td colspan="3" style="text-align: center; font-weight: bold;">Booking Details</td>
    </tr>

    <tr class="heading">
      <td>Item</td>
      <td></td>
      <td>Price</td>
    </tr>

    @foreach ($booking->facilities as $item)
      <tr class="item">
        <td>{{$item->name}}</td>
        <td></td>
        <td>Rs. {{$item->pivot->amount}}</td>
      </tr>
    @endforeach

    <tr class="total">
      <td></td>
      <td>Total: </td>
      <td>Rs. {{$booking->total}}</td>
    </tr>

    @if($booking->discount>0)
      <tr class="subtotal">
        <td></td>
        <td>Discount:</td>
        <td>Rs. {{$booking->discount_amount}}</td>
      </tr>
      <tr class="subtotal">
        <td></td>
        <td>Nett Total: </td>
        <td>Rs. {{$booking->total - $booking->discount_amount}}</td>
      </tr>
    @endif

    <tr class="total">
      <td></td>
      <td>Paid: </td>
      <td>Rs. {{$booking->paid}}</td>
    </tr>

    <tr class="total">
      <td></td>
      <td>Balance: </td>
      <td>Rs. {{$booking->balance}}</td>
    </tr>

@if($booking->payments->count())

    <tr class="space">
      <td colspan="3" style="text-align: center; font-weight: bold;">Payment Details</td>
    </tr>

    <tr>
      <td colspan="3">
        <table class="pay_heading" cellpadding="0" cellspacing="0">
          <tr class="">            
            <th>#</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Transaction Charge</th>
            <th>Razorpay ID</th>
          </tr>
    
          @foreach ($booking->payments as $payment)
            <tr class="details">
              <td>KSUM/BK/{{$payment->number}}</td>
              <td>{{$payment->updated_at}}</td>
              <td>Rs. {{$payment->amount}}</td>
              <td>Rs. {{$payment->transaction}}</td>
              <td>{{$payment->razorpay_payment_id}}</td>
            </tr>
          @endforeach

        </table>
      </td>
    </tr>
@endif
    <tr>
      <td colspan="3" style="text-align:right; font-size: .75rem;">
        This is a computer generated document downloaded from facility.startupmission.in
      </td>
    </tr>

  </table>
</div>
