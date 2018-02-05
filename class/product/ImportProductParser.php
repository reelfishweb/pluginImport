<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImportProductParser
 *
 * @author cwkadmin
 */
class ImportProductParser {
    public $contentXML;
    
    private $xmlProduct;
    
    public function __construct($fileContent) {
        $this->setFileContent($fileContent);
    }

    public function getFileContent() {
        return $this->fileContent;
    }
    
    public function getXmlProduct() {
        return $this->xmlProduct;
    }
    
    public function setFileContent($fileContent) {
        $this->fileContent = $fileContent;
    }
    
    public function setXmlProduct($xmlProduct) {
        $this->xmlProduct = $xmlProduct;
    }

    public function parserXMLProduct() {
        $xmlProduct = new SimpleXMLElement($this->getFileContent());
        $this->setXmlProduct($xmlProduct);
    }
}
