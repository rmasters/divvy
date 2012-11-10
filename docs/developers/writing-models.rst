Writing models
==============

Models in divvy extend from a `Application\ModelBase`. This class allows
properties of the model to be accessed as public properties, via methods and
as an array. For example:

    class Album extends ModelBase {
        protected $id;
        protected $name;
        protected $createdAt;
        protected $nameUpdated = false;

        public function getCreatedAt() {
            if (!isset($this->createdAt)) {
                $this->createdAt = new \DateTime;
            }
            return $this->createdAt;
        }

        public function setTrackedName($name) {
            $this->name = $name;
            $this->nameUpdated = true;
        }
    }


    $album = new Album;

    // This is routed through __get() straight to the property
    echo $album->name;
    // This is routed through __call(), to __get(), to the property
    echo $album->getName();
    // This is routed through offsetGet() to __get(), to the property
    echo $album['name'];

    // Routed through __set() to the property
    $album->name = 'Kids';
    // Routed through __call(), to __set(), to the property
    $album->setName('Kids');
    // Routed through offsetSet(), to __set(), to the property
    $album['name'] = 'Kids';

    // This is routed through __get() to getCreatedAt()
    echo $album->getCreatedAt();

The order of execution for `__get()` and `__set()` is:

1.  Check for a method named get{ucfirst($property)} or set{ucfirst($property)}
2.  Check for a property (protected or public)
3.  Throw an exception

`__isset()` and `__unset()` are a little different. `__isset()` calls `__get()`
and checks if it is null. `__unset()` calls `__set()` with null as the value.

This setup allows us to have pseudo-properties - methods that can be accessed
like class properties, like so:

    $album = new Album;

    echo $album->nameUpdated ? 'updated' : 'not updated'; // 'not updated'
    $album->trackedName = 'Nightcall';
    echo $album->nameUpdated ? 'updated' : 'not updated'; // 'updated'

    echo $album->trackedName; // Exception, as there is no getTrackedName() method

Accessing properties in methods
-------------------------------

All this in mind, when we come to write model methods we need to be careful when
accessing properties. The general rule, is that when you are accessing a
property that you are not writing a getter/setter for, you should use the
getter/setter of the property itself.

This means that classes that extend your model can override and implement their
own getters and setters. A good-usage example:

    class User extends ModelBase {
        protected $username;

        public function __construct($username=null) {
            $this->setUsername($username);
        }
    }

    class MyUser extends ModelBase {
        public function setUsername($username) {
            $this->username = ucfirst($username);
        }
    }

As the protected property `$username` is accessible to User, we need to use the
setter to trigger `setUsername()` in the constructor of MyUser.
