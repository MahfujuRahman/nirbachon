<?php

namespace App\Imports;

use App\Models\Centars;
use Maatwebsite\Excel\Concerns\ToModel;

class CentarsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Centars([
            'ashon_id' => $row[0] ?? 1,
            'title' => $row[1] ?? '',
            'address' => $row[2] ?? '',
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
