<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of EroplaceProductStrategy
 *
 * @author cwkadmin
 */
class EroplaceProductStrategy {
    //put your code here
    private $productList;

    public function getProductList()
    {
        return $this->productList;
    }

    public function setProductList($productList)
    {
        $this->productList = $productList;
    }

    public function addImageToProduct($productXML)
    {
        $productsXML = $productXML->products;
        $iloscProduktow = count($productsXML->product);
        $idStart = $this->setStart(get_option('Eroplace_galeryImportID'), $iloscProduktow);
        echo 'start' . $idStart . PHP_EOL;
        echo 'ilosc:' . $iloscProduktow . PHP_EOL;

        for ($i = $idStart; $i <= $iloscProduktow; $i ++)
        {
            $product = $productsXML->product[$i];
            if (empty($product))
            {
                continue;
            }
            $productAction = new ProductAction();
            $id = $productAction->sprawdzCzyProduktIsniejePoSKU((string) $product->code);
            if ($id != false)
            {
                $oUploadImage = new EroplaceGaleryStrategy($product, $id);
                $oUploadImage->convertProductToGalery();
            }
            update_option('Eroplace_galeryImportID', $i);
        }
    }

    public function changeStockProduct($productXML)
    {
        
        $productsXML = $productXML->products;
        $iloscProduktow = count($productsXML->product);
        $idStart = $this->setStart(get_option('Eroplace_StockImportID'), $iloscProduktow);
        echo 'start' . $idStart . PHP_EOL;
        echo 'ilosc:' . $iloscProduktow . PHP_EOL;

        for ($i = $idStart; $i <= $iloscProduktow; $i ++)
        {
            $product = $productsXML->product[$i];
            if (empty($product))
            {
                continue;
            }
            $productAction = new ProductAction();
            $id = $productAction->sprawdzCzyProduktIsniejePoSKU((string) $product->code);
            if ($id != false)
            {
                if ((string) $product->count == 0)
                {
                    update_post_meta($id, '_stock_status', 'outofstock');
                }
                else
                {
                    update_post_meta($id, '_stock_status', 'instock');
                }
                update_post_meta($id, '_manage_stock', 'yes');
                update_post_meta($id, '_stock', (string) $product->count);
                echo 'Zaktualizowano stan magazynowy produktu o kodzie: ' . (string) $product->code . ' stan: ' . (string) $product->count . PHP_EOL;
            }
            update_option('Eroplace_StockImportID', $i);
        }
    }

    public function createProductFromXML($productXML)
    {
        $product = new ImportProduct();
        $mainCategory = $this->zanjdzOrgIDCat( $productXML->category_id);
        $product->setIDCategory($mainCategory);
        $product->setName((string) $productXML->name);
        $product->setDescription((string) $productXML->description);
        $oParametry = $this->createProductParametry($productXML);
        $product->setParametry($oParametry);

        return $product;
    }

    private function zanjdzOrgIDCat($idOrgKay){
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}termmeta WHERE meta_key = 'idOrgKat' AND meta_value = $idOrgKay", OBJECT );
        return $results[0]->term_id;
//$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}terms WHERE term_id = '$id' ", OBJECT );
//        return $results[0]->name;
    }
    
    public function createProductParametry($productXML)
    {
        $parametry = new ImportProductParametr();
        $parametry->setCode((string) $productXML->code);
        $parametry->setShortCode((string) $productXML->ean);
        $parametry->setId((string)$productXML->attributes()->product_id);
        $parametry->setBrand((string)$productXML->producer);
        $parametry->setCena((string)$productXML->price_brutto);
        if((float)$productXML->sale_price_brutto > 0)
        {
            $parametry->setCenaWyprzedazy((float)$productXML->sale_price_brutto);
        }
        return $parametry;
    }

    public function searchProductInXML()
    {
        $xml = $this->getProductList();
        $productsXML = $xml->products;
        $iloscProduktow = count($productsXML->product);
        $idStart = $this->setStart(get_option('Eroplace_ProductImportID'), $iloscProduktow);
        echo 'start' . $idStart . PHP_EOL;
        echo 'ilosc:' . $iloscProduktow . PHP_EOL;

        for ($i = $idStart; $i <= $iloscProduktow; $i ++)
        {
            $product = $productsXML->product[$i];
            $productAction = new ProductAction();
            $id = $productAction->sprawdzCzyProduktIsniejePoSKU((string) $product->code);
            if ($id == false)
            {
                $oProduct = $this->createProductFromXML($product);
                $oProduct->addProduct();
            }
            update_option('Eroplace_ProductImportID', $i);
        }
    }

    public function updatePriceProduct($productXML)
    {
        
        $productsXML = $productXML->products;
        $iloscProduktow = count($productsXML->product);
        $idStart = $this->setStart(get_option('Eroplace_PriceImportID'), $iloscProduktow);
        echo 'start' . $idStart . PHP_EOL;
        echo 'ilosc:' . $iloscProduktow . PHP_EOL;

        for ($i = $idStart; $i <= $iloscProduktow; $i ++)
        {
            $product = $productsXML->product[$i];
            if(empty($product)){
                continue;
            }
            $productAction = new ProductAction();
            $id = $productAction->sprawdzCzyProduktIsniejePoSKU((string) $product->code);
            if ($id != false)
            {
                $cena = (string) $product->price_netto;
                $cenaMarza = number_format(str_replace($cena) * 1.37 *1.23 , 2);
                update_post_meta($id, '_price', $cenaMarza);
                update_post_meta($id, '_regular_price', $cenaMarza);
                $cenaPromo = (string) $product->sale_price_netto;
                $cenaMarzaPromo = number_format($cenaPromo * 1.37 *1.23 , 2);
                update_post_meta($id, '_sale_pric', $cenaMarzaPromo);
                echo 'Update Price product: ' . $id . ' to: ' . $cenaMarza . ' OrgCena :'.$cena. PHP_EOL;
            }
            update_option('Eroplace_PriceImportID', $i);
        }
    }

    private function setStart($idStart, $iloscProduktow)
    {
        if (empty($idStart))
        {
            return 0;
        }
        if ($idStart + 1 >= $iloscProduktow)
        {
            return 0;
        }
        return $idStart;
    }
}
