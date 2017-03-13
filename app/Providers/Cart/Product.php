<?php
namespace App\Providers\Cart;

use App\Providers\Cart\Interfaces\ProductInterface;
use App\Providers\Cart\Adapters\Product\ProductAdapterInterface;


/**
 * Description of Product
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   4 Mar, 2017
 */
class Product implements ProductInterface {
    
    /** 
     * Dependency injection of App\Providers\Cart\Adapters\Product\ProductAdapterInterface
     *
     * @var App\Providers\Cart\Adapters\Product\ProductAdapterInterface
     */
    protected $product;
    
    
    /**
     * Constructor.
     *
     * @param App\Providers\Cart\Adapters\Product\ProductAdapterInterface $product 
     */
    public function __construct(ProductAdapterInterface $product){
        $this->product = $product;
    }
    
    /**
     * Function to get all products
     * 
     * @return array details of all the product if the id is valid
     */
    public function getAll(){
        return $this->product->all();
    }
    
    /**
     * Function to add a new Product
     * 
     * @param integer ID of the product to be updated
     * @return array details of the product if the id is valid
     */
    public function get($product_id){
        return $this->product->get($product_id, 'id');
    }
    
    /**
     * Function to add a new Product
     * 
     * @param array Key value pair of the data which needs to be added
     * @return bool Whether successfully added or not
     */
    public function add($product_details){
        \Log::info("Prod details - ".json_encode($product_details));
        return $this->product->add($product_details['product_name'], $product_details['product_category'], $product_details['product_sub_category'], $product_details['price'], $product_details['attributes']);
    }
        
    /**
     * Function to update and existing product
     * 
     * @param integer ID of the product to be updated
     * @param array Key value pair of the data which needs to be updated
     * @return bool Whether successfully added or not
     */
    public function update($product_id, $product_details){
        return $this->product->update($product_id, $product_details);
    }
    
    /**
     * Function to delete a product
     * 
     * @param integer  ID of the product to be deleted
     * @return bool Whether successfully deleted or not
     */
    public function delete($product_id){
        return $this->product->delete($product_id, 'id');
    }
}