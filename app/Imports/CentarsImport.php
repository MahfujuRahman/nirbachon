<?php

namespace App\Imports;

use App\Models\Centars;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class CentarsImport implements ToModel, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Get the first column value
        $data = $row[0] ?? '';

        if (empty($data)) {
            return null;
        }

        // Parse the data - format is usually "number title, location" or just "title"
        // Split by comma to separate title from address
        $parts = explode(',', $data, 2);

        $title = trim($parts[0] ?? '');
        $address = isset($parts[1]) ? trim($parts[1]) : '';

        // Remove leading numbers and dots from title if present
        $title = preg_replace('/^[০-৯0-9]+\s*/', '', $title);

        if (empty($title)) {
            return null;
        }

        // Check if centar with this title already exists (skip duplicates)
        $exists = Centars::where('title', $title)->exists();
        if ($exists) {
            return null;
        }

        return new Centars([
            'ashon_id' => 1, // Always use ashon_id = 1
            'title' => $title,
            'address' => $address,
        ]);
    }
}
