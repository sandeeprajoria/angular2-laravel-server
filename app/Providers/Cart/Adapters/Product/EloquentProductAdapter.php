<?php namespace App\Providers\Cart\Adapters\Product;

use App\Providers\Cart\Adapters\Product\ProductAdapterInterface;
use Illuminate\Support\Facades\Config;
use App\Providers\Cart\Exceptions\InvalidProductException;
use App\Providers\Cart\Exceptions\InvalidPriceException;
use App\Providers\Cart\Exceptions\InvalidConfigurationException;

/**
 * Description of EloquentProductAdapter
 *
 * @author Sandeep Rajoria <sandeep.rajoria@yahoo.co.in>
 * @date   4 Mar, 2017
 */
class EloquentProductAdapter implements ProductAdapterInterface{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $product;

    /**
     * Create a new product instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model product
     */
    public function __construct()
    {
        if(empty(Config::get('cart.models.product'))){
            throw new InvalidConfigurationException();
        }
        $this->product = \App::make(Config::get('cart.models.product'));
    }
    /**
     * Function to get all the products
     * 
     * @return array array of all the product with details
     */
    public function all(){
        return $this->product->orderBy('product_name')->get()->toArray();
    }
            
    /**
     * Function to get the details of a product
     * 
     * @param string value - either name or id of the product
     * @param string possible values id/name
     * @return Array of all the details of the product
     */
    public function get($identifier, $type = 'id'){
        
        if($type == 'name'){
            $product = $this->product->where('product', $identifier);
            if($product->count() == 0){
                \Log::error("$identifier not a valid product in get@EloquentProductAdapter");
                throw new InvalidProductException("$identifier Not a valid product", 400);
            }
            return $product->first()->toArray();
        }elseif($type == 'id'){
            $product = $this->product->where('id', (int)$identifier);
            if($product->count() == 0){
                \Log::error("ID $identifier not a valid product ID in get@EloquentProductAdapter");
                throw new InvalidProductException("id $identifier Not a valid product", 400);
            }
            return $product->first()->toArray();
        }else{
            \Log::error("Empty argument in get@EloquentProductAdapter identifier - $identifier, type - $type");
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
    }
    
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
    public function add($product_name, $product_category, $product_sub_category, $price, $attributes){
        if(empty($product_name) || empty($product_category) || empty($product_sub_category) || empty($attributes) ||empty($price)){
            \Log::error("Empty argument in add@EloquentProductAdapter product_name - $product_name, product_category - $product_category, product_sub_category - $product_sub_category, price - $price, attributes - ".json_encode($attributes));
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
        
        if(!($price > 0)){
            \Log::error("Invalid price passed in add@EloquentProductAdapter $price");
            throw new InvalidPriceException("Invalid price", 400);
        }
        
        return $this->product->create([
            'product_name' => $product_name,
            'product_category' => $product_category,
            'product_sub_category' => $product_sub_category,
            'price' => $price,
            'attributes' => json_encode($attributes),
        ]);
    }

    /**
     * Function to update an existing product
     * 
     * @param integer Id of the product to be updated
     * @param array key value pair of the data to be updated
     * @return bool Sucessfully updated or not
     */
    public function update($product_id, $product_data){
        if(empty($product_id) || empty($product_data)){
            \Log::error("Empty argument in update@EloquentProductAdapter product_id - $product_id, product_data - ".json_encode($product_data));
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
        
        $product_object = $this->product->find($product_id);
        if($product_object->count() == 0){
            \Log::error("ID $product_id not a valid product ID in update@EloquentProductAdapter");
            throw new InvalidProductException("id $product_id Not a valid product", 400);
        }
        return $product_object->update($product_data);
    }
    
    /**
     * Function to delete a product, would actually just disable it
     * 
     * @param string value - either name or id of the product
     * @param string possible values id/name
     * @return bool Sucessfully deleted or not
     */
    public function delete($identifier, $type = 'id'){
        
        if($type == 'name'){
            $product = $this->product->where('product',$identifier);
            if($product->count() == 0){
                \Log::error("$identifier not a valid product in get@EloquentProductAdapter");
                throw new InvalidProductException("$identifier Not a valid product", 400);
            }
            return $product->first()->delete();
        }elseif($type == 'id'){
            $product = $this->product->where('id', (int)($identifier));
            if($product->count() == 0){
                \Log::error("ID $identifier not a valid product ID in get@EloquentProductAdapter");
                throw new InvalidProductException("id $identifier Not a valid product", 400);
            }
            return $product->first()->delete();
        }else{
            \Log::error("Empty argument in delete@EloquentProductAdapter identifier - $identifier, type - $type");
            throw new \InvalidArgumentException("One of the arguments is empty", 400);
        }
    }
}
