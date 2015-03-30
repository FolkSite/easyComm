<?php
$xpdo_meta_map['ecMessage']= array (
    'package' => 'easycomm',
    'version' => '1.1',
    'table' => 'ec_messages',
    'extends' => 'xPDOSimpleObject',
    'fields' =>
        array (
            'thread' => 0,
            'subject' => '',
            'date' => NULL,
            'user_name' => '',
            'user_email' => '',
            'user_contacts' => '',
            'text' => '',
            'reply_author' => '',
            'reply_text' => '',
            'notify' => 0,
            'createdon' => NULL,
            'createdby' => 0,
            'editedon' => NULL,
            'editedby' => 0,
            'published' => 0,
            'publishedon' => NULL,
            'publishedby' => 0,
            'deleted' => 0,
            'deletedon' => NULL,
            'deletedby' => 0,
            'extended' => NULL,
        ),
    'fieldMeta' =>
        array (
            'thread' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'attributes' => 'unsigned',
                    'null' => false,
                    'default' => 0,
                ),
            'subject' =>
                array (
                    'dbtype' => 'varchar',
                    'precision' => '255',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ),
            'date' =>
                array (
                    'dbtype' => 'datetime',
                    'phptype' => 'datetime',
                    'null' => false,
                ),
            'user_name' =>
                array (
                    'dbtype' => 'varchar',
                    'precision' => '255',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ),
            'user_email' =>
                array (
                    'dbtype' => 'varchar',
                    'precision' => '255',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ),
            'user_contacts' =>
                array (
                    'dbtype' => 'varchar',
                    'precision' => '255',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ),
            'text' =>
                array (
                    'dbtype' => 'text',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ),
            'reply_author' =>
                array (
                    'dbtype' => 'varchar',
                    'precision' => '255',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ),
            'reply_text' =>
                array (
                    'dbtype' => 'text',
                    'phptype' => 'string',
                    'null' => false,
                    'default' => '',
                ),
            'notify' =>
                array (
                    'dbtype' => 'tinyint',
                    'precision' => '1',
                    'attributes' => 'unsigned',
                    'phptype' => 'integer',
                    'null' => false,
                    'default' => 0,
                ),
            'createdon' =>
                array (
                    'dbtype' => 'datetime',
                    'phptype' => 'datetime',
                    'null' => false,
                ),
            'createdby' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 0,
                ),
            'editedon' =>
                array (
                    'dbtype' => 'datetime',
                    'phptype' => 'datetime',
                    'null' => false,
                ),
            'editedby' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 0,
                ),
            'published' =>
                array (
                    'dbtype' => 'tinyint',
                    'precision' => '1',
                    'attributes' => 'unsigned',
                    'phptype' => 'integer',
                    'null' => false,
                    'default' => 0,
                ),
            'publishedon' =>
                array (
                    'dbtype' => 'datetime',
                    'phptype' => 'datetime',
                    'null' => false,
                ),
            'publishedby' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 0,
                ),
            'deleted' =>
                array (
                    'dbtype' => 'tinyint',
                    'precision' => '1',
                    'attributes' => 'unsigned',
                    'phptype' => 'integer',
                    'null' => false,
                    'default' => 0,
                ),
            'deletedon' =>
                array (
                    'dbtype' => 'datetime',
                    'phptype' => 'datetime',
                    'null' => false,
                ),
            'deletedby' =>
                array (
                    'dbtype' => 'int',
                    'precision' => '10',
                    'phptype' => 'integer',
                    'null' => true,
                    'default' => 0,
                ),
            'extended' =>
                array (
                    'dbtype' => 'text',
                    'phptype' => 'json',
                    'null' => true,
                ),
        ),
    'indexes' =>
        array (
            'thread' =>
                array (
                    'alias' => 'thread',
                    'primary' => false,
                    'unique' => false,
                    'type' => 'BTREE',
                    'columns' =>
                        array (
                            'thread' =>
                                array (
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => false,
                                ),
                        ),
                ),
            'deleted' =>
                array (
                    'alias' => 'deleted',
                    'primary' => false,
                    'unique' => false,
                    'type' => 'BTREE',
                    'columns' =>
                        array (
                            'deleted' =>
                                array (
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => false,
                                ),
                        ),
                ),
            'published' =>
                array (
                    'alias' => 'published',
                    'primary' => false,
                    'unique' => false,
                    'type' => 'BTREE',
                    'columns' =>
                        array (
                            'published' =>
                                array (
                                    'length' => '',
                                    'collation' => 'A',
                                    'null' => false,
                                ),
                        ),
                ),
        ),
    'aggregates' =>
        array (
            'Thread' =>
                array (
                    'class' => 'ecThread',
                    'local' => 'thread',
                    'foreign' => 'id',
                    'cardinality' => 'one',
                    'owner' => 'foreign',
                ),
        ),
);
