<?php
/**
 * Created by PhpStorm.
 * User: Kaephas
 * Date: 5/29/2019
 * Time: 11:00
 */

class Character
{
    private $_name;
    private $_class;
    private $_subclass;
    private $_alignment;
    private $_background;
    private $_age;
    private $_stats;
    private $_alcoholic;

    /**
     * Character constructor.
     * @param $_name
     * @param $_class
     * @param $_subclass
     * @param $_alignment
     * @param $_background
     * @param $_age
     * @param $_stats
     * @param $_alcoholic
     */
    public function __construct($_name, $_class, $_subclass, $_alignment, $_background, $_age, $_stats, $_alcoholic)
    {
        $this->_name = $_name;
        $this->_class = $_class;
        $this->_subclass = $_subclass;
        $this->_alignment = $_alignment;
        $this->_background = $_background;
        $this->_age = $_age;
        $this->_stats = $_stats;
        $this->_alcoholic = $_alcoholic;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->_class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->_class = $class;
    }

    /**
     * @return mixed
     */
    public function getSubclass()
    {
        return $this->_subclass;
    }

    /**
     * @param mixed $subclass
     */
    public function setSubclass($subclass)
    {
        $this->_subclass = $subclass;
    }

    /**
     * @return mixed
     */
    public function getAlignment()
    {
        return $this->_alignment;
    }

    /**
     * @param mixed $alignment
     */
    public function setAlignment($alignment)
    {
        $this->_alignment = $alignment;
    }

    /**
     * @return mixed
     */
    public function getBackground()
    {
        return $this->_background;
    }

    /**
     * @param mixed $background
     */
    public function setBackground($background)
    {
        $this->_background = $background;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * @return mixed
     */
    public function getStats()
    {
        return $this->_stats;
    }

    /**
     * @param mixed $stats
     */
    public function setStats($stats)
    {
        $this->_stats = $stats;
    }

    /**
     * @return mixed
     */
    public function getAlcoholic()
    {
        return $this->_alcoholic;
    }

    /**
     * @param mixed $alcoholic
     */
    public function setAlcoholic($alcoholic)
    {
        $this->_alcoholic = $alcoholic;
    }



}