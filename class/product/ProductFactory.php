<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductFactory
 *
 * @author cwkadmin
 */
class ProductFactory {

    private $contentHttp;
    private $strategy;
    private $strategyClass;

    public function __construct($strategy = '')
    {
        $this->setStrategy($strategy);
        $this->setStrategyClass();
    }

    public function getStrategy()
    {
        return $this->strategy;
    }

    public function getStrategyClass()
    {
        return $this->strategyClass;
    }

    public function setStrategy($strategy)
    {
        $this->strategy = $strategy;
    }

    private function setStrategyClass()
    {
        $className = $this->getStrategy().'ProductStrategy';
        $this->classStarategy = new $className;
    }

    public function setContentHttp($contentHttp)
    {
        $this->contentHttp = $contentHttp;
    }

    public function getContentHttp()
    {
        return $this->contentHttp;
    }

    public function importProductList($content)
    {
        //printR($content);
        $this->setContentHttp($content);
        $this->getXMLProductList();
        $this->strategyClass->searchProductInXML();
    }

    private function getXMLProductList()
    {
        $contentFileProduct = $this->getContentHttp();
        $parserXML = new ImportProductParser($contentFileProduct);
        $parserXML->parserXMLProduct();
        $this->strategyClass->setProductList($parserXML->getXmlProduct());
    }

    public function uploadStockProduct()
    {

        $parserXML = new ImportStockParser($this->getContentHttp());
        $parserXML->parserXMLStock();
        $this->strategyClass->changeStockProduct($parserXML->getXmlStock());
    }

    public function uploadProductGalery()
    {
        $parserXML = new ImportProductParser($this->getContentHttp());
        $parserXML->parserXMLProduct();
        $this->strategyClass->addImageToProduct($parserXML->getXmlProduct());
    }

    public function updateProcuctPrice()
    {
        $parserXML = new ImportProductParser($this->getContentHttp());
        $parserXML->parserXMLProduct();
        $this->strategyClass->updatePriceProduct($parserXML->getXmlProduct());
    }

    public function clearGalery()
    {
        for ($i = 1094; $i <= 1360; $i ++)
        {
            update_post_meta($i, '_thumbnail_id', '');
            update_post_meta($i, '_product_image_gallery', '');
            echo 'Clear:' . $i . PHP_EOL;
        }
    }

}
