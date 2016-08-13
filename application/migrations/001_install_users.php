<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_users extends CI_Migration {

	public function up()
	{
		$this->dropAndCreateUsersTable();
	}

	public function down()
	{
        $this->dropTableIfExists('users');
	}

    private function dropTableIfExists($tableName)
    {
        $this->dbforge->drop_table($tableName, TRUE);
    }

    private function dropAndCreateUsersTable()
    {
        $this->dropTableIfExists('users');

        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'first_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '16',
                'null' => TRUE
            ),
            'last_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '16',
                'null' => TRUE
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => '64',
            ),
            'token' => array(
                'type' => 'VARCHAR',
                'constraint' => '32',
                'null' => TRUE
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '16',
            ),
            'photo' => array(
                'type' => 'VARCHAR',
                'constraint' => '128',
                'null' => TRUE
            ),
            'whats_up' => array(
                'type' => 'VARCHAR',
                'constraint' => '32',
                'null' => TRUE
            ),
            'active' => array(
                'type' => 'BOOLEAN',
                'default' => 0
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');
    }
}
