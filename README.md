# php_parser

Execution


```shell
<?php

include 'parser.php';


$parser = new TobinParser\Parser();
$parser->parse("log.txt");
$host = $parser->getParameter("host");
