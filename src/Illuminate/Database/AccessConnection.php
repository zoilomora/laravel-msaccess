<?php

namespace ZoiloMora\Illuminate\Database;

use Illuminate\Database\Connection as BaseConnection;
use ZoiloMora\Doctrine\DBAL\Driver\Access\Driver as DoctrineDriver;

class AccessConnection extends BaseConnection
{
    /**
     * Connection constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $dsn = $this->getDsn($config);

        $pdo = new \ZoiloMora\Doctrine\DBAL\Driver\Access\AccessConnection($dsn);

        parent::__construct($pdo, '', '', $config);
        $this->createConnection($pdo);

        if(array_key_exists('table_prefix', $config)) {
            $this->setTablePrefix($config['table_prefix']);
        }
    }

    /**
     * Create a DSN string from a configuration.
     *
     * @param  array $config
     * @return string
     */
    protected function getDsn(array $config)
    {
        $dsn = trim('odbc:'.$config['connection_string']);

        if(substr($dsn, -1) !== ';') {
            $dsn .= ';';
        }

        return $dsn;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultQueryGrammar()
    {
        return new \ZoiloMora\Illuminate\Database\Query\Grammars\AccessGrammar();
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultPostProcessor()
    {
        return new \ZoiloMora\Illuminate\Database\Query\Processors\AccessProcessor();
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultSchemaGrammar()
    {
        return new \ZoiloMora\Illuminate\Database\Schema\Grammars\AccessGrammar();
    }

    /**
     * Connection creation
     *
     * @param \PDO $pdo
     */
    protected function createConnection($pdo)
    {
        $params = [
            'user' => $this->config['username'],
            'password' => $this->config['password'],
            'pdo' => $pdo,
            'driverClass' => DoctrineDriver::class,
        ];
        $this->doctrineConnection = \Doctrine\DBAL\DriverManager::getConnection($params);
    }

    /**
     * @inheritdoc
     */
    public function getDriverName()
    {
        return 'pdo_access';
    }

    /**
     * Get the Doctrine DBAL driver.
     *
     * @return \ZoiloMora\Doctrine\DBAL\Driver\Access\Driver
     */
    protected function getDoctrineDriver()
    {
        return new DoctrineDriver;
    }
}