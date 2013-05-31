<?php
if(!session_id())
session_start();

$xml = simplexml_load_file(CRITERIA_PATH_RELATIVE."persist.xml");
$persistenceUnit = (String) $xml->persistence_unit->attributes()->name;
$persistence["persistenceUnit"] = $persistenceUnit;
foreach ($xml->persistence_unit->properties->property as $key => $property) {
    $atributes = $property->attributes();
    $pName = (string) $atributes->name;
    $pValue = (string) $atributes->value;
    $persistence["properties"][$pName] = $pValue;
}
$_SESSION["persistence"] = $persistence;
?>
