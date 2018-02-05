<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Product
 *
 * @author cwkadmin
 */
interface Product {
    //put your code here    
    
    public function searchProductInXML();
    
    public function createProductFromXML($productXML);
    
    public function createProductParametry($productXML);
    
    public function changeStockProduct($productXML);
    
    public function addImageToProduct($productXML);
    
    public function updatePriceProduct($productXML);
}
