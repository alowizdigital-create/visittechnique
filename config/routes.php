<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use PHPUnit\TextUI\CliArguments\Builder;

/*
 * This file is loaded in the context of the `Application` class.
 * So you can use `$this` to reference the application class instance
 * if required.
 */
return function (RouteBuilder $routes): void {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->prefix('Admin', function (RouteBuilder $builder): void {
        $builder->connect('/login', ['controller' => 'Admins', 'action' => 'login']);
        $builder->connect('/logout', ['controller' => 'Admins', 'action' => 'logout']);
        $builder->connect('/admins/logout', ['controller' => 'admins', 'action' => 'logout']);
        $builder->fallbacks(DashedRoute::class);
    });
    
      $routes->prefix('Account', function (RouteBuilder $builder): void {
        $builder->connect('/login', ['controller' => 'Accounts', 'action' => 'login']);
        $builder->connect('/logout', ['controller' => 'Accounts', 'action' => 'logout']);
         $builder->connect('/add', ['controller' => 'Accounts', 'action' => 'add']);
        $builder->connect('/collabots', ['controller' => 'Accounts', 'action' => 'collabots']);
        // $builder->connect('/admins/dashboard', ['controller' => 'Users', 'action' => 'dashboard']);
        $builder->fallbacks(DashedRoute::class);
    });

    $routes->scope('/', function (RouteBuilder $builder): void {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        //  $builder->connect('/connexion', ['controller' => 'Users', 'action' => 'connexion']);
                $builder->connect('/', ['prefix'=>'Account','controller' => 'Accounts', 'action' => 'login']);
        // $builder->connect('/', ['controller' => 'Users', 'action' => 'welcome']);
        $builder->connect('/rootAjaxaddVehicles', ['controller' => 'Users', 'action' => 'addVehicles']);
        $builder->connect('/rootAjaxnewRelance', ['controller' => 'Users', 'action' => 'newRelance']);
        $builder->connect('/rootAjaxConfirmPayment', ['controller' => 'Users', 'action' => 'confirmPayment']);
        $builder->connect('/rootAjaxConfirmRelance', ['controller' => 'Users', 'action' => 'confirmRelance']);
        $builder->connect('/users/search-phone', ['controller' => 'Users', 'action' => 'searchPhone']);
        $builder->connect('/messages/test-send', ['controller' => 'Messages', 'action' => 'testSend']);
        // Nouvelle route pour le tableau de bord d'administration sans préfixe.
        $builder->connect('/accounts/login', ['controller' => 'Accounts', 'action' => 'login']);
        $builder->connect('/users/dashboard', ['controller' => 'Users', 'action' => 'dashboard']);
        
        $builder->connect('/updateloginStardtup',['controller'=>'Startups','action'=>'changeStartup']);
         $builder->connect('/updateloginCenter',['controller'=>'Startups','action'=>'changeCenter']);
         
        $builder->connect('/send-sms', ['controller' => 'Messages', 'action' => 'sendSms']);

        $builder->connect('/send-campaign-sms', ['controller' => 'Messages', 'action' => 'sendCampaignSms']);
        
        /* ' 
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');


         /*
         * ...Les routes ajax.
         */ 
         
        $builder->connect('/cashboxes', ['controller' => 'CashBoxes', 'action' => 'index']);
        
         $builder->connect('/cashboxes/index', ['controller' => 'CashBoxes', 'action' => 'index']);
         
        $builder->connect('/cashboxes/report', ['controller' => 'CashBoxes', 'action' => 'report']);
        
        $builder->connect('/createUser', ['controller' => 'Users', 'action' => 'add', 'home']);

        $builder->connect('/users/login', ['controller' => 'Users', 'action' => 'login']);

        $builder->connect('/account/login', ['controller' => 'Accounts', 'action' => 'login']);
        
        $builder->connect('/admin/login', ['controller' => 'Admins', 'action' => 'login']);
        
        $builder->connect('/account/logout', ['controller' => 'Accounts', 'action' => 'logout']);
       
        $builder->connect('/admin/logout', ['controller' => 'Admins', 'action' => 'logout']);
        
        $builder->connect('/rootNewCashbox', ['controller' => 'CashBoxes', 'action' => 'add']);
        
        $builder->connect('/rootOutTransaction', ['controller' => 'CashBoxes', 'action' => 'outtransact']);
        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * It is NOT recommended to use fallback routes after your initial prototyping phase!
         * See https://book.cakephp.org/5/en/development/routing.html#fallbacks-method for more information
         */
        $builder->fallbacks();
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder): void {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};
