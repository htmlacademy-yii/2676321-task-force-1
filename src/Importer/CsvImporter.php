<?php

namespace App\Importer;

use SplFileObject;
use App\Exceptions\SourceFileException;
use App\Exceptions\FileFormatException;

abstract class CsvImporter
{
    /**
     * @throws SourceFileException
     * @throws FileFormatException
     */
    protected function parseCsv(string $filePath, array $sqlColumns): array
    {
        if (!file_exists($filePath)) {
            throw new SourceFileException("Файл не существует: {$filePath}");
        }

        $file = new SplFileObject($filePath);
        $file->setFlags(SplFileObject::READ_CSV);
        $file->setCsvControl(',', '"', '\\');

        $file->rewind();

        $header = $file->fgetcsv(',', '"', '\\');

        if ($header === false) {
            throw new FileFormatException("Файл пустой");
        }

        $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);
        $header = array_map('trim', $header);

        if ($header !== $sqlColumns) {
            throw new FileFormatException("Неверный формат файла");
        }

        $rows = [];

        foreach ($file as $row) {
            if (empty($row) || $row[0] === null) {
                continue;
            }

            $rows[] = array_combine($header, $row);
        }

        return $rows;
    }

    protected function toSqlValue(?string $value): string
    {
        if ($value === null || $value === '') {
            return 'NULL';
        }

        return "'" . addslashes($value) . "'";
    }
}
