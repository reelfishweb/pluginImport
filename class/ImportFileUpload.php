<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once( ABSPATH . 'wp-admin/includes/image.php' );

/**
 * Description of ImportFileUpload
 *
 * @author cwkadmin
 */
class ImportFileUpload {

    private $galeryPhotoID = array();
    private $galeryPhoto = array();
    
    /**
     *
     * @var EasyGaleryStrategy
     */
    private $strategy;
    
    public function __construct($strategy)
    {
        $this->strategy = $strategy;
    }

    public function getGaleryPhoto() {
        return $this->galeryPhoto;
    }

    public function setGaleryPhoto($galeryPhoto) {
        $this->galeryPhoto = $galeryPhoto;
    }

    public function getGaleryPhotoID() {
        return $this->galeryPhotoID;
    }

    public function setGaleryPhotoID($galeryPhoto) {
        $this->galeryPhotoID[] = $galeryPhoto;
    }

    public function getFirstElementGaleryPhotoID() {
        return $this->galeryPhotoID[0];
    }

    
    /**
     * Upload obrazków do wp z tablicy scieżek do plików umieszczony na serwerze www
     */
    public function uploadFile() {
        foreach ($this->getGaleryPhoto() as $fileNameUri) {
            $sFileName = $this->getNameFileWithUri($fileNameUri);
            $file = $this->strategy->getContentFile($fileNameUri);
            $upload = wp_upload_bits($sFileName, null, $file);
            unset($file);
            $attachment = array(
                'guid' => $upload['url'],
                'post_mime_type' => $upload['type'],
                'post_title' => preg_replace('/\.[^.]+$/', '', $sFileName),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment($attachment, $upload['file']);
            $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
            wp_update_attachment_metadata($attachment_id, $attach_data);
            $this->setGaleryPhotoID($attachment_id);
            echo 'Dodano obrazek: ' . $sFileName . PHP_EOL;
        }
    }

    /**
     * Zamienie sicężke do pliku na serwerze na nazwę pliku
     * @param string scieżka do pliku umieszczonego na serwerze
     * @return string nazwa pliku
     */
    private function getNameFileWithUri($uri) {
        $linkEx = explode('/', $uri);
        $fileName = end($linkEx);
		$afileName = explode('.', $fileName);
		$rozszerzenieFile = end($afileName);
		if($rozszerzenieFile != 'jpg' and $rozszerzenieFile != 'png' and $rozszerzenieFile != 'jpeg')
		{
			$fileName .= '.jpg';
		}	
        return $fileName;
    }

}
