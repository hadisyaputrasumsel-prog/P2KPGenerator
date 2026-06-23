<?php
$files = [
    'resources/views/p2kp/create.blade.php',
    'resources/views/p2kp/edit.blade.php'
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Adjust top header widths
    $content = str_replace(
        '<th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300">AK</th>',
        '<th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-[10%]">AK</th>',
        $content
    );
    $content = str_replace(
        '<th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300">Kuantitas & Output</th>',
        '<th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-[35%]">Kuantitas & Output</th>',
        $content
    );
    $content = str_replace(
        '<th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300">Kualitas/Mutu</th>',
        '<th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-[15%]">Kualitas/Mutu</th>',
        $content
    );
    $content = str_replace(
        '<th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300">Waktu & Satuan</th>',
        '<th colspan="2" class="px-2 py-2 text-center text-xs font-semibold uppercase border border-slate-300 w-[35%]">Waktu & Satuan</th>',
        $content
    );
    
    // Remove fixed widths from bottom header
    $content = preg_replace(
        '/<th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300 w-24(.*?)">/',
        '<th class="px-2 py-1 text-center text-xs font-semibold uppercase border border-slate-300$1">',
        $content
    );

    // Make number inputs in Kuantitas and Waktu a bit wider so spin buttons don't overlap the numbers.
    // Replace w-12 with w-16
    $content = str_replace('class="w-12 ', 'class="w-16 ', $content);
    
    // Optional: for Kualitas, make sure the number input text is fully visible by giving more padding/space?
    // Actually w-[15%] on the top header will make the Kualitas columns 7.5% each. On a 1200px screen, 7.5% is 90px.
    // 90px is enough for a number input. 
    // To prevent text cutoff, let's remove px-1 from number inputs and just let them behave normally, or keep px-1 but ensure text-center.
    // Actually, w-16 is 64px, which is decent. Let's make it w-20 (80px) for AK if possible? No, flex-1 will handle it.

    file_put_contents($file, $content);
}
echo "Done.";
