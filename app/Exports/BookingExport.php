<?php

namespace App\Exports;

use App\Models\Booking;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingExport implements FromCollection, WithMapping, WithHeadings
{
    public $start, $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function headings(): array
    {
        return [
            "Location",
            "Name",
            "Organisation",
            "Start",
            "End",
            "Type",
            "Total",
            "Discount",
            "Nett Total",
            "Paid",
            "Balance"
        ];
    }

    public function map($row): array
    {
        return [
            $row->location->name,
            $row->user->name,
            $row->user->organisation,
            Carbon::parse($row->start)->toDayDateTimeString(),
            Carbon::parse($row->end)->toDayDateTimeString(),
            $row->type,
            $row->total,
            $row->discount_amount,
            $row->total - $row->discount_amount,
            $row->paid,
            $row->balance
        ];
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Booking::where(function ($query) {
            $query->where(function ($q) {
                $q->where('start', '>=', $this->start)
                  ->where('start', '<', $this->end);
            })->orWhere(function ($q) {
                $q->where('start', '<=', $this->start)
                  ->where('end', '>', $this->end);
            })->orWhere(function ($q) {
                $q->where('end', '>', $this->start)
                  ->where('end', '<=', $this->end);
            })->orWhere(function ($q) {
                $q->where('start', '>=', $this->start)
                  ->where('end', '<=', $this->end);
            });
        })
        ->where('status', '<>', 'cancelled')
        ->orderBy('start')
        ->get();
    }
}
