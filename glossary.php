#!/usr/bin/env php
<?php

$defaultConfig = [
    'domain' => [
        'terms' => ''
    ],
];

$languageKeywords = [
    'default' => ['php', 'echo']
];

$command = strtolower(trim(@$argv[1]));
$configFile = getcwd() . '/.glossaryrc';
$config = file_exists($configFile)
        ? parse_ini_string(preg_replace('/,\s+/m', ',', file_get_contents($configFile)), true)
        : $defaultConfig;

$config['domain']['terms'] = explode(',', @$config['domain']['terms']);

function search_php_files($dir) {
    $result = [];
    foreach (scandir($dir) as $filename) {
        if ($filename[0] === '.') continue;
        $filePath = $dir . '/' . $filename;
        if (is_dir($filePath)) {
            $result = array_merge($result, search_php_files($filePath));
        } elseif (pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
            $result[] = $filePath;
        }
    }
    return $result;
}

$domainTerms = [];
foreach ($config['domain']['terms'] as $term) {
    $domainTerms[$term] = [
        'count' => 0,
        'files' => []
    ];
}

$currentLanguageKeywords = $languageKeywords['default'];

foreach (search_php_files('.') as $file) {
    $code = str_replace(['\\n'], '', php_strip_whitespace($file));
    preg_match_all('/\\w+/', $code, $tokens);
    foreach ($tokens[0] as $token) {
        if (in_array($token, $currentLanguageKeywords)) {
            continue;
        }
        if (in_array($token, $config['domain']['terms'])) {
            $domainTerms[$token]['count']++;
            continue;
        }
        echo "Problem was found: Unexpected domain term '{$token}'.\n";
        exit(1);
    }
}

foreach ($domainTerms as $term => $info) {
    if (empty($info['count'])) {
        echo "Problem was found: Domain term '{$term}' seems never used.\n";
        exit(1);
    }
}
