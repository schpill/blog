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

    use Thin\Container;
    use Thin\Arrays;
    use Thin\Inflector;
    use Thin\Utils;
    use Thin\Database\Collection;
    use Thin\Bucket;
    use Thin\Session;
    use Thin\Option;
    use Thin\Phonetic as Phonetik;
    use Thin\Instance;
    use Thin\Config;
    use Thin\Exception;
    use Thin\Sessionstore;
    use Thin\File;
    use Thin\Model;
    use Thin\Em;
    use Thin\Fly;
    use Thin\Mail\Message;
    use Thin\Mail\Mandrill;
    use Illuminate\Database\Capsule\Manager as DB;
    use Dbjson\Dbjson as DBJ;
    use Dbredis\Caching;
    use Elasticsearch\Client as ESC;
    use Swift_Message as SM;
    use Zelift\Request as ZRequest;
    use MongoClient as MC;
    use MongoCollection as MColl;
    use MongoRegex as MRgx;
    use Phalcon\Cache\Frontend\Data as DataFrontend;
    use Phalcon\Cache\Backend\Apc as ApcCache;
    use Phalcon\DI\FactoryDefault as DI;
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler as SH;
    use Monolog\Handler\RedisHandler as RH;
    use Monolog\Formatter\LineFormatter as LF;

    function loadRun($lib, $args = null)
    {
        try {
            run($lib, $args);

            return true;
        } catch (Excexption $e) {
            return false;
        }
    }

    function run($lib, $args = null)
    {
        $lib    = Inflector::lower(Inflector::uncamelize($lib));
        $script = str_replace('_', DS, $lib) . '.php';

        if (fnmatch('*_*', $lib)) {
            $class  = 'Thin\\' . str_replace('_', '\\', $lib);
            $tab    = explode('\\', $class);
            $first  = $tab[1];
            $class  = str_replace('Thin\\' . $first, 'Thin\\' . ucfirst($first) . 'Libs', $class);

            if (count($tab) > 2) {
                for ($i = 2; $i < count($tab); $i++) {
                    $seg    = trim($tab[$i]);
                    $class  = str_replace('\\' . $seg, '\\' . ucfirst($seg), $class);
                }
            }
        } else {
            $class = 'Thin\\' . ucfirst($lib) . 'Libs';
        }

        $file = __DIR__ . DS . 'libs' . DS . $script;

        if (is_file($file)) {
            require_once $file;

            if (empty($args)) {
                return new $class;
            } else {
                if (!is_array($args)) {
                    if (is_string($args)) {
                        if (fnmatch('*,*', $args)) {
                            $args = explode(',', str_replace(', ', ',', $args));
                        } else {
                            $args = [$args];
                        }
                    } else {
                        $args = [$args];
                    }
                }

                $methods = get_class_methods($class);

                if (in_array('instance', $methods)) {
                    return call_user_func_array([$class, 'instance'], $args);
                } else {
                    return construct($class, $args);
                }
            }
        }

        if (class_exists('Thin\\' . $lib)) {
            $c = 'Thin\\' . $lib;

            return new $c;
        }

        if (class_exists($lib)) {
            return new $lib;
        }

        throw new Exception("The library $class does not exist.");
    }

    function fRun($lib, $function, array $args = [])
    {
        return call_user_func_array([run($lib), $function], $args);
    }
