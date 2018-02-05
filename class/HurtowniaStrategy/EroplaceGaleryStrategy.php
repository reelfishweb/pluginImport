<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 * Description of EroplaceGaleryStrategy
 *
 * @author cwkadmin
 */
class EroplaceGaleryStrategy extends ImportGalery implements Galery {
    
    private $galeryImageList = array();
    private $product;


    public function __construct($product, $idProduct)
    {
        $this->setProduct($product);
        $this->setIdProduct($idProduct);
    }


    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product)
    {
        $this->product = $product;
    }

    public function getGaleryImageList()
    {
        return $this->galeryImageList;
    }

    public function setGaleryImageList($galeryImageList)
    {
        $this->galeryImageList[] = $galeryImageList;
    }

    public function getContentFile($fileName)
    {
        $image = file_get_contents($fileName);

        return $image;
    }

    public function convertProductToGalery()
    {
        if ($this->checkThumbnailProduct() == true)
        {
            return;
        }
        $oImpoertFile = new ImportFileUpload($this);
        $this->listImageWithProduct();
        $oImpoertFile->setGaleryPhoto($this->getGaleryImageList());
        $oImpoertFile->uploadFile();
        $this->setGaleryProductID($oImpoertFile->getGaleryPhotoID());
        $this->setThumbnailProduct();
        $this->setGaleryProduct();
        echo 'Do Productku: ' . $this->getIdProduct() . PHP_EOL;
    }

    /**
     * Z productu Tworzymy liste obrazów galerii
     */
    private function listImageWithProduct()
    {
        foreach ($this->getProduct()->photos as $images)
        {
            if(!empty((string)$images->photo[0])){
                $this->setGaleryImageList((string)$images->photo[0]);
            }
            if(!empty((string)$images->photo[1])){
                $this->setGaleryImageList((string)$images->photo[1]);
            }
            if(!empty((string)$images->photo[2])){
                $this->setGaleryImageList((string)$images->photo[2]);
            }
        }
    }
}
