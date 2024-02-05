<?php

namespace App\Imports;

use App\Models\Dossier;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class DossierImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use Importable;
    public function model(array $row)
    {

        $d = Dossier::updateOrCreate(
            ['dossiernummer' => $row['nummer']],
            [
                'dossiernummer' => $row['nummer'],
                'datum' => $row['datum_creatie'],
                'nummerplaat' => $row['nummerplaat'],
                'merk_id' => $row['merk_id'] ?? $row['merk_id'] ?? 0,
                'model' => $row['model'],
                'maatschappij_id' => ($row['maatschappij_id'] ?? $row['maatschappij_id'] ?? null),
                'makelaar_id' => ($row['makelaar_id'] ?? $row['makelaar_id'] ?? null),
                'maatschappij' => ($row['maatschappij'] ?? $row['maatschappij'] ?? null),
                'merk' => $row['merk'],
                'makelaar' => $row['makelaar'],
                'facturen' => $row['facturen'],
                'opmerkingen' => $row['opmerkingen'],
            ]
        );


        return $d;
    }
}
