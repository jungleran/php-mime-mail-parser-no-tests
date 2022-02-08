<?php

use PhpMimeMailParser\Parser;

require_once __DIR__.'/vendor/autoload.php';


$parser = Parser::fromPath(__DIR__.'/tests/mails/1554aa6f5ceb79b9-Thank you for your application to the University of Winchester.eml');
