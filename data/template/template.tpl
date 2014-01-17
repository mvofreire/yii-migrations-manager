<?php

class {ClassName} extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        return true;
    }

    public function safeDown()
    {
        return true;
    }
}