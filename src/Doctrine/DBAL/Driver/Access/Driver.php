<?php

namespace ZoiloMora\Doctrine\DBAL\Driver\Access;

use ZoiloMora\Doctrine\DBAL\Platforms\AccessPlatform;
use ZoiloMora\Doctrine\DBAL\Schema\AccessSchemaManager;

class Driver implements \Doctrine\DBAL\Driver
{
    protected $params = [];

    /**
     * {@inheritdoc}
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = array())
    {
        $this->params = $params;

        return new AccessConnection(
            $this->getDsn($params),
            $username,
            $password,
            $driverOptions
        );
    }

    /**
     * Create a DSN string from a configuration.
     *
     * @param  array $config
     * @return string
     */
    private function getDsn(array $config)
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
    public function getDatabasePlatform()
    {
        return new AccessPlatform();
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(\Doctrine\DBAL\Connection $conn)
    {
        return new AccessSchemaManager($conn);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pdo_access';
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabase(\Doctrine\DBAL\Connection $conn)
    {
        return $this->params['name'];
    }
}