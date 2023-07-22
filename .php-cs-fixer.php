<?php

if (!file_exists(__DIR__.'/src')) {
    exit(0);
}

$finder = PhpCsFixer\Finder::create()
    ->exclude('documentation')
    ->exclude('vendor')
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
])->setFinder($finder);
