<?php

use yii\db\Migration;

/**
 * Class m151015_180042_initial
 */
class m151015_180042_initial extends Migration
{
    /**
     * @var string
     */
    public $engine = 'ENGINE=InnoDb DEFAULT CHARSET=utf8';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%file}}', [
            'id' => 'int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'name' => 'varchar(255) NOT NULL',
            'extension' => 'varchar(10) NOT NULL',
            'original_name' => 'varchar(255) NOT NULL',
            'mime_type' => 'varchar(45) NOT NULL',
            'size' => 'int(10) unsigned NOT NULL',
            'created_at' => 'int(10) unsigned NOT NULL',
            'updated_at' => 'int(10) unsigned NOT NULL',
        ], $this->engine);

        $this->createTable('{{%file_attachment}}', [
            'id' => 'int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'file_id' => 'int(10) unsigned NOT NULL',
            'model' => 'varchar(45) NOT NULL',
            'item_id' => 'int(11) NOT NULL',
            'sort' => 'int(10) unsigned NOT NULL',
        ]);
        $this->createIndex('idx_file_attachment', "{{%file_attachment}}", ['file_id', 'model', 'item_id'], true);
        $this->createIndex('idx_file_attachment_file_id', "{{%file_attachment}}", 'file_id', false);
        $this->addForeignKey('fx_file_attachment_file_id', "{{%file_attachment}}", 'file_id', "{{%file}}", 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%currency}}', [
            'code' => 'varchar(10) NOT NULL PRIMARY KEY',
            'name' => 'varchar(255) NOT NULL',
            'is_default' => 'int(10) unsigned NOT NULL',
            'rate' => 'float NOT NULL',
            'symbol' => 'varchar(10) NOT NULL',
        ]);

        $this->createTable('{{%country}}', [
            'id' => 'varchar(10) NOT NULL PRIMARY KEY',
            'name' => 'varchar(255) NOT NULL',
            'currency_code' => 'varchar(10) NOT NULL',
        ],$this->engine);
        $this->createIndex('idx_country_currency_code', "{{%country}}", 'currency_code', false);
        $this->addForeignKey('fx_country_currency_code', "{{%country}}", 'currency_code', "{{%currency}}", 'code', null, 'CASCADE');

        $this->createTable('{{%user}}', [
            'id' => 'int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'email' => 'varchar(255) NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'country_id' => 'varchar(10) NOT NULL',
            'address' => 'varchar(255) NOT NULL',
            'phone' => 'varchar(255) NOT NULL',
            'password_hash' => 'varchar(255) NOT NULL',
            'password_reset_token' => 'varbinary(255)',
            'auth_key' => 'varbinary(32)',
            'status' => 'tinyint unsigned NOT NULL DEFAULT 1',
            'created_at' => 'INT(11) unsigned NOT NULL',
            'updated_at' => 'INT(11) unsigned NOT NULL',
            'role' => 'INT(11) unsigned NOT NULL DEFAULT 1',
        ], $this->engine);
        $this->createIndex('idx_user_email', "{{%user}}", ['email'], true);
        $this->createIndex('idx_user_country_id', "{{%user}}", ['country_id'], false);
        $this->addForeignKey('fx_user_country_id', "{{%user}}", 'country_id', "{{%country}}", 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%user_data}}', [
            'id' => 'int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'user_id' => 'int(10) unsigned NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'data' => 'longtext'
        ],$this->engine);
        $this->createIndex('idx_user_data', "{{%user_data}}", ['user_id', 'name'], true);
        $this->addForeignKey('fx_user_data_user_id', "{{%user_data}}", 'user_id', "{{%user}}", 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%category}}', [
            'id' => 'int(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT',
            'root'  => 'int(10) unsigned DEFAULT NULL',
            'lft' => 'int(10) unsigned NOT NULL',
            'rgt'  => 'int(10) unsigned NOT NULL',
            'lvl'  => 'smallint(5) unsigned NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'slug' => 'varchar(255) NOT NULL',
            'announce' => 'text DEFAULT NULL',
            'description' => 'longtext DEFAULT NULL',
            'created_at' => 'int(10) unsigned DEFAULT NULL',
            'updated_at' => 'int(10) unsigned DEFAULT NULL',
            'status' => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
            'icon' => 'varchar(255) DEFAULT NULL',
            'icon_type' => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
            'active' => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
            'selected' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
            'disabled' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
            'readonly' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
            'visible' => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
            'collapsed' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
            'movable_u' => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
            'movable_d' => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
            'movable_l' => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
            'movable_r' => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
            'removable' => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
            'removable_all' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
        ], $this->engine);
        $this->createIndex('idx_category_root', "{{%category}}", 'root', false);
        $this->createIndex('idx_category_lft', "{{%category}}", 'lft', false);
        $this->createIndex('idx_category_rgt', "{{%category}}", 'rgt', false);
        $this->createIndex('idx_category_lvl', "{{%category}}", 'lvl', false);
        $this->createIndex('idx_category_active', "{{%category}}", 'active', false);

        $this->createTable('{{%product}}', [
            'id' => 'int(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT',
            'category_id' => 'int(10) unsigned NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'slug' => 'varchar(255) NOT NULL',
            'announce' => 'text DEFAULT NULL',
            'description' => 'longtext DEFAULT NULL',
            'created_at' => 'int(10) unsigned DEFAULT NULL',
            'updated_at' => 'int(10) unsigned DEFAULT NULL',
            'status' => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
            'old_price' => 'decimal(10,2) DEFAULT NULL',
            'price' => 'decimal(10,2) NOT NULL DEFAULT 0.00',
            'inventory' => 'int(11) NOT NULL DEFAULT 0',
        ], $this->engine);
        $this->createIndex('idx_product_slug', "{{%product}}", 'slug', true);
        $this->createIndex('idx_product_price', "{{%product}}", 'price', false);
        $this->addForeignKey('fx_product_category_id', "{{%product}}", 'category_id', "{{%category}}", 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%relation}}', [
            'id' => 'int(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT',
            'item_id' => 'int(10) unsigned NOT NULL',
            'related_id' => 'int(10) unsigned NOT NULL',
            'model' => 'varchar(45) NOT NULL',
        ], $this->engine);
        $this->createIndex('idx_product_relation', "{{%relation}}", 'item_id, related_id, model', true);

        $this->createTable('{{%page}}', [
            'id' => 'int(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT',
            'type' => 'varchar(45) NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'slug' => 'varchar(255) NOT NULL',
            'announce' => 'text DEFAULT NULL',
            'content' => 'longtext DEFAULT NULL',
            'created_at' => 'int(10) unsigned DEFAULT NULL',
            'updated_at' => 'int(10) unsigned DEFAULT NULL',
            'status' => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
            'is_system' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
        ], $this->engine);
        $this->createIndex('idx_page_slug', "{{%page}}", 'slug', true);

        $this->createTable('{{%order}}', [
            'id' => 'int(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT',
            'user_id' => 'int(10) unsigned',
            'currency_code' => 'varchar(10) NOT NULL',
            'discount' => 'decimal(10,2) unsigned NOT NULL',
            'name' => 'varchar(255) DEFAULT NULL',
            'country_id' => 'varchar(10) NOT NULL',
            'address' => 'varchar(255) DEFAULT NULL',
            'phone' => 'varchar(255) NOT NULL',
            'email' => 'varchar(255) DEFAULT NULL',
            'comment' => 'longtext DEFAULT NULL',
            'token' => 'varbinary(255) NOT NULL',
            'created_at' => 'int(10) unsigned DEFAULT NULL',
            'updated_at' => 'int(10) unsigned DEFAULT NULL',
            'status' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
        ], $this->engine);
        $this->createIndex('idx_order_user_id', "{{%order}}", 'user_id', false);
        $this->createIndex('idx_order_currency_code', "{{%order}}", 'currency_code', false);
        $this->createIndex('idx_order_country_id', "{{%order}}", 'country_id', false);
        $this->createIndex('idx_order_token', "{{%order}}", 'token', true);
        $this->addForeignKey('fx_order_user_id', "{{%order}}", 'user_id', "{{%user}}", 'id', null, 'CASCADE');
        $this->addForeignKey('fx_order_currency_code', "{{%order}}", 'currency_code', "{{%currency}}", 'code', null, 'CASCADE');
        $this->addForeignKey('fx_order_country_id', "{{%order}}", 'country_id', "{{%country}}", 'id', null, 'CASCADE');

        $this->createTable('{{%order_data}}', [
            'id' => 'int(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT',
            'order_id' => 'int(10) unsigned NOT NULL',
            'product_id' => 'int(10) unsigned NOT NULL',
            'quantity' => 'int(10) unsigned NOT NULL',
            'price' => 'decimal(10,2) unsigned NOT NULL',
        ], $this->engine);
        $this->createIndex('idx_order_data_order_id', "{{%order_data}}", 'order_id', false);
        $this->createIndex('idx_order_data_product_id', "{{%order_data}}", 'product_id', false);
        $this->createIndex('idx_order_data', "{{%order_data}}", 'order_id, product_id', true);
        $this->addForeignKey('fx_order_data_order_id', "{{%order_data}}", 'order_id', "{{%order}}", 'id', null, 'CASCADE');
        $this->addForeignKey('fx_order_data_product_id', "{{%order_data}}", 'product_id', "{{%product}}", 'id', null, 'CASCADE');

        $this->createTable('{{%comment}}', [
            'id' => 'int(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT',
            'product_id' => 'int(10) unsigned NOT NULL',
            'user_id' => 'int(10) unsigned NOT NULL',
            'rating' => 'decimal(10,2) NOT NULL',
            'body' => 'longtext',
            'created_at' => 'int(10) unsigned DEFAULT NULL',
            'updated_at' => 'int(10) unsigned DEFAULT NULL',
            'status' => 'int(10) unsigned NOT NULL',
        ], $this->engine);
        $this->createIndex('idx_comment_product_id', "{{%comment}}", 'product_id', false);
        $this->createIndex('idx_comment_user_id', "{{%comment}}", 'user_id', false);
        $this->addForeignKey('fx_comment_product_id', "{{%comment}}", 'product_id', "{{%product}}", 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fx_comment_user_id', "{{%comment}}", 'user_id', "{{%user}}", 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%comment}}');
        $this->dropTable('{{%order_data}}');
        $this->dropTable('{{%order}}');
        $this->dropTable('{{%page}}');
        $this->dropTable('{{%page}}');
        $this->dropTable('{{%relation}}');
        $this->dropTable('{{%product}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%user_data}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%country}}');
        $this->dropTable('{{%currency}}');
        $this->dropTable('{{%file_attachment}}');
        $this->dropTable('{{%file}}');
    }
}
