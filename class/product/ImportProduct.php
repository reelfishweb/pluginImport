<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of ImportProduct
 *
 * @author cwkadmin
 */
class ImportProduct {
    
    private $name;
    
    private $description;
    
    private $category;
    
    /**
     *
     * @var ImportProductParametr
     */
    private $parametry;
    
    public function setCategory($mainCategory, $category) {
        if(empty($category)){
            $this->category = (string)$mainCategory;
            return;
        }
        $this->category = (string)$category;
    }
    
    public function setIDCategory($idCategory){
        $this->category = (int)$idCategory;
    }
    
    public function getParametry() {
        return $this->parametry;
    }

    public function setParametry($parametry) {
        $this->parametry = $parametry;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getProduct() {
        return $this->product;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function addProduct() {
        $post_id = wp_insert_post(array(
            'post_author' => 1,
            'post_title' => $this->getName(),
            'post_content' => $this->getDescription(),
            'post_status' => 'publish',
            'post_type' => "product",
        ));
        wp_set_object_terms($post_id, $this->getCategory(), 'product_cat');
        $this->getParametry()->addProductParametry($post_id);
        echo 'Dodano: ' . $this->getName() . ' do kategori ' . $this->getCategory() . PHP_EOL;
    }

}
