<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductAction
 *
 * @author cwkadmin
 */
class ProductAction {

    //put your code here

    public function sprawdzCzyProduktIsniejePoSKU($sku)
    {
        if (empty($sku))
        {
            return true;
        }
        $args = array(
            'meta_key' => '_sku',
            'meta_value' => $sku,
            'post_type' => 'product',
            'post_status' => 'publish'
        );

        $posts_array = get_posts($args);

        if (count($posts_array) == 0)
        {
            return false;
        }
        $post = $posts_array[0];

        return $post->ID;
    }

}
