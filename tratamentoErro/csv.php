
<?php
require_once 'classes/CSVParser.php';
$csv = new CSVParser('clientes.csv', ';');
try {
$csv->parse(); // método que pode lançar exceção
while ($row = $csv->fetch()) {
print "Cliente: " . $row['Cliente'] . " - ";
print "Cidade: " . $row['Cidade'] . "<br>\n";
}
}
catch (Exception $e) {
print $e->getMessage();
}