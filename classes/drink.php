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

    // ingredients[] field: store associative array of ingredient => qty

    // type[] field associative array of ingredient => type

    function __construct($name, $glass, $qty, $ingredients, $type, $image)
    {
        $this->_name = $name;
        $this->_glass = $glass;
        $this->_image = $image;

        // $this->_ingredients[$ingredients[0]] = $qty[0], etc.

        // $this->_type[$ingredients[0] = $type[0], etc.

    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->_image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->_image = $image;
    }
}