<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImportCategory
 *
 * @author cwkadmin
 */
class ImportCategory {
    
    private $contentXML;
    private $category;
    
    public function getContentXML() {
        return $this->contentXML;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setContentXML($contentXML) {
        $this->contentXML = $contentXML;
    }

    public function setCategory($category) {
        $this->category = $category;
    }
    
    protected function addSubCategory($idMainCategory, $subCategory, $orgIdCategory = 0){
        
        $import = new ImportCategoryAction();
        $import->setNazwa($subCategory);
        $import->setIdKategoriNadrzednej($idMainCategory);
        if(isset($orgIdCategory)){
            $import->setIdOrgKategorii($orgIdCategory);
        }
        $import->addSubCategory();
    }
}
