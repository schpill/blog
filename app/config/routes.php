<?php
    namespace Thin;

    class AppRoutes
    {
        public static function defines($router)
        {
            $router->getPost('/', function () {
                return ['static', 'home'];
            });

            $router->getPost('/home', function () {
                return ['static', 'home'];
            });

            $router->getPost('/index', function () {
                return ['static', 'home'];
            });
        }
    }
