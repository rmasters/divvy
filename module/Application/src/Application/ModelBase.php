<?php
/**
 * Divvy
 *
 * @link      https://github.com/rmasters/divvy
 * @license   https://github.com/rmasters/divvy/blob/master/LICENSE
 * @author    Ross Masters <ross@rossmasters.com>
 */

namespace Application;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Base model
 *
 * Implements magic methods and properties that allow for custom getters and
 * setters for properties without having to define both for each property.
 *
 * @package Models
 */
abstract class ModelBase implements InputFilterAwareInterface, \ArrayAccess
{
    /**
     * Get the properties of the model as an array
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    /**
     * Set properties of the model from an array
     * @param \Traversable $data Values to use
     * @return \Application\ModelBase $this
     */
    public function exchangeArray($data) {
        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }

        return $this;
    }

    /**
     * Get a property
     *
     * This attempts to get a value in this order:
     *   call $this->getPropertyName(), if it exists;
     *   get $this->propertyName, if it exists;
     *   throw an exception.
     *
     * The getter method should be able to be called without arguments (though
     * it can have optional arguments for other uses).
     * 
     * This allows for the use of pseudo-properties - by defining a method that can
     * then be accessed as a property ($this->getPseudo() == $this->pseudo).
     *
     * @param string $name Property name.
     * @throws Exception If neither the getter method or the property exist
     * @return mixed
     */
    public function __get($name) {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        } else if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            throw new \Exception(sprintf('Cannot get invalid property %s', $name));
        }
    }

    /**
     * Set a property, using the same method as __get()
     * 
     * @param string $name Property name
     * @param mixed $value Value to set
     * @return void
     */
    public function __set($name, $value) {
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            $this->$method($value);
            return $this;
        } else if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new \Exception(sprintf('Cannot set invalid property %s', $name));
        }
    }

    /**
     * Detect if a property has been set
     * Uses the same method as __get(). Will return false if value is null.
     *
     * @param string $name Property name
     * @return bool
     */
    public function __isset($name) {
        return !is_null($this->__get($name));
    }

    /**
     * Sets a property to null (using __set())
     * @param string $name
     * @return void
     */
    public function __unset($name) {
        $this->__set($name, null);
    }

    /**
     * Detect if a property exists in the same manner as __get() and __set()
     * @param string $name Property name
     * @return bool
     */
    public function hasProperty($name) {
        return method_exists($this, 'get' . ucfirst($name)) || property_exists($this, $name);
    }

    /**
     * The inverse of __get() for undefined method calls
     *
     * If the method is named getX or setX and has 0 or 1 arguments respectively it
     * will return calls to __get() and __set() respectively.
     *
     * @param string $name Method name
     * @param array $args Method arguments
     * @throws Exception If no getter or setter could be detected
     * @return mixed
     */
    public function __call($name, array $args = array()) {
        // If method begins with get(.+) or set(.+)
        if (strlen($name) > 3) {
            // get* and set*
            $prefix = substr($name, 0, 3);
            if (in_array($prefix, array('get', 'set'))) {
                $field = lcfirst(substr($name, 3));

                // Pass to __set if number of args is 1
                if ($prefix == 'set' && count($args) == 1) {
                    call_user_func(array($this, '__set'), $field, array_shift($args));
                    return $this;
                }

                // Pass to __get if number of args is 0
                if ($prefix == 'get' && count($args) == 0) {
                    return call_user_func(array($this, '__get'), $field);
                }
            }
        }

        throw new \Exception(sprintf('No method %s of class %s', $name, __CLASS__));
    }

    /**
     * Provide access to __isset() in the array form `isset($this[$name])`
     * @param string $name
     * @return bool
     */
    public function offsetExists($name) {
        return call_user_func(array($this, '__isset'), $name);
    }

    /**
     * Provide access to __get() in the array form `$this[$name]`
     * @param string $name
     * @return mixed
     */
    public function offsetGet($name) {
        return call_user_func(array($this, '__get'), $name);
    }

    /**
     * Provide access to __set() in the array form `$this[$name] = $value`
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function offsetSet($name, $value) {
        call_user_func(array($this, '__set'), $name, $value);
    }

    /**
     * Provide access to __unset() in the array form `unset($this[$name])`
     * @param string $name
     * @return void
     */
    public function offsetUnset($name) {
        call_user_func(array($this, '__unset'), $name);
    }

    /**
     * Prevent input filters being overridden
     * @param \Zend\InputFilter\InputFilterInterface $if
     * @throws Exception
     */
    public function setInputFilter(InputFilterInterface $if) {
        throw new \Exception('Not used');
    }

    /**
     * Require subclasses to define an input filter
     * @return \Zend\InputFilter\InputFilter
     */
    abstract public function getInputFilter();
}
