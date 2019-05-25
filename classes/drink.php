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
    private $_ingredients;
    private $_type;

    // ingredients[] field: store associative array of ingredient => qty

    // type[] field associative array of ingredient => type

    function __construct($name, $glass, $qty, $ingredients, $type, $image)
    {
        $this->_name = $name;
        $this->_glass = $glass;
        $this->_image = $image;
        $this->_ingredients = array();
        $this->_type = array();

        // $this->_ingredients[$ingredients[0]] = $qty[0], etc.
        for($i = 0; $i < count($ingredients); $i++) {
            $this->_ingredients[$ingredients[$i]] = $qty[$i];
        }
        // $this->_type[$ingredients[0] = $type[0], etc.
        for($i = 0; $i < count($ingredients); $i++) {
            $this->_type[$ingredients[$i]] = $type[$i];
        }

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
     * @param string $image
     */
    public function setImage($image)
    {
        $this->_image = $image;
    }
}