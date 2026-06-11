<?php
$brainDir = 'C:/Users/Wilson Tjokro/.gemini/antigravity/brain/6d5ee492-a485-417f-9cb3-fbed3df4024e/';
$targetDir = __DIR__ . '/storage/app/public/products/';

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

copy($brainDir . 'croissant_seed_1779037877183.png', $targetDir . 'croissant.png');
copy($brainDir . 'chocolate_bun_seed_1779037893324.png', $targetDir . 'chocolate_bun.png');
copy($brainDir . 'strawberry_tart_seed_1779037911524.png', $targetDir . 'strawberry_tart.png');
copy($brainDir . 'sourdough_loaf_seed_1779037926522.png', $targetDir . 'sourdough_loaf.png');

echo "Images copied successfully.\n";
