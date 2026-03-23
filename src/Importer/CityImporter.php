<?php

namespace App\Importer;

use App\Exceptions\FileFormatException;
use App\Exceptions\SourceFileException;

class CityImporter extends CsvImporter
{
    /**
     * @throws SourceFileException
     * @throws FileFormatException
     */
    public function import(string $filePath): array
    {
        $rows = $this->parseCsv($filePath, ['name', 'lat', 'long']);
        $sql = [];

        foreach ($rows as $row) {
            $name = $this->toSqlValue($row['name']);
            $location = "POINT({$row['long']}, {$row['lat']})";

            $sql[] = "INSERT INTO cities (name, location) VALUES ($name, $location);";
        }

        return $sql;
    }
}
