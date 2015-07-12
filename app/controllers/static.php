<?php
    /**
    * Thin is a swift Framework for PHP 5.4+
    *
    * @package    Thin
    * @version    1.0
    * @author     Gerald Plusquellec
    * @license    BSD License
    * @copyright  1996 - 2015 Gerald Plusquellec
    * @link       http://github.com/schpill/thin
    */

    namespace Thin;

    class BlogStaticController extends Controller
    {
        public function __construct($action)
        {
            $this->_name = 'static';

            if ($action == 404) {
                RouterLib::is404();
            }

            $method = Request::method();

            $this->action = $action;

            $action = Inflector::lower($method) . ucfirst(
                Inflector::camelize(
                    strtolower($action)
                )
            );

            $methods = get_class_methods($this);

            if (in_array($action, $methods)) {
                $this->session = session(SITE_NAME);
                $this->$action();
            } else {
                RouterLib::is404();
            }
        }

        public function getHome()
        {
            $this->title = 'Bienvenue';
        }
    }
