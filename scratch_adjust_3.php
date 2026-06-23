<?php
$files = [
    'resources/views/p2kp/create.blade.php',
    'resources/views/p2kp/edit.blade.php'
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Output is usually longer (e.g. "Dokumen", "Kegiatan", "Setiap Program")
    // Target Output
    $content = preg_replace('/name="items\[(.*?)\]\[target_output\]" (.*?)class="flex-1 min-w-\[60px\] /', 'name="items[$1][target_output]" $2class="w-28 ', $content);
    // Real Output
    $content = preg_replace('/name="items\[(.*?)\]\[real_output\]" (.*?)class="flex-1 min-w-\[60px\] /', 'name="items[$1][real_output]" $2class="w-28 ', $content);

    // Satuan is usually short (e.g. "Bulan", "Hari", "Satuan")
    // Target Time Unit
    $content = preg_replace('/name="items\[(.*?)\]\[target_time_unit\]" (.*?)class="flex-1 min-w-\[60px\] /', 'name="items[$1][target_time_unit]" $2class="w-24 ', $content);
    // Real Time Unit
    $content = preg_replace('/name="items\[(.*?)\]\[real_time_unit\]" (.*?)class="flex-1 min-w-\[60px\] /', 'name="items[$1][real_time_unit]" $2class="w-24 ', $content);
    
    // Also change the header widths. Since we are using fixed widths for inputs, we should just let the table shrink wrap them!
    // But to make sure they are aligned, we can keep the columns without fixed widths.
    // Wait, let's also make sure AK uses w-16 just in case they need to type larger floats like 12.500
    $content = preg_replace('/name="items\[(.*?)\]\[credit_score\]" (.*?)class="w-12 /', 'name="items[$1][credit_score]" $2class="w-16 ', $content);
    $content = preg_replace('/name="items\[(.*?)\]\[real_credit_score\]" (.*?)class="w-12 /', 'name="items[$1][real_credit_score]" $2class="w-16 ', $content);

    file_put_contents($file, $content);
}
echo "Done.";
