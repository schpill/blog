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

    class MyApp
    {
        public static $request;
        public static $data = [];

        public static function run()
        {
            require_once __DIR__ . DS . 'libs/helpers.php';

            static::config();

            static::tests();

            lib('router')->boot();
        }

        private static function config()
        {
            Config::set('app.module.dir', __DIR__);
            Config::set('app.module.dirstorage', __DIR__ . DS . 'storage');

            lib('app');

            Alias::facade('Run', 'AppLib', 'Thin');

            Run::makeInstance();
        }

        private static function tests()
        {
            // $cursor = Box::Product()->where(['name', 'LIKE', '%e%'])->get()->count();
            // $cursor = Box::Product()->where(['price', '>', 58])->get()->count();

            // vd($cursor);

            // for ($i = 0; $i < 1000; $i++) {
            //     $product = Box::Product()->create([
            //         'name' => Utils::token(),
            //         'price' => rand(20, 999)
            //     ])->save();
            // }

            // vd(Box::Product()->count());
            // dd(Timer::get());

            // dd($product);

            // dd(Box::Product()->get()->count());
            // dd(lib('indexation')->words('Je ne suis pas un héros'));
            // $cursor = Model::Inovibackend()->orderByName()->cursor();
            // $cursor = Model::Inovituple()->orderByName()->cursor();

            // foreach ($cursor as $row) {
            //     dd($row);
            // }
            // $tuples = $sirets = [];

            // $cursor = Model::Inovibackend()->cursor();

            // $db = Model::Inovibackend();

            // foreach ($cursor as $row) {
            //     if (!in_array($row['siret'], $sirets)) {
            //         $sirets[] = $row['siret'];
            //     } else {
            //         $id = $row['id'];
            //         unset($row['id']);
            //         unset($row['_id']);
            //         unset($row['created_at']);
            //         unset($row['updated_at']);
            //         $tuples[] = $row;

            //         $d = $db->find((int) $id)->delete();
            //     }
            // }

            // dd($d);
            // dd($d);

            // $db = Model::Inovituple();

            // foreach ($tuples as $tuple) {
            //     $row = $db->create($tuple)->save();
            // }

            // dd($row);

            // dd(lib('object'));
            // dd(apcu_exists('r'));
            // $sp = lib('serviceprovider', ['test'])->register(function () {
            //     return true;
            // });

            // dd($sp);
            // $db = IData::InoviProduct();

//             $b = $db->create();
// // //
//             $b->truc = 100;$b->save();

            // vd($db->where(['truc', '>', 1])->where(['truc', '<', 200])->get()->toJson());
            // dd(Timer::get());
            // $treeBuilder = new TreeBuilder();
            // $rootNode    = $treeBuilder->root('inovi');

            // dd(
            //     $rootNode->children()
            //         ->arrayNode('database')
            //     ->end()
            // );
            // $db = Model::Inovibackend();

            // $idps = file('data/idp.txt');

            // foreach ($idps as $idp) {
            //     $idp = trim($idp);

            //     $row = IDb::Prospect()->find((int) $idp)->toArray();

            //     $row['phone']           = $row['tel'];
            //     $row['name']            = $row['nom'];
            //     $row['city']            = $row['ville'];
            //     $row['lng']             = (double) $row['lng'];
            //     $row['lat']             = (double) $row['lat'];
            //     $row['zip']             = (string) $row['cp'];
            //     $row['address']         = (string) $row['adresse'];
            //     $row['cat']             = (string) $row['categorie'];
            //     $row['company_name']    = (string) $row['raison_sociale'];
            //     $row['user_name']       = (string) $row['user_nom'];
            //     $row['user_firstname']  = (string) $row['user_prenom'];
            //     $row['employees']       = (string) $row['effectif'];

            //     unset($row['tel']);
            //     unset($row['nom']);
            //     unset($row['ville']);
            //     unset($row['cp']);
            //     unset($row['adresse']);
            //     unset($row['categorie']);
            //     unset($row['raison_sociale']);
            //     unset($row['user_nom']);
            //     unset($row['user_prenom']);
            //     unset($row['effectif']);

            //     unset($row['hash']);
            //     unset($row['timestamp']);
            //     unset($row['id']);

            //     ksort($row);

            //     $dbRow = $db->firstOrCreate(['prospect_id' => (int) $idp]);

            //     foreach ($row as $k => $v) {
            //         if ($k == 'siret') {
            //             $v = (string) '[' . $v . ']';
            //         }

            //         $dbRow->$k = $v;
            //     }

            //     $dbRow->save();
            // }
            // dd($dbRow);
            // dd(IApp::token());
            // $role = IModel::Role()->create([
            //     'name' => 'Admin',
            //     'label' => 'ADMIN'
            // ])->save();

            // $db = IModel::Account();

            // $account = $db->create([
            //     'role_id'   => (int) $role->id,
            //     'email'     => 'n.barbieri@inovigroupe.com',
            //     'password'  => password_hash('inovi2015', PASSWORD_DEFAULT),
            //     'name'      => 'Barbieri',
            //     'firstname' => 'Nicolas'
            // ])->save();

            // $account = $db->create([
            //     'role_id'   => (int) $role->id,
            //     'email'     => 'j.ulmann@inovigroupe.com',
            //     'password'  => password_hash('inovi2015', PASSWORD_DEFAULT),
            //     'name'      => 'Ulmann',
            //     'firstname' => 'Julien'
            // ])->save();

            // $account = $db->create([
            //     'role_id'   => (int) $role->id,
            //     'email'     => 'b.bourgogne@inovigroupe.com',
            //     'password'  => password_hash('inovi2015', PASSWORD_DEFAULT),
            //     'name'      => 'Bourgogne',
            //     'firstname' => 'Benoît'
            // ])->save();

            // $account = $db->create([
            //     'role_id'   => (int) $role->id,
            //     'email'     => 'g.plusquellec@inovigroupe.com',
            //     'password'  => password_hash('inovi2015', PASSWORD_DEFAULT),
            //     'name'      => 'Plusquellec',
            //     'firstname' => 'Gérald'
            // ])->save();

            // $account = $db->create([
            //     'role_id'   => (int) $role->id,
            //     'email'     => 'pe.remy@inovigroupe.com',
            //     'password'  => password_hash('inovi2015', PASSWORD_DEFAULT),
            //     'name'      => 'Rémy',
            //     'firstname' => 'Pierre-Emmanuel'
            // ])->save();

            // $account = $db->create([
            //     'role_id'   => (int) $role->id,
            //     'email'     => 'adv@inovigroupe.com',
            //     'password'  => password_hash('inovi2015', PASSWORD_DEFAULT),
            //     'name'      => 'Avons',
            //     'firstname' => 'Victor'
            // ])->save();

            // dd($account);
        }
    }
