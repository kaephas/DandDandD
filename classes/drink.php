<?php
/**
 * Represents an Drink that stores information about a Drink
 *
 * @author Kaephas & Zane
 * @version 1.0
 */

/**
 * Class Drink
 *
 * Represents a Drink
 */
class Drink
{
    private $_glass;
    private $_image;
    private $_ingredients;
    private $_name;
    private $_qty;
    private $_recipe;
    private $_type;

    /**
     * Drink constructor.
     * @param string $glass
     * @param string $image
     * @param string[] $ingredients
     * @param string $name
     * @param string[] $qty
     * @param string $recipe
     * @param string[] $type
     */
    function __construct($name, $glass, $qty, $ingredients, $type, $recipe, $image='images/default.jpg')
    {
        $this->_glass = $glass;
        $this->_image = $image;
        $this->_ingredients = $ingredients;
        $this->_name = $name;
        $this->_qty = $qty;
        $this->_recipe = $recipe;
        $this->_type = $type;
    }

    /**
     * Gets the type of glass the Drink uses
     * @return string $_glass   type of glass
     */
    public function getGlass()
    {
        return $this->_glass;
    }

    /**
     * Gets the image path of the drink
     * @return string $_image   the path of the image
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * Gets the Ingredients list of the drink
     * @return string[] $_ingredients   the ingredients list
     */
    public function getIngredients()
    {
        return $this->_ingredients;
    }

    /**
     * Gets the name of the drink
     * @return string $_name    the name of the drink
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Gets the quantity list mapped to same indices as matched ingredient
     * @return string[] $_qty     the quantity list
     */
    public function getQty() {
        return $this->_qty;
    }

    /**
     * Gets the Drink recipe
     * @return string $_recipe  the recipe
     */
    public function getRecipe()
    {
        return $this->_recipe;
    }

    /**
     * Gets the type list mapped to same indices as matched ingredient
     * @return string[] $_type      the type list
     */
    public function getType()
    {
        return $this->_type;
    }

    // setters

    /**
     * Sets the drink's glass
     * @param string $glass     the new type of glass
     * @return void
     */
    public function setGlass($glass)
    {
        $this->_glass = $glass;
    }

    /**
     * Sets the drinks image
     * @param string $image      the new image path
     * @return void
     */
    public function setImage($image)
    {
        $this->_image = $image;
    }

    /**
     * Sets the ingredient list of the drink
     * @param string[] $ingredients     the new list of ingredients
     * @return void
     */
    public function setIngredients($ingredients)
    {
        $this->_ingredients = $ingredients;
    }

    /**
     * Sets the drink's name
     * @param string $name  the new name
     * @return void
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Sets the quantity list mapped to same indices as matched ingredients
     * @param string[] $qty     the new list of quantities
     * @return void
     */
    public function setQty($qty)
    {
        $this->_qty = $qty;
    }

    /**
     * Sets the drink's recipe
     * @param string $recipe    the new recipe
     * @return void
     */
    public function setRecipe($recipe)
    {
        $this->_recipe = $recipe;
    }

    /**
     * Sets the type list mapped to the same indices as matched ingredients
     * @param string[] $type    the new type list
     * @return void
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    // methods

    /**
     * Outputs all data in an easily read format used for testing
     * (json output doesn't work due to private fields)
     * @return string $output   the prettified string form of all class fields
     */
    public function prettify()
    {
        $tab = "&nbsp;&nbsp;&nbsp;&nbsp;";
        $output = get_class($this) . " { ";
        $output .= "<br>{$tab} Name: $this->_name";
        $output .= "<br>{$tab} Glass: $this->_glass";
        $output .= "<br>{$tab} Ingredients: {";
        $printIng = $this->_ingredients;
        $printQty = $this->_qty;
        $printType = $this->_type;
        foreach($printIng as $i => $ing) {
            $output .= "<br>{$tab}{$tab} $i: {$printQty[$i]} $ing => Type: {$printType[$i]}";
        }
        $output .= "<br>{$tab} }";
        $output .= "<br>{$tab} Image: $this->_image";
        $output .= "<br>{$tab} Recipe: $this->_recipe";
        return $output;
    }

}