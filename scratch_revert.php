<?php
$files = [
    'resources/views/p2kp/create.blade.php',
    'resources/views/p2kp/edit.blade.php'
];

$thead = <<<EOT
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th rowspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-24">AK</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300">Kuantitas</th>
                            <th rowspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-32">Output</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300">Kualitas/Mutu</th>
                            <th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300">Waktu</th>
                            <th rowspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-32">Satuan</th>
                            <th rowspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-16">Aksi</th>
                        </tr>
                        <tr>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 w-20">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 w-20">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 w-20">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 w-20">Realisasi</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 w-20">Target</th>
                            <th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 w-20">Realisasi</th>
                        </tr>
                    </thead>
EOT;

$headerPattern = '/\s*<tr class="bg-slate-100 text-slate-700">\s*<th rowspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-24">AK<\/th>.*?<\/tr>\s*<tr class="bg-slate-100 text-slate-700">\s*<th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 w-20">Target<\/th>.*?<\/tr>/s';

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Remove the repeating headers from tbody (both in blade and JS strings)
    $content = preg_replace($headerPattern, '', $content);
    
    // Inject global thead back after <table ...>
    $content = preg_replace('/<table class="min-w-full border-collapse border border-slate-200" id="(.*?)-table">/', '$0' . "\n" . $thead, $content);
    
    file_put_contents($file, $content);
}
echo "Done.";
