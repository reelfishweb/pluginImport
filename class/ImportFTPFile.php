<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImportFTPConnectFTP
 *
 * @author cwkadmin
 */
class ImportFTPFile {

    private $connection;
    private $ftpName;
    private $ftpUser;
    private $ftpPassord;

    public function __construct($user, $password, $host) {
        $this->ftpName = $host;
        $this->ftpPassord = $password;
        $this->ftpUser = $user;
        $this->connection = ftp_connect($this->ftpName);
        ftp_login($this->connection, $this->ftpUser, $this->ftpPassord);
    }

    public function addGaleryProduct($productId, $aFileName, $folder, $idThumb) {
        $idGaleryPhoto = array();
        $idGaleryPhoto[] = $idThumb;
        foreach ($aFileName as $fileName) {
            $file = $this->getContentFile($fileName, $folder);
            //$file = file_get_contents('ftp://' . $this->ftpUser . ':' . $this->ftpPassord . '@' . $this->ftpName . '/' . $folder . '/' . $fileName);
            $upload = wp_upload_bits($aFileName, null, $file);
            $attachment = array(
                'guid' => $upload['url'],
                'post_mime_type' => 'image/jpeg',
                'post_title' => preg_replace('/\.[^.]+$/', '', $fileName),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment($attachment, $upload['file']);
            $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
            wp_update_attachment_metadata($attachment_id, $attach_data);
            $idGaleryPhoto[] = $attachment_id;
        }
        $photoGaleruy = implode(',', $idGaleryPhoto);
        update_post_meta($productId, '_product_image_gallery', $photoGaleruy);
    }

    public function addThumbnailProduct($postID, $fileName, $folder) {
        $file = $this->getContentFile($fileName, $folder);
        //$file = file_get_contents('ftp://' . $this->ftpUser . ':' . $this->ftpPassord . '@' . $this->ftpName . '/' . $folder . '/' . $fileName);
        $upload = wp_upload_bits($aFileName, null, $file);
        $attachment = array(
            'guid' => $upload['url'],
            'post_mime_type' => 'image/jpeg',
            'post_title' => preg_replace('/\.[^.]+$/', '', $fileName),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        $attachment_id = wp_insert_attachment($attachment, $upload['file']);
        $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
        wp_update_attachment_metadata($attachment_id, $attach_data);
        set_post_thumbnail($postID, $attachment_id);
        return $attachment_id;
    }

    public function getContentFile($fileName, $folder = '') {
        $tempHandle = fopen('php://memory', 'w');
        $srcFile = '/' . $fileName;
        if (!empty($folder)) {
            $srcFile = '/' . $folder . $srcFile;
        }
        if (@ftp_fget($this->connection, $tempHandle, $srcFile, FTP_ASCII, 0)) {
            rewind($tempHandle);
            return stream_get_contents($tempHandle);
        } else {
            return false;
        }
    }
    
    public function __destruct() {
        ftp_close($this->connection);
    }

}
