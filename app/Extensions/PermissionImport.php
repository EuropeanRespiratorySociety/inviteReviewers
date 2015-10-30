<?php

namespace App\Extensions;


class PermissionImport extends \Maatwebsite\Excel\Files\ExcelFile {

    public function getFile()
    {
        return storage_path('files') . '/permissions.xlsx';
    }

    public function getFilters()
    {
//add filters
    }

}