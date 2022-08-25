<?php

namespace App\Exports;

use App\Models\History;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class HistoryExport implements FromCollection,WithHeadings ,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return History::all();
    }
    public function headings(): array
    {
        return [
            'name',
            'download_date'
        ];
    }
    public function map($transaction): array
    {
        return [
            $transaction->name,
            $transaction->download_date,
        ];
    }
}
