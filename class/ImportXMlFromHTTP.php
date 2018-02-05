<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImportXMlFromHTTP
 *
 * @author cwkadmin
 */
class ImportXMlFromHTTP {
    
    public $strategy;
    
    public $classStarategy;

    public function __construct($strategy = '') {
        $this->setStrategy($strategy);
        $this->setClassStrategy();
    }

    
    public function getStrategy() {
        return $this->strategy;
    }

    public function setStrategy($strategy) {
        $this->strategy = $strategy;
    }
    
    private function setClassStrategy() {
        $className = $this->getStrategy().'BaseStrategy';
        $this->classStarategy = new $className;
    }
    
    /**
     * 
     */
    public function activation_plugin() {
        if (!self::checkWoocommerce()) {
            deactivate_plugins(ImportXMLfromHTTP__PLUGIN);
            add_action('admin_notices', array('ImportXMlFromHTTP', 'showErrorWOOInstall'));
        }
    }

    /**
     * 
     * @return boolean
     */
    private function checkWoocommerce() {
        if (is_plugin_active('woocommerce/woocommerce.php')) {
            return false;
        }
        return FALSE;
    }

    /**
     * 
     * @param type $message
     */
    public function showErrorWOOInstall() {
        ?>
        <div class="notice notice-error">
            <p>Woocommerce is not installed"</p>
        </div>
        <?php
    }

    public function importXMLCatalogList() {
        $category = $this->classStarategy->getCatalogContent();
        
        $categoryFactory = new CategoryFactory($this->getStrategy());
        $categoryFactory->addCategoryWithXML($category);
        
    }

    public function importXMLProductList() {
        
        $products = $this->classStarategy->getProductContent();
        $productFactory = new ProductFactory($this->getStrategy());
        $productFactory->importProductList($products);
    }

    public function importXMLStockList() {
        
        $stock = $this->classStarategy->getStockContent();

        $productFactory = new ProductFactory($this->getStrategy());
        $productFactory->setContentHttp($stock);
        $productFactory->uploadStockProduct();
    }

    public function importXMLProductGalery() {
        
        $products = $this->classStarategy->getProductContent();

        $productFactory = new ProductFactory($this->getStrategy());
        $productFactory->setContentHttp($products);
        unset($products);
        $productFactory->uploadProductGalery();
    }
    
    public function clearGalery(){
        $productFactory = new ProductFactory();
        $productFactory->clearGalery();
        
    }
    
    public function importXMLProductPrice(){
        $price = $this->classStarategy->getPricaContent();
        $productFactory = new ProductFactory($this->strategy);
        $productFactory->setContentHttp($price);
        $productFactory->updateProcuctPrice();
        
    }

}
