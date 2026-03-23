<?php

namespace App\Importer;

use App\Exceptions\FileFormatException;
use App\Exceptions\SourceFileException;

class CategoryImporter extends CsvImporter
{
    /**
     * @throws SourceFileException
     * @throws FileFormatException
     */
    public function import(string $filePath): array
    {
        $sqlRows = [];
        $rows = $this->parseCsv($filePath, ['name', 'icon']);

        foreach ($rows as $row) {
            $name = $this->toSqlValue($row['name']);
            $icon = $this->toSqlValue($row['icon']);

            $sqlRows[] = "INSERT INTO categories (name, icon) VALUES ($name, $icon);";
        }

        return $sqlRows;
    }
}
