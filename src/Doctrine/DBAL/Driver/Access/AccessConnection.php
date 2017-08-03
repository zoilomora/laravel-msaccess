<?php

namespace ZoiloMora\Doctrine\DBAL\Driver\Access;

class AccessConnection extends \Doctrine\DBAL\Driver\PDOConnection implements \Doctrine\DBAL\Driver\Connection
{
    /**
     * Indicates whether it supports native transactions
     * @var bool
     */
    protected $_pdoTransactionsSupport = null;

    /**
     * {@inheritdoc}
     */
    public function __construct($dsn, $user = null, $password = null, $options = null)
    {
        parent::__construct($dsn, $user, $password, $options);
        $this->setAttribute(\PDO::ATTR_STATEMENT_CLASS, array(AccessStatement::class, array()));
    }

    /**
     * {@inheritdoc}
     */
    public function quote($value, $type = \PDO::PARAM_STR)
    {
        $val = parent::quote($value, $type);
        // Fix for a driver version terminating all values with null byte
        if (strpos($val, "\0") !== false) {
            $val = substr($val, 0, -1);
        }
        return $val;
    }

    /**
     * {@inheritdoc}
     */
    public function beginTransaction()
    {
        if ($this->_pdoTransactionsSupported() === true) {
            parent::beginTransaction();
        } else {
            $this->exec('BEGIN TRANSACTION');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function commit()
    {
        if ($this->_pdoTransactionsSupported() === true) {
            parent::commit();
        } else {
            $this->exec('COMMIT TRANSACTION');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rollback()
    {
        if ($this->_pdoTransactionsSupported() === true) {
            parent::rollback();
        } else {
            $this->exec('ROLLBACK TRANSACTION');
        }
    }

    /**
     * Gets support for native transactions
     *
     * @return bool
     */
    private function _pdoTransactionsSupported()
    {
        if (!is_null($this->_pdoTransactionsSupport)) {
            return $this->_pdoTransactionsSupport;
        }

        try {
            $supported = true;
            parent::beginTransaction();
        } catch (\PDOException $e) {
            $supported = false;
        }

        if ($supported) {
            parent::commit();
        }

        return $this->_pdoTransactionsSupport = $supported;
    }
}