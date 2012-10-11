<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initViewSettings()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');

        $view->setEncoding('UTF-8');
        $view->headTitle('Knowledge is Power')->setSeparator(' | ');
    }

    public function _initRouteSettings()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini');

        $router->addConfig($config, 'routes');
    }

    protected function _initAutoloader()
    {
        $autoLoader = Zend_Loader_Autoloader::getInstance();
        $autoLoader->setFallbackAutoloader(true);  // :-)
    }

    public function _initRegisterAcl()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new AclPlugin());
    }

    public function _initHelpers()
    {
        Zend_Controller_Action_HelperBroker::addPath(
                    APPLICATION_PATH .'/controllers/helpers', 'My_Controller_Action_Helper');
    }

    public function _initDb()
    {
        $params = array(
            'host'     => get_cfg_var('zend_developer_cloud.db.host') ?: 'localhost',
            'dbname'   => get_cfg_var('zend_developer_cloud.db.name') ?: 'ecom1_zf',
            'username' => get_cfg_var('zend_developer_cloud.db.username') ?: 'root',
            'password' => get_cfg_var('zend_developer_cloud.db.password') ?: 'beer',            
            'charset'  => 'UTF8');

        $db = Zend_Db::factory('PDO_MYSQL', $params);
        Zend_DB_Table_Abstract::setDefaultAdapter($db);
    }

}