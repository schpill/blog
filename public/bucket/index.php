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

    define('DS', DIRECTORY_SEPARATOR);
    define('PS', PATH_SEPARATOR);

    function isAke($tab, $key, $default = null)
    {
        if (is_array($tab)) {
            return array_key_exists($key, $tab) && isset($tab[$key]) ? $tab[$key] : $default;
        }

        return $default;
    }

    function render($args = array())
    {
        header('content-type: application/json; charset=utf-8');

        die(json_encode($args));
    }

    function forbidden($reason = 'NA')
    {
        $infos = array(
            'status'    => 403,
            'message'   => "Forbidden $reason"
        );

        render($infos);
    }

    function success($message)
    {
        $infos = array(
            'status'    => 200,
            'message'   => $message
        );

        render($infos);
    }

    if (!empty($_REQUEST)) {
        $action = isAke($_REQUEST, 'action');

        if(strlen($action)) {
            $bucket = new Bucket($action);
        } else {
            forbidden('no action');
        }
    } else {
        forbidden('no request');
    }

    class Bucket
    {
        private $args;
        private $dir;
        private $bucket;

        public function __construct($action)
        {
            if (!method_exists($this, $action)) {
                forbidden('unknow action ' . $action);
            }

            $this->args = $_REQUEST;
            $bucket = isAke($this->args, 'bucket');

            if (!strlen($bucket)) {
                forbidden('no bucket');
            }

            $dir = realpath(dirname(__FILE__)) . DS . 'data';

            if (!is_dir($dir)) {
                mkdir($dir, 0777);
            }

            $this->dir = $dir . DS . $bucket;

            if (!is_dir($this->dir)) {
                mkdir($this->dir, 0777);
            }

            $this->dir .= '/';
            $this->bucket = $bucket;

            $this->check();

            $this->$action();
        }

        public function __get($key)
        {
            if (isset($this->$key)) {
                return $this->$key;
            }

            return isAke($this->args, $key);
        }

        public function __isset($key)
        {
            if (isset($this->$key)) {
                return true;
            }

            $val = isAke($this->args, $key);

            return strlen($val) > 0 ? true : false;
        }

        public function __set($key, $value)
        {
            $this->args[$key] = $value;

            return $this;
        }

        private function check()
        {
            $expires = glob($this->dir . "expire::*");

            if (!empty($expires)) {
                foreach ($expires as $expire) {
                    $tab = explode("::", $expire);
                    $time = end($tab);

                    if ($time > 0 && $time < time()) {
                        unlink($expire);
                    }
                }
            }
        }

        private function upload()
        {
            $data = isAke($this->args, 'data');

            if (!strlen($data)) {
                forbidden('no data');
            }

            $name = isAke($this->args, 'name');

            if (!strlen($name)) {
                forbidden('no name');
            }

            if (!is_dir($this->dir . 'upload')) {
                mkdir($this->dir . 'upload', 0777);
            }

            $fileData = $this->dir . 'upload/' . $name;
            $url = 'http://' . $_SERVER['SERVER_NAME'] . '/bucket/data/' . $this->bucket . '/upload/' . $name;

            $this->putFile($fileData, $data);

            success($url);
        }

        private function set()
        {
            $key = isAke($this->args, 'key');

            if (!strlen($key)) {
                forbidden('no key');
            }

            $value = isAke($this->args, 'value');

            if (!strlen($value)) {
                forbidden('no value');
            }

            $expire = isAke($this->args, 'expire');

            if (!strlen($expire)) {
                forbidden('no expire');
            }

            $fileData       = $this->dir . $key;
            $fileExpire     = $this->dir . "expire::$key::$expire";

            if ($this->existsFile($fileExpire)) {
                unlink($fileExpire);
            } else {
                $expires = glob($this->dir . "expire::$key::*");

                if (!empty($expires)) {
                    foreach ($expires as $expire) {
                        unlink($expire);
                    }
                }
            }

            if (file_exists($fileData)) {
                unlink($fileData);
            }

            $this->putFile($fileData, $value);
            $this->putFile($fileExpire, "1");

            success(true);
        }

        private function del()
        {
            $key = isAke($this->args, 'key');

            if (!strlen($key)) {
                forbidden('no key');
            }

            $data = false;

            if ($this->existsFile($this->dir . $key)) {
                unlink($this->dir . $key);
                $data = true;
            }

            success($data);
        }

        private function get()
        {
            $key = isAke($this->args, 'key');

            if (!strlen($key)) {
                forbidden('no key');
            }

            $data = null;
            $exists = $this->existsFile($this->dir . $key);

            if (true === $exists) {
                $data = $this->readFile($this->dir . $key);
            }

            success($data);
        }

        private function all()
        {
            $pattern = isAke($this->args, 'pattern');

            if (!strlen($pattern)) {
                forbidden('no pattern');
            }

            $keys = glob($this->dir . $pattern);
            $collection = array();

            if (count($keys)) {
                foreach ($keys as $key) {
                    $data = $this->readFile($key);
                    $key = str_replace($this->dir, '', $key);
                    $collection[$key] = $data;
                }
            }

            success($collection);
        }

        private function keys()
        {
            $pattern = isAke($this->args, 'pattern');

            if (!strlen($pattern)) {
                forbidden('no pattern');
            }

            $keys = glob($this->dir . $pattern);
            $collection = array();

            if (!empty($keys)) {
                foreach ($keys as $key) {
                    $key = str_replace($this->dir, '', $key);
                    array_push($collection, $key);
                }
            }

            success($collection);
        }


        private function createFile($file, $content = null)
        {
            $this->deleteFile($file);

            if (null !== $content) {
                file_put_contents($file, $content, LOCK_EX);
            }

            umask(0000);

            chmod($file, 0777);

            return $create;
        }

        private function appendFile($file, $data)
        {
            $append = file_put_contents($file, $data, LOCK_EX | FILE_APPEND);

            umask(0000);

            chmod($file, 0777);

            return $append;
        }

        private function existsFile($file)
        {
            return file_exists($file);
        }

        private function getFile($file, $default = null)
        {
            return $this->existsFile($file) ? file_get_contents($file) : $default;
        }

        private function putFile($file, $data, $chmod = 0777)
        {
            umask(0000);

            $put = file_put_contents($file, $data, LOCK_EX);

            chmod($file, 0777);

            return $put;
        }

        private function deleteFile($file)
        {
            if (true === $this->exists($file)) {
                $fp = fopen($file, "w");

                if (flock($fp, LOCK_EX)) {
                    $status = unlink($file);
                    fclose($fp);

                    return $status;
                } else {
                    throw new Exception("The file '$file' can not be removed.");
                }
            }

            return false;
        }

        private function readFile($file, $default = false, $mode = 'rb')
        {
            if (true === $this->exists($file)) {
                $fp     = fopen($file, $mode);
                $data   = fread($fp, filesize($file));

                fclose($fp);

                return $data;
            }

            return $default;
        }
    }
