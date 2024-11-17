<?php


function generateFileMap($directory = 'comp') {
    $fileMap = [];
    $files = glob($directory . '/*.php');

    foreach ($files as $file) {
        $filename = basename($file);
        $symbolicCharacter = strtolower(substr($filename, 0, 1));
        $title = ucwords(str_replace('_', ' ', pathinfo($filename, PATHINFO_FILENAME)));

        // Check if the symbolic character is already in use
        if (isset($fileMap[$symbolicCharacter])) {
            // Find the next available character
            $symbolicCharacter = getNextAvailableCharacter($fileMap);
        }

        $fileMap[$symbolicCharacter] = [
            'path' => $file,
            'title' => $title
        ];
    }

    return $fileMap;
}

function getNextAvailableCharacter($fileMap) {
    $alphabet = range('a', 'z');
    foreach ($alphabet as $char) {
        if (!isset($fileMap[$char])) {
            return $char;
        }
    }
    // If all letters are used, start using numbers
    for ($i = 0; $i < 10; $i++) {
        if (!isset($fileMap[$i])) {
            return (string)$i;
        }
    }
    // If all options are exhausted, return a random string
    return substr(md5(rand()), 0, 1);
}

return generateFileMap();
?>