<?php
/**
 * Created by PhpStorm.
 * User: Kaephas
 * Date: 5/19/2019
 * Time: 12:08
 */

class AlcoholDrink extends Drink
{
    private $_shots;

    function setShots($shots) {
        $this->_shots = $shots;
    }

    function getShots() {
        return $this->_shots;
    }

}