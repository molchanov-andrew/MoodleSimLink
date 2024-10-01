<?php

function xmldb_blocks_user_list_upgrade($oldversion): bool {
    global $CFG;

    $result = TRUE;

    if ($oldversion < 2024092500) {

        // Define table block_user_list_expensive to be created.
        $table = new xmldb_table('block_user_list_expensive');

        // Adding fields to table block_user_list_expensive.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('user_id', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, null);
        $table->add_field('user_expensive', XMLDB_TYPE_INTEGER, '20', null, null, null, null);

        // Adding keys to table block_user_list_expensive.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for block_user_list_expensive.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // User_list savepoint reached.
        upgrade_block_savepoint(true, 2024092500, 'user_list');
    }
    return $result;
}
