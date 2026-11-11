<?php
$zip1 = 'C:/Users/Ardhas-BD/.gemini/antigravity/brain/01d0a30a-9c69-4f48-86b2-0e3a86ce3a3f/.user_uploaded/media_1793697881499_0e3d7f17.pptx';
$zip2 = 'C:/Users/Ardhas-BD/.gemini/antigravity/brain/01d0a30a-9c69-4f48-86b2-0e3a86ce3a3f/.user_uploaded/media_1793697888059_ae6acdd0.pptx';

$za = new ZipArchive();
if ($za->open($zip1) === TRUE) {
    echo "=== PPTX 1 FILES ===\n";
    for ($i = 0; $i < $za->numFiles; $i++) {
        $stat = $za->statIndex($i);
        if (strpos($stat['name'], 'media') !== false || strpos($stat['name'], 'slide') !== false) {
            echo $stat['name'] . " (" . $stat['size'] . " bytes)\n";
        }
    }
    $za->extractTo('C:/Users/Ardhas-BD/.gemini/antigravity/brain/01d0a30a-9c69-4f48-86b2-0e3a86ce3a3f/pptx1');
    $za->close();
}

if ($za->open($zip2) === TRUE) {
    echo "\n=== PPTX 2 FILES ===\n";
    for ($i = 0; $i < $za->numFiles; $i++) {
        $stat = $za->statIndex($i);
        if (strpos($stat['name'], 'media') !== false || strpos($stat['name'], 'slide') !== false) {
            echo $stat['name'] . " (" . $stat['size'] . " bytes)\n";
        }
    }
    $za->extractTo('C:/Users/Ardhas-BD/.gemini/antigravity/brain/01d0a30a-9c69-4f48-86b2-0e3a86ce3a3f/pptx2');
    $za->close();
}

