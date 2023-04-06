<?php

namespace App\Lib;

class SeederHelper {

    public static function csvSeed( string $model, string $csvPath, string $uniqueColumn = null ) : void {
        error_log($model." ".$csvPath);
        $csvFile = fopen($csvPath, "r");
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

           $existingRecord = $model::where($uniqueColumn, $row[$uniqueColumn])->first();
          if ($existingRecord) {
              $existingRecord->update($row);
          } else {
              $model::create($row);
          }
        }
        fclose($csvFile);
    }
}
