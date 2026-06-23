<?php
$files = [
    'resources/views/p2kp/create.blade.php',
    'resources/views/p2kp/edit.blade.php'
];

$styleBlock = <<<EOT
@push('styles')
<style>
    /* Sembunyikan panah atas/bawah pada input number agar hemat ruang */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush
EOT;

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Inject style block if not present
    if (strpos($content, 'input[type=number]::-webkit-inner-spin-button') === false) {
        $content = str_replace('<x-app-layout>', "<x-app-layout>\n" . $styleBlock, $content);
    }
    
    // Remove the w-[%] from top headers to let it auto-size
    $content = preg_replace('/w-\[10%\]|w-\[35%\]|w-\[15%\]/', '', $content);
    
    // For AK: change w-full to w-12
    $content = preg_replace('/name="items\[(.*?)\]\[credit_score\]" (.*?)class="w-full /', 'name="items[$1][credit_score]" $2class="w-12 ', $content);
    $content = preg_replace('/name="items\[(.*?)\]\[real_credit_score\]" (.*?)class="w-full /', 'name="items[$1][real_credit_score]" $2class="w-12 ', $content);
    
    // For Kualitas: change w-full to w-12
    $content = preg_replace('/name="items\[(.*?)\]\[target_quality\]" (.*?)class="w-full /', 'name="items[$1][target_quality]" $2class="w-12 ', $content);
    $content = preg_replace('/name="items\[(.*?)\]\[real_quality\]" (.*?)class="w-full /', 'name="items[$1][real_quality]" $2class="w-12 ', $content);
    
    // For Kuantitas Qty: change w-16 to w-10 or w-12
    $content = preg_replace('/name="items\[(.*?)\]\[target_qty\]" (.*?)class="w-16 /', 'name="items[$1][target_qty]" $2class="w-12 ', $content);
    $content = preg_replace('/name="items\[(.*?)\]\[real_qty\]" (.*?)class="w-16 /', 'name="items[$1][real_qty]" $2class="w-12 ', $content);

    // For Waktu Qty: change w-16 to w-12
    $content = preg_replace('/name="items\[(.*?)\]\[target_time\]" (.*?)class="w-16 /', 'name="items[$1][target_time]" $2class="w-12 ', $content);
    $content = preg_replace('/name="items\[(.*?)\]\[real_time\]" (.*?)class="w-16 /', 'name="items[$1][real_time]" $2class="w-12 ', $content);

    // For Output and Satuan text inputs, ensure they have min-w so they don't crush too much, but allow them to shrink if needed
    // They currently have `flex-1`. Let's add `min-w-[60px]`.
    $content = str_replace('class="flex-1 border-slate-300', 'class="flex-1 min-w-[60px] border-slate-300', $content);
    // Remove duplicates if any
    $content = str_replace('min-w-[60px] min-w-[60px]', 'min-w-[60px]', $content);

    file_put_contents($file, $content);
}
echo "Done.";
