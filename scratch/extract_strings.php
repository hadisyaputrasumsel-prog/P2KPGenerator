<?php
$content = file_get_contents($argv[1]);
preg_match_all('/[\x20-\x7E]{4,}/', $content, $matches);
foreach ($matches[0] as $match) {
    echo $match . "\n";
}
