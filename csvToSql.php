<?php

require 'vendor/autoload.php';

use App\Importer\CategoryImporter;
use App\Importer\CityImporter;
use App\Importer\SqlFileWriter;
//use App\Exceptions\FileFormatException;
//use App\Exceptions\SourceFileException;
//use App\Exceptions\ImporterException;

$writer = new SqlFileWriter();

try {
    $categoryImporter = new CategoryImporter();
    $categorySql = $categoryImporter->import(__DIR__ . '/data/categories.csv');
    $writer->write(__DIR__ . '/ini_bd/categories.sql', $categorySql);

    $cityImporter = new CityImporter();
    $citySql = $cityImporter->import(__DIR__ . '/data/cities.csv');
    $writer->write(__DIR__ . '/ini_bd/cities.sql', $citySql);
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
