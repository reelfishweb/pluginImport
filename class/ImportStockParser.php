<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImportStockParser
 *
 * @author cwkadmin
 */
class ImportStockParser {
    
    private $fileContent;
    private $xmlStock;

    public function __construct($fileContent) {
        $this->fileContent = $fileContent;
    }

    public function getFileContent() {
        return $this->fileContent;
    }
    
    public function getXmlStock() {
        return $this->xmlStock;
    }

    
    public function setFileContent($fileContent) {
        $this->fileContent = $fileContent;
    }
    
    public function setXmlStock($xmlProduct) {
        $this->xmlStock = $xmlProduct;
    }

    public function parserXMLStock() {
        $xmlProduct = new SimpleXMLElement($this->getFileContent());
        $this->setXmlStock($xmlProduct);
    }
    
}
