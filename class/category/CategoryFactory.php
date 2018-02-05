<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryFactory
 *
 * @author cwkadmin
 */
class CategoryFactory {
    
    private $strategy;
    
    /**
     *
     * @var PFCategoryStrategy
     */
    private $strategyClass;
    
    public function __construct($strategy = '') {
        $this->strategy = $strategy;
        $this->setStrategyClass();
    }
    
    public function getStrategy() {
        return $this->strategy;
    }

    public function setStrategy($strategy) {
        $this->strategy = $strategy;
    }
    
    private function setStrategyClass(){
        $className = $this->getStrategy().'CategoryStrategy';
        $this->classStarategy = new $className;        
    }

    public function addCategoryWithXML($contentXML){
        $this->strategyClass->setContentXML($contentXML);
        $this->strategyClass->convertXMLtoData();
    }


}
