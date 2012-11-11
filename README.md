# divvy - an open-source linkboard

Master: [![Build Status](https://secure.travis-ci.org/rmasters/divvy.png?branch=master)](https://travis-ci.org/rmasters/divvy)
Develop: [![Build Status](https://secure.travis-ci.org/rmasters/divvy.png?branch=develop)](https://travis-ci.org/rmasters/divvy)

## About

**divvy** is a linkboard that aims to incorporate the features of reddit,
Hacker News, metafilter and the like in a way that anyone can setup a board with
little web-dev knowledge (as Wordpress and phpBB have done).

I'm not attached to the name, suggestions are welcome.

### Status

Development started on 10th November 2012 - so it's not in a usable state yet.

## Aims

*   Be extremely simple to setup - with a (`n<5`)-click installer,
*   Be extensible in a similar manner to Wordpress - from themes to custom plugins,
*   Be a useful resource for ZF2 developers to learn from.

## Technology

Given our aim to be extensible, the project uses:

*   [Zend Framework 2](http://framework.zend.com) ([github](https://github.com/zendframework/zf2)),
*   [Doctrine 2](http://doctrine-project.org) ORM and DBAL (using [DoctrineORMModule](https://github.com/doctrine/DoctrineORMModule)),
*   [Twig](http://twig.sensiolabs.org) (using [ZfcTwig](https://github.com/ZF-Commons/ZfcTwig)),
*   and [Bootstrap](https://twitter.github.com/bootstrap) for the default interface theme.

Hopefully Twig, combined with ZF2's modules should allow for this.

## License

MIT Licensed (see [LICENSE][License file]).

[License file]: https://github.com/rmasters/divvy/blob/masters/LICENSE
