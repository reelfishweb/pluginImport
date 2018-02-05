<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImportGalery
 *
 * @author cwkadmin
 */
class ImportGalery {

    protected $idProduct;
    protected $galeryProductID = array();

    protected function getIdProduct()
    {
        return $this->idProduct;
    }

    protected function getGaleryProductID()
    {
        return $this->galeryProductID;
    }

    protected function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;
    }

    protected function setGaleryProductID($galeryProductID)
    {
        $this->galeryProductID = $galeryProductID;
    }

    /**
     * Ustawia obrazek przypisany do productu 
     */
    protected function setThumbnailProduct()
    {
        $aProductGaleryID = $this->getGaleryProductID();
        
        if (!empty($aProductGaleryID))
        {
            set_post_thumbnail($this->getIdProduct(), $aProductGaleryID[0]);
        }
    }

    /**
     * ustawia galerie productu
     */
    protected function setGaleryProduct()
    {
        $photoGaleruy = implode(',', $this->getGaleryProductID());
        update_post_meta($this->getIdProduct(), '_product_image_gallery', $photoGaleruy);
    }

    protected function checkThumbnailProduct()
    {
        $thumb = get_post_meta($this->getIdProduct(), '_thumbnail_id', true);
        if (empty($thumb))
        {
            return false;
        }
        return true;
    }

}
