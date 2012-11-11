<?php
/**
 * Divvy
 *
 * @link      https://github.com/rmasters/divvy
 * @license   https://github.com/rmasters/divvy/blob/master/LICENSE
 * @author    Ross Masters <ross@rossmasters.com>
 */

namespace Application;

use Zend\InputFilter\InputFilter;

use PHPUnit_Framework_TestCase;

/**
 * Define a simple model that extends ModelBase
 */
class TestModel extends ModelBase
{
    protected $id;
    protected $name;

    public function __construct() {
        $this->id = 2;
    }

    public function getPseudoProperty() {
        return '1234567890';
    }

    public function setPseudoProperty($value) {
        $this->name = $value;
    }

    public function getInputFilter() {
        return new InputFilter;
    }
}

/**
 * Tests Application\ModelBase
 *
 * @package Tests
 */
class ModelBaseTest extends PHPUnit_Framework_TestCase
{
    public function testPropertyAccess() {
        $model = new TestModel;

        // Test __get
        $this->assertEquals($model->id, 2);

        // Test __isset
        $this->assertFalse(isset($model->name));

        // Test __set
        $model->name = 'Name';
        $this->assertEquals($model->name, 'Name');

        // Test __unset
        unset($model->name);
        $this->assertNull($model->name);

        // Test getting a non-existant property
        $this->setExpectedException('Exception');
        $model->nonexistant;

        // Test setting a non-existant property
        $this->setExpectedException('Exception');
        $model->nonexistant = false;

        // Test getting pseduo-property via __get
        $this->assertEquals($model->pseudoProperty, '1234567890');

        // Test setting a psuedo-property via __set
        $model->pseudoProperty = 'example';
        $this->assertEquals($model->name, 'example');
    }

    public function testMethodAccess() {
        $model = new TestModel;

        // Test get via __call
        $this->assertEquals($model->getId(), 2);

        // Test __set
        $model->setName('Name');
        $this->assertEquals($model->getName(), 'Name');

        // Test getting a non-existant property
        $this->setExpectedException('Exception');
        $model->getNonexistant();

        // Test setting a non-existant property
        $this->setExpectedException('Exception');
        $model->setNonexistant(false);

        // Test getting pseduo-property via __get
        $this->assertEquals($model->getPseudoProperty(), '1234567890');

        // Test setting a psuedo-property via __set
        $model->setPseudoProperty('example');
        $this->assertEquals($model->getName(), 'example');
    }

    public function testArrayAccess() {
        $model = new TestModel;

        // Test offsetGet
        $this->assertEquals($model['id'], 2);

        // Test offsetExists
        $this->assertFalse(isset($model['name']));

        // Test offsetSet
        $model->name = 'Name';
        $this->assertEquals($model['name'], 'Name');

        // Test offsetUnset
        unset($model['name']);
        $this->assertNull($model['name']);

        // Test getting a non-existant property
        $this->setExpectedException('Exception');
        $model['nonexistant'];

        // Test setting a non-existant property
        $this->setExpectedException('Exception');
        $model['nonexistant'] = false;

        // Test getting pseduo-property via __get
        $this->assertEquals($model['pseudoProperty'], '1234567890');

        // Test setting a psuedo-property via __set
        $model['pseudoProperty'] = 'example';
        $this->assertEquals($model['name'], 'example');
    }

    public function testExchangeArray() {
        $model = new TestModel;

        $ret = $model->exchangeArray(array('id' => 5, 'name' => 'Dawleys'));

        $this->assertSame($ret, $model);
        $this->assertEquals($model->id, 5);
        $this->assertEquals($model->name, 'Dawleys');

        $this->setExpectedException('Exception');
        $model->exchangeArray(array('fake' => 123));
    }

    public function testGetArrayCopy() {
        $model = new TestModel;

        $this->assertEquals($model->getArrayCopy(), array('id' => 2, 'name' => null));
    }

    public function testInputFilter() {
        $model = new TestModel;

        $this->setExpectedException('Exception');
        $model->setInputFilter(new InputFilter);
    }
}
