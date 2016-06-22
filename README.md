# php_parser

Execution


```shell
<?php

include 'parser.php';


$parser = new TobinParser\Parser();
$parser->parse("file.config");
$host = $parser->getParameter("host");
