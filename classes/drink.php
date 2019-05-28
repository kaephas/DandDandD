<?php
/**
 * Created by PhpStorm.
 * User: Kaephas
 * Date: 5/18/2019
 * Time: 10:11
 */

class Drink
{
    private $_name;
    private $_glass;
    private $_image;
    private $_qty;
    private $_ingredients;
    private $_type;
    private $_recipe;

    // ingredients[] field: store associative array of ingredient => qty

    // type[] field associative array of ingredient => type

    function __construct($name, $glass, $qty, $ingredients, $type, $recipe, $image='images/default.jpg')
    {
        $this->_name = $name;
        $this->_glass = $glass;
        $this->_image = $image;
        $this->_qty = $qty;
        $this->_ingredients = $ingredients;
        $this->_type = $type;
        $this->_recipe = $recipe;

//        // $this->_ingredients[$ingredients[0]] = $qty[0], etc.
//        for($i = 0; $i < count($ingredients); $i++) {
//            $this->_ingredients[$ingredients[$i]] = $qty[$i];
//        }
//        // $this->_type[$ingredients[0] = $type[0], etc.
//        for($i = 0; $i < count($ingredients); $i++) {
//            $this->_type[$ingredients[$i]] = $type[$i];
//        }

    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return mixed
     */
    public function getGlass()
    {
        return $this->_glass;
    }

    /**
     * @return mixed
     */
    public function getQty() {
        return $this->_qty;
    }

    /**
     * @return array
     */
    public function getIngredients()
    {
        return $this->_ingredients;
    }

    /**
     * @return array
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return string
     */
    public function getRecipe()
    {
        return $this->_recipe;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->_image = $image;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @param mixed $glass
     */
    public function setGlass($glass)
    {
        $this->_glass = $glass;
    }

    /**
     * @param mixed $qty
     */
    public function setQty($qty)
    {
        $this->_qty = $qty;
    }

    /**
     * @param mixed $ingredients
     */
    public function setIngredients($ingredients)
    {
        $this->_ingredients = $ingredients;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * @param mixed $recipe
     */
    public function setRecipe($recipe)
    {
        $this->_recipe = $recipe;
    }


}