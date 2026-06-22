<?php
require 'vendor/autoload.php';

$parser = new \Smalot\PdfParser\Parser();
$pdf    = $parser->parseFile('backup_files/LKD - 0231108302 TA 2025_2026 Ganjil.pdf');

$text = $pdf->getText();
echo substr($text, 0, 5000);
