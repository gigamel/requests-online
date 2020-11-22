<?php
require '../autoload.php';

\ASh::createApplication()
    ->loadSettings('pdo')
    ->run();
