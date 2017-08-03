<?php

namespace ZoiloMora\Doctrine\DBAL\Platforms;

use ZoiloMora\Doctrine\DBAL\Platforms\Keywords\AccessKeywords;
use Doctrine\DBAL\Platforms\SQLServerPlatform;

class AccessPlatform extends SQLServerPlatform
{
    /**
     * {@inheritDoc}
     */
    protected function getReservedKeywordsClass()
    {
        return AccessKeywords::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getListTablesSQL()
    {
        return 'SELECT MSysObjects.Name, MSysObjects.Type, MSysObjects.Flags FROM MSysObjects ORDER BY MSysObjects.Name';
    }
}
