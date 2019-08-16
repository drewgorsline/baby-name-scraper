<?php

function first_name_scrape($html):array {
    libxml_use_internal_errors(true);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = false;
    $dom->loadHTML($html);
    $xpath = new DomXPath($dom);
    $query = "//ul/li//a[@class='F' or @class='M']";
    $firstLines = $xpath->query($query);

    $returnArray = [];

    foreach($firstLines as $node) {
        $returnArray[] = $node->nodeValue;
    }

    return $returnArray;
}

$alphabetString = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

$randomNumber = rand(0,25); // this is always null
$findRandomInString = substr($alphabetString, $randomNumber, 1); // always A because above line is WACK YO
$html = file_get_contents("http://www.babynames.com/Names/".$findRandomInString);
$firstNamesArray = first_name_scrape($html);

$hostname='localhost';
$username='root';
$password='assword';

$conn = new PDO("mysql:host=$hostname;dbname=wp_oakland",$username,$password);

foreach($firstNamesArray as $firstName) {
    $stmt = $conn->prepare("insert into names (names) values (?)");
    $stmt->bindParam(1, $firstName);
    $stmt->execute();
}









