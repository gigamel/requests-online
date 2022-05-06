<?php

require_once __DIR__ . '/../autoload.php';

\ASh::createApplication()
    ->loadSettings('pdo')
    ->run();
