<?php

use yii\db\Migration;

class m150320_102452_message_table extends Migration
{
    const MESSAGE_TABLE = '{{%message}}';
    const MESSAGE_SOURCE_TABLE = '{{%message_source}}';
    
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable(self::MESSAGE_SOURCE_TABLE, [
            'id' => $this->primaryKey(),
            'category' => $this->string(32)->notNull(),
            'message' => $this->string(255),
            'immutable' => $this->integer(1)->defaultValue(0),
        ], $tableOptions);
         $this->createIndex('unique_message_idx', self::MESSAGE_SOURCE_TABLE, ['category', 'message'], true);

        $this->createTable(self::MESSAGE_TABLE, [
            'id' => $this->primaryKey(),
            'source_id' => $this->integer(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text(),
        ], $tableOptions);

        $this->createIndex('message_index', self::MESSAGE_TABLE, ['source_id', 'language']);
        $this->addForeignKey('fk_message_source_message', self::MESSAGE_TABLE, 'source_id', self::MESSAGE_SOURCE_TABLE, 'id', 'CASCADE', 'RESTRICT');

    }

    public function down()
    {
        $this->dropForeignKey('fk_message_source_message', self::MESSAGE_TABLE);

        $this->dropTable(self::MESSAGE_TABLE);
        $this->dropTable(self::MESSAGE_SOURCE_TABLE);

    }
}