<?php

$context->import('halo_base.context.php');

/**
 * Lithe dispatcher
 * 
 * The Lithe dispatcher is (currently) nothing special.
 * 
 * It just masks Halo so "Lithe" users can be blissfully
 * unaware of Halo if they choose to be.
 */
$context->add('lithe.dispatcher', array(
    'parent' => 'halo.dispatcher',
    'dependencies' => array(
        'lithe.defaultHandlerMapping',
        'lithe.viewResolver',
    ),
));

/**
 * Lithe controller handler adapter
 */
$context->add('lithe.controllerHandlerAdapter', array(
    'className' => 'lithe_ControllerHandlerAdapter',
));

/**
 * Class loader for Lithe controllers
 */
$context->add('lithe.controllers.classLoader', array(
    'className' => 'substrate_ResourceLocatorClassLoader',
    'constructorArgs' => array(
        'resourceLocator' => $context->ref('lithe.controllers.resourceLocator'),
    ),
));

/**
 * Default handler mapping
 */
$context->add('lithe.defaultHandlerMapping', array(
    'className' => 'lithe_DefaultHandlerMapping',
    'constructorArgs' => array(
        'configuration' => $context->ref('lithe.controllers.configuration'),
        'classLoader' => $context->ref('lithe.controllers.classLoader'),
    ),
    'dependencies' => array(
        'lithe.controllerHandlerAdapter',
    ),
));

/**
 * Default parent controller
 */
$context->add('lithe.controllers.defaultParentController', array(
    'className' => 'lithe_AbstractEmptyController',
    'abstract' => true,
));

/**
 * View resolver
 */
$context->add('lithe.viewResolver', array(
    'className' => 'halo_ResourceLocatorViewResolver',
    'constructorArgs' => array(
        'resourceLocator' => $context->ref('lithe.views.resourceLocator'),
    ),
    'properties' => array(
        'viewClass' => '${lithe.views.default.class}',
        'suffix' => '${lithe.views.default.suffix}',
        'dependencyMap' => array(
            'halo_SkittleView' => array(
                'lithe.view.skittle.resourceLocator'
            ),
        ),
    ),
));

/**
 * Resource locator for Skittle view
 *
 * Used for sub views.
 */
$context->add('lithe.view.skittle.resourceLocator', array(
    'className' => 'halo_skittle_SubstrateResourceLocatorAdapter',
    'constructorArgs' => array(
        'resourceLocator' => $context->ref('lithe.views.resourceLocator'),
    ),
));