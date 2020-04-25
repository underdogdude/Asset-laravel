<?php

namespace App\Imports;

use App\Asset;
use App\AssetTable;
use Maatwebsite\Excel\Concerns\ToModel;


class AssetImportExcel implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if(!array_filter($row)) {
            return null;
        } 
        return new AssetTable([
            'inv_number' => $row[0],
            'erp_number' => $row[1],
            'description1' => $row[2],
            'description2' => $row[3],
            'code' => $row[4],
            'price' => $row[5],
            'location' => $row[6],
            'room' => $row[7],
            'year' => $row[8],
            'user_manage' => $row[9]
        ]);
    }
}
