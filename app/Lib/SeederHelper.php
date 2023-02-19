<?php

namespace App\Lib;

use Illuminate\Support\Facades\Artisan;

class SeederHelper {

    public static function csvSeed( string $model, string $csvPath ) {
        error_log($model." ".$csvPath);
        $csvFile = fopen($csvPath, "r");
        $firstline = true;
        $header = [];
        $columnLength = 0;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            // get header from first row in csv
            if(count($header) === 0 && $columnLength === 0) {
                $header = $data;
                $columnLength = count($data);
                continue;
            }
            $row = [];

            for($i = 0; $i < $columnLength; $i++){
                $row += [$header[$i] => $data[$i]];
            };
            
            $model::updateOrCreate($row);
        }
   
        fclose($csvFile);
    }
}