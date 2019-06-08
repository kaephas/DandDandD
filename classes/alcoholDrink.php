<?php
/**
 * Represents an Alcoholic Drink that keeps track of shots in the Drink in addition to other Drink info
 *
 * @author Kaephas & Zane
 * @version 1.0
 */

/**
 * Class AlcoholDrink
 *
 * extends Drink object with shots information
 */
class AlcoholDrink extends Drink
{
    private $_shots;

    /**
     * Sets the number of shots in the Drink
     * @param int $shots    The number of shots to set the Drink to
     */
    function setShots($shots)
    {
        $this->_shots = $shots;
    }

    /**
     * Returns the number of shots the Drink has
     * @return int      The number of shots in the Drink
     */
    function getShots()
    {
        return $this->_shots;
    }

}