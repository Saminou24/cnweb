<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initAutoload() {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath' => APPLICATION_PATH,
        ));
        return $autoloader;
    }

    //init db
    protected function _initDb() {
        $opts = $this->getOption('resources');
        $opts = $opts['db']; //db config

        $db = Zend_Db::factory($opts['adapter'], $opts['params']);
        $db->setFetchMode(Zend_Db::FETCH_ASSOC);
        $db->query("set names 'utf8'");
        $db->query("set character set 'utf8'");

        //register
        //Zend_Registry::set('db', $db);

        //** set default adapter
        Zend_Db_Table::setDefaultAdapter($db);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        //end setup
//        if (APPLICATION_ENV == 'development') {
//            $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
//            $profiler->setEnabled(true);
//            $dbAdapter->setProfiler($profiler);
//        }
    }

    protected function _initControl() {
        $front = Zend_Controller_Front::getInstance();
        $front->addModuleDirectory(APPLICATION_PATH . "/modules");


        //routing confing
        $config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/route.ini", "route");
        $router = new Zend_Controller_Router_Rewrite();
        $router->addConfig($config, 'routes');

        $front->setRouter($router);
    }

}

