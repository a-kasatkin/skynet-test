<?php


namespace App\Kernel\Provider;


use App\Application;

class DatabaseServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Application $app): void
    {
        $app['db'] = function ($app) {
            return new \PDO(
                $this->constructPdoDsn($app['db.options']),
                $app['db.options']['user'],
                $app['db.options']['password']
            );
        };
    }

    /**
     * @param array $params
     * @return string
     */
    protected function constructPdoDsn(array $params): string
    {
        $dsn = 'mysql:';
        if (isset($params['host']) && $params['host'] != '') {
            $dsn .= 'host=' . $params['host'] . ';';
        }
        if (isset($params['port'])) {
            $dsn .= 'port=' . $params['port'] . ';';
        }
        if (isset($params['dbname'])) {
            $dsn .= 'dbname=' . $params['dbname'] . ';';
        }
        if (isset($params['charset'])) {
            $dsn .= 'charset=' . $params['charset'] . ';';
        }

//        var_dump($params['user']);die;

        return $dsn;
    }
}