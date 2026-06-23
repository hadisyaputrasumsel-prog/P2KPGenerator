<?php
$files = [
    'resources/views/p2kp/create.blade.php',
    'resources/views/p2kp/edit.blade.php'
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Change w-12 to w-16 for all Qty, Quality, Time inputs
    // Target Qty
    $content = preg_replace('/name="items\[(.*?)\]\[target_qty\]" (.*?)class="w-12 /', 'name="items[$1][target_qty]" $2class="w-16 ', $content);
    // Real Qty
    $content = preg_replace('/name="items\[(.*?)\]\[real_qty\]" (.*?)class="w-12 /', 'name="items[$1][real_qty]" $2class="w-16 ', $content);
    
    // Target Quality
    $content = preg_replace('/name="items\[(.*?)\]\[target_quality\]" (.*?)class="w-12 /', 'name="items[$1][target_quality]" $2class="w-16 ', $content);
    // Real Quality
    $content = preg_replace('/name="items\[(.*?)\]\[real_quality\]" (.*?)class="w-12 /', 'name="items[$1][real_quality]" $2class="w-16 ', $content);

    // Target Time
    $content = preg_replace('/name="items\[(.*?)\]\[target_time\]" (.*?)class="w-12 /', 'name="items[$1][target_time]" $2class="w-16 ', $content);
    // Real Time
    $content = preg_replace('/name="items\[(.*?)\]\[real_time\]" (.*?)class="w-12 /', 'name="items[$1][real_time]" $2class="w-16 ', $content);

    // Make sure AK is w-16
    $content = preg_replace('/name="items\[(.*?)\]\[credit_score\]" (.*?)class="w-12 /', 'name="items[$1][credit_score]" $2class="w-16 ', $content);
    $content = preg_replace('/name="items\[(.*?)\]\[real_credit_score\]" (.*?)class="w-12 /', 'name="items[$1][real_credit_score]" $2class="w-16 ', $content);


    file_put_contents($file, $content);
}
echo "Done.";
