<?php

namespace ZoiloMora\Doctrine\DBAL\Schema;

use Doctrine\DBAL\Schema\SQLServerSchemaManager;

class AccessSchemaManager extends SQLServerSchemaManager
{
    /**
     * {@inheritdoc}
     */
    protected function _getPortableTablesList($tables)
    {
        $list = [];
        foreach ($tables as $value) {
            if(substr($value['Name'], 0, 1) !== "~" &&
                substr($value['Name'], 0, 4) !== "MSys" &&
                in_array($value['Type'], [1, 4, 6]) &&
                $value['Flags'] == 0) {
                $list[] = $value['Name'];
            }
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function listTableColumns($table, $database = null)
    {
        return [];
    }
}
