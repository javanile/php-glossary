#!/usr/bin/env php
<?php

$defaultConfig = [
    'domain' => [
        'terms' => ''
    ],
];

$languageKeywords = [
    'default' => [
        'php', 'echo', 'default', 'true', 'false', 'function', 'return', 'foreach', 'as', 'if', 'continue', 'elseif',
        'exit', 'break', 'case', 'switch', 'while', 'do', 'for', 'try', 'catch', 'finally', 'throw', 'empty', 'isset',
        'null', 'new', 'class', 'extends', 'implements', 'interface', 'use', 'namespace', 'require', 'require_once',
    ]
];

$configFile = getcwd() . '/.glossaryrc';
$config = file_exists($configFile)
        ? parse_ini_string(preg_replace('/\s+,\s+/m', ',', file_get_contents($configFile)), true)
        : $defaultConfig;

$config['domain']['terms'] = array_map('sanitize_term', explode(',', @$config['domain']['terms']));

var_dump($config);

function sanitize_term($term)
{
    $snakeCase = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $term));
    $words = str_replace('_', ' ', $snakeCase);

    return trim($words);
}

function search_php_files($dir)
{
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
    $code = str_replace(['\\n', '\\s'], '', php_strip_whitespace($file));
    preg_match_all('/\\w+/', $code, $tokens);
    foreach ($tokens[0] as $token) {
        $term = sanitize_term($token);
        if (strlen($term) < 2) {
            continue;
        }
        if (function_exists($token)) {
            continue;
        }
        if (defined($token)) {
            continue;
        }
        if (in_array($token, $currentLanguageKeywords)) {
            continue;
        }
        if (in_array($term, $config['domain']['terms'])) {
            $domainTerms[$term]['count']++;
            continue;
        }
        echo "Problem was found: Unexpected domain term '{$token}' on file '{$file}'.\n";
        exit(1);
    }
}

foreach ($domainTerms as $term => $info) {
    if (empty($info['count'])) {
        echo "Problem was found: Domain term '{$term}' seems never used.\n";
        exit(1);
    }
}
