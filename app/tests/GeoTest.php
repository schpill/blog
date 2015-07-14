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

    class GeoTest extends Test
    {
        public function __construct()
        {
            parent::setUp();
        }

        /**
         * test coords
         *
         * @return void
         */
        public function testCoords()
        {
            $coords = lib('geo')->getCoords('1 place darcy 21000 dijon', 250, false);

            $this->assertTrue(is_array($coords));

            $lat = isAke($coords, 'lat', false);
            $lng = isAke($coords, 'lng', false);

            $this->assertTrue($lat !== false);
            $this->assertTrue($lng !== false);
            $this->assertTrue($lat == '47.324147');
            $this->assertTrue($lng == '5.034248');

            $coords = lib('geo')->getCoordsMap('1 place darcy 21000 dijon');

            $this->assertTrue(is_array($coords));

            $lat = isAke($coords, 'lat', false);
            $lng = isAke($coords, 'lng', false);

            $this->assertTrue($lat !== false);
            $this->assertTrue($lng !== false);

            $this->assertTrue($lat == '47.3231365');
            $this->assertTrue($lng == '5.0347471');
        }
    }
