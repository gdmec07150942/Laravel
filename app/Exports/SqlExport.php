<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class SqlExport implements FromCollection
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = collect($data);
    }

    public function collection()
    {
        return $this->data;
    }
}
