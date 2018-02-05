<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kategorie
 *
 * @author cwkadmin
 */
class ImportCategoryAction {

    public $idOrgKategorii;
    public $nazwa;
    public $idKategoriNadrzednej = 0;

    public function addCategory()
    {
        $term = term_exists($this->nazwa);
        if ($term === 0 or $term === null)
        {
            $newTerm = wp_insert_term(stripslashes($this->nazwa), 'product_cat');
            if (is_wp_error($newTerm))
            {
                echo $newTerm->get_error_message() . ': ' . $this->nazwa . PHP_EOL;
                return;
            }
            if(!empty($this->getIdOrgKategorii())){
                add_term_meta($newTerm['term_id'], 'idOrgKat', $this->idOrgKategorii);
            }
            echo 'Dadno kategorie: ' . $this->nazwa . PHP_EOL;
            return $newTerm['term_id'];
        }
        return $term;
    }

    public function addSubCategory()
    {
        $term = term_exists($this->nazwa);
        if ($term === 0 or $term === null)
        {
            $idOrgKay = $this->ustalIDRodzica($this->idKategoriNadrzednej);
            $newTerm = wp_insert_term($this->nazwa, 'product_cat', array('parent' => $idOrgKay));
            if(is_wp_error($newTerm)){
                echo $newTerm->get_error_message() . ': ' . $this->nazwa . PHP_EOL;
                return;
            }
            if(!empty($this->getIdOrgKategorii())){
                add_term_meta($newTerm['term_id'], 'idOrgKat', $this->idOrgKategorii);
            }
            echo 'Dodano sub kategorie: ' . $this->nazwa . PHP_EOL;
            return $newTerm['term_id'];
        }
        return $term;
    }
    
    private function ustalIDRodzica($idOrgKay){
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}termmeta WHERE meta_key = 'idOrgKat' AND meta_value = $idOrgKay", OBJECT );

        return $results[0]->term_id;
    }
    

    function getIdOrgKategorii()
    {
        return $this->idOrgKategorii;
    }

    function getNazwa()
    {
        return $this->nazwa;
    }

    function getIdKategoriNadrzednej()
    {
        return $this->idKategoriNadrzednej;
    }

    function setIdOrgKategorii($idOrgKategorii)
    {
        $this->idOrgKategorii = $idOrgKategorii;
    }

    function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;
    }

    function setIdKategoriNadrzednej($idKategoriNadrzednej)
    {
        $this->idKategoriNadrzednej = $idKategoriNadrzednej;
    }

}
