<?php

namespace Database\Traits;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait MigrationTrait
{
    /**
     * @param Blueprint $table
     * @param mixed $name
     * @return bool
     */
    public function dropIndexIfExist(Blueprint $table, $name)
    {
        if ($this->indexExists($table, $name)) {
            return $table->dropIndex($name) && true;
        }

        return false;
    }

    /**
     * @param Blueprint $table
     * @param string $oldName
     * @param mixed $newName
     * @return bool
     */
    public function renameIndexIfExist(Blueprint $table, string $oldName, string $newName)
    {
        if ($this->indexExists($table, $oldName)) {
            return $table->renameIndex($oldName, $newName) && true;
        }

        return false;
    }

    /**
     * @param Blueprint $table
     * @param string $name
     * @return bool
     */
    public function dropForeignKeyIfExist(Blueprint $table, string $name)
    {
        if ($this->foreignKeyExists($table, $name)) {
            return $table->dropForeign($name) && true;
        }

        return false;
    }

    /**
     * @param Blueprint $table
     * @param mixed $name
     * @return bool
     */
    private function indexExists(Blueprint $table, $name)
    {
        $doctrineTable = $this->getDoctrineTable($table);

        return $doctrineTable->hasIndex($name) || $doctrineTable->hasColumn($name);
    }

    /**
     * @param Blueprint $table
     * @param mixed $name
     * @return bool
     */
    private function foreignKeyExists(Blueprint $table, $name)
    {
        return $this->getDoctrineTable($table)->hasForeignKey($name);
    }

    /**
     * @param Blueprint $table
     * @return Table
     * @throws Exception
     */
    private function getDoctrineTable(Blueprint $table): Table
    {
        return Schema::getConnection()->getDoctrineSchemaManager()->listTableDetails($table->getTable());
    }
}
