<?php

namespace App\Exports;

use App\Models\Optout;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class OptoutExport implements FromCollection,WithHeadings ,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function collection()
    {
        return Optout::all();
    }
    public function headings(): array
    {
        return [
            'ufax',
            'uphone',
            'ip_address'
        ];
    }
    public function map($transaction): array
    {
        return [
            $transaction->ufax,
            $transaction->uphone,
            $transaction->ip_address
        ];
    }
}
