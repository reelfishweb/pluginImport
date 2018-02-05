<?php

ini_set('memory_limit', '3048M');
ini_set('max_execution_time', 3600);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/wp-load.php');

function searchComand($aArgument){
    foreach($aArgument as $argument){
        $dane = explode('=', $argument);
        if($dane[0] == '--Import'){
            $parametry['Import'] = $dane[1];
        }
        if($dane[0] == '--Hurtownia'){
            $parametry['Hurtownia'] = $dane[1];
        }            
    }
    return $parametry;
}
$parametry = searchComand($argv);
$import = new ImportXMlFromHTTP($parametry['Hurtownia']);
if($parametry['Import'] == 'Category'){
    $import->importXMLCatalogList();
}

if($parametry['Import'] == 'Product'){
    $import->importXMLProductList();
}

if($parametry['Import'] == 'Price'){
    $import->importXMLProductPrice();
}


if($parametry['Import'] == 'Stock'){
    $import->importXMLStockList();
}

if($parametry['Import'] == 'Galery'){
    $import->importXMLProductGalery();
}

if($parametry['Import'] == 'clearGalery'){
    $import->clearGalery();
}

function printR($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}