<?php
namespace App\Importer;

use App\Exceptions\ImporterException;

class SqlFileWriter
{
    /**
     * @throws ImporterException
     */
    public function write(string $filePath, array $sqlRows): void
    {
        $content = implode(PHP_EOL, $sqlRows);

        if (file_put_contents($filePath, $content) === false) {
            throw new ImporterException("Не удалось записать файл: {$filePath}");
        }
    }
}
