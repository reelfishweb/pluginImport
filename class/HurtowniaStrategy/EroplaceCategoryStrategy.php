<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EroplaceCategoryStrategy
 *
 * @author cwkadmin
 */

class EroplaceCategoryStrategy extends ImportCategory implements Category {
    
    public function convertXMLtoData()
    {
        $xmlParser = new SimpleXMLElement($this->getContentXML());
        $categorys = $xmlParser->categories;
        $categoryList = $categorys->category;
        foreach ($categoryList as $category)
        {
            $import = '';
            $import = new ImportCategoryAction();
            $import->setNazwa((string)$category->name);
            $import->setIdOrgKategorii((int)$category->attributes()->category_id);
            $import->setIdKategoriNadrzednej((int)$category->attributes()->parent);
            if($import->idKategoriNadrzednej == 0){
                $import->addCategory();
                continue;
            }
            
        }
        foreach ($categoryList as $category)
        {
            $import = '';
            $import = new ImportCategoryAction();
            $import->setNazwa((string)$category->name);
            $import->setIdOrgKategorii((int)$category->attributes()->category_id);
            $import->setIdKategoriNadrzednej((int)$category->attributes()->parent);
            if($import->idKategoriNadrzednej != 0){
                $import->addSubCategory();
                continue;
            }
            
        }
    }
}
