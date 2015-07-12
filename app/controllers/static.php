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
            $method         = Request::method();
            $this->_name    = 'static';
            $this->session  = session(SITE_NAME);
            $this->me       = lib('me');
            $this->action   = $action;
            $this->bucket   = new Bucket(SITE_NAME, URLSITE . 'bucket');

            if ($action == 404) {
                $this->routing();
            } else {
                $action = Inflector::lower($method) . ucfirst(
                    Inflector::camelize(
                        strtolower($action)
                    )
                );

                $methods = get_class_methods($this);

                if (in_array($action, $methods)) {
                    $this->$action();
                } else {
                    RouterLib::is404();
                }
            }
        }

        private function routing()
        {
            $this->action = 'home';
            // dd($_SERVER['REQUEST_URI']);
        }

        public function getHome()
        {
            $this->title = 'Bienvenue';
        }
    }
