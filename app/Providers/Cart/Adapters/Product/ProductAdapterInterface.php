<?php namespace App\Providers\Cart\Adapters\Product;

/**
 * Description of ProductAdapterInterface
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   4 Mar, 2017
 */
interface ProductAdapterInterface {
    
    /**
     * Function to get all the products
     * 
     * @return array array of all the product with details
     */
    public function all();

    /**
     * Function to get the details of a product
     * 
     * @param string value - either name or id of the product
     * @param string possible values id/name
     * @return Array of all the details of the product
     */
    public function get($identifier, $type = 'id');
    
    /**
     * Function to add a new product item
     * 
     * @param string Name of the product to be added
     * @param string Category of the product
     * @param string SubCategory of the product
     * @param decimal Price of the product
     * @param array Key value pair
     * @return bool Sucessfully added or not
     */
    public function add($product_name, $product_category, $product_sub_category, $price, $attributes);

    /**
     * Function to update an existing product
     * 
     * @param integer Id of the product to be updated
     * @param array key value pair of the data to be updated
     * @return bool Sucessfully updated or not
     */
    public function update($product_id, $product_data);
    
    /**
     * Function to delete a product, would actually just disable it
     * 
     * @param string value - either name or id of the product
     * @param string possible values id/name
     * @return bool Sucessfully deleted or not
     */
    public function delete($identifier, $type = 'id');
}
