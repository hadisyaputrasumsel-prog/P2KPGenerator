<?php
require __DIR__.'/vendor/autoload.php';

$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile(__DIR__.'/backup_files/LKD - 0231108302 TA 2025_2026 Ganjil.pdf');

$text = $pdf->getText();

// print the first 2000 chars to see the structure
echo substr($text, 0, 2000);
