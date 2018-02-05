<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImportProductParametr4
 *
 * @author cwkadmin
 */
class ImportProductParametr {

    private $cena;
    private $cenaWyprzedazy;
    private $code;
    private $shortCode;
    private $id;
    private $color;
    private $country;
    //marka
    private $brand;
    private $wymiar;
    private $wysokosc;
    private $szerokosc;
    private $grubosc;
    private $waga;
    private $iloscDuzaPaczka;
    private $iloscMalaPaczka;
    private $markgroups;
    private $rodzajPaczki;
    private $material;
    private $packages;
    private $parametryDodatkowe = array();

    public function getCena() {
        return $this->cena;
    }

    public function getCenaWyprzedazy() {
        return $this->cenaWyprzedazy;
    }
    
    public function getParametryDodatkowe() {
        return $this->parametryDodatkowe;
    }

    public function getCode() {
        return $this->code;
    }

    public function getShortCode() {
        return $this->shortCode;
    }

    public function getId() {
        return $this->id;
    }

    public function getColor() {
        return $this->color;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getBrand() {
        return $this->brand;
    }

    public function getWymiar() {
        return $this->wymiar;
    }

    public function getWysokosc() {
        return $this->wysokosc;
    }

    public function getSzerokosc() {
        return $this->szerokosc;
    }

    public function getGrubosc() {
        return $this->grubosc;
    }

    public function getWaga() {
        return $this->waga;
    }

    public function getIloscDuzaPaczka() {
        return $this->iloscDuzaPaczka;
    }

    public function getIloscMalaPaczka() {
        return $this->iloscMalaPaczka;
    }

    public function getMarkgroups() {
        return $this->markgroups;
    }

    public function getRodzajPaczki() {
        return $this->rodzajPaczki;
    }

    public function getMaterial() {
        return $this->material;
    }

    public function getPackages() {
        return $this->packages;
    }

    public function setCena($cena) {
        $this->cena = $cena;
    }

    public function setCenaWyprzedazy($cena_wyprzedazy) {
        $this->cenaWyprzedazy = $cena_wyprzedazy;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function setShortCode($shortCode) {
        $this->shortCode = $shortCode;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function setBrand($brand) {
        $this->brand = $brand;
    }

    public function setWymiar($wymiar) {
        $this->wymiar = $wymiar;
    }

    public function setWysokosc($wysokosc) {
        $this->wysokosc = $wysokosc;
    }

    public function setSzerokosc($szerokosc) {
        $this->szerokosc = $szerokosc;
    }

    public function setGrubosc($grubosc) {
        $this->grubosc = $grubosc;
    }

    public function setWaga($waga) {
        $this->waga = $waga;
    }

    public function setIloscDuzaPaczka($iloscDuzaPaczka) {
        $this->iloscDuzaPaczka = $iloscDuzaPaczka;
    }

    public function setIloscMalaPaczka($iloscMalaPaczka) {
        $this->iloscMalaPaczka = $iloscMalaPaczka;
    }

    public function setMarkgroups($markgroups) {
        if (empty($markgroups)) {
            return;
        }
        $marki = array();
        foreach ($markgroups as $markgroup) {
            $marki[] = (string) $markgroup->name;
        }
        $this->markgroups = implode(',', $marki);
    }

    public function setRodzajPaczki($rodzajPaczki) {
        if (empty($rodzajPaczki)) {
            return;
        }
        $rodzajePaczki = array();
        foreach ($rodzajPaczki as $rodzaj) {
            $rodzajePaczki[] = $rodzaj->name;
        }
        $this->rodzajPaczki = implode(',', $rodzajePaczki);
    }

    public function setMaterial($materials) {
        if (empty($materials)) {
            return;
        }
        $materialy = array();
        foreach ($materials as $material) {
            $materialy[] = (string) $material->name;
        }
        $this->material = implode(',', $materialy);
    }

    public function setPackages($packages) {
        if (empty($packages)) {
            return;
        }
        $pakowanie = array();
        foreach ($packages as $paczka) {
            $pakowanie[] = (string) $paczka->name;
        }
        $this->packages = implode(', ', $pakowanie);
    }

    public function setParametryDodatkowe($nazwa, $parametr) {
        $this->parametryDodatkowe[$nazwa] = array(
            'name' => $nazwa,
            'value' => $parametr,
            'position' => 1,
            'is_visible' => 1,
            'is_variation' => 1,
            'is_taxonomy' => 0
        );
    }

    public function addProductParametry($idPorduct) {
        if(!empty($this->getMaterial())){ $this->setParametryDodatkowe('Materiał', $this->getMaterial());  }
        if(!empty($this->getMarkgroups())){$this->setParametryDodatkowe('Grupy dodatwkowe', $this->getMarkgroups());}
        if(!empty($this->getWymiar())){$this->setParametryDodatkowe('Wymiary', $this->getWymiar());}
        if(!empty($this->getCountry())){ $this->setParametryDodatkowe('Kraj', $this->getCountry());}
        if(!empty($this->getColor())){$this->setParametryDodatkowe('Kolor', $this->getColor());}
        if(!empty($this->getRodzajPaczki())){$this->setParametryDodatkowe('Rodzaj paczki', $this->getRodzajPaczki());}
        if(!empty($this->getIloscMalaPaczka())){$this->setParametryDodatkowe('Ilość sztuk w małej paczce', $this->getIloscMalaPaczka());}
        if(!empty($this->getIloscDuzaPaczka())){$this->setParametryDodatkowe('Ilość sztuk w dużej paczce', $this->getIloscDuzaPaczka());}
        if(!empty($this->getBrand())){ $this->setParametryDodatkowe('Producent', $this->getBrand());}
        if(!empty($this->getShortCode())){ $this->setParametryDodatkowe('EAN', $this->getShortCode());}
        if(!empty($this->getId())){ $this->setParametryDodatkowe('ID w Hurtowni', $this->getId());}
        update_post_meta($idPorduct, '_sku', $this->getCode());
        update_post_meta($idPorduct, '_price', $this->getCena());
        update_post_meta($idPorduct, '_regular_price', $this->getCena());
        update_post_meta($idPorduct, '_sale_pric', $this->getCenaWyprzedazy());
        update_post_meta($idPorduct, '_weight', $this->getWaga());
        update_post_meta($idPorduct, '_product_attributes', $this->getParametryDodatkowe());
        update_post_meta($idPorduct, '_manage_stock', 'yes');
        update_post_meta($idPorduct, '_stock', 0);
        update_post_meta($idPorduct, '_stock_status', 'outofstock');
    }

}
