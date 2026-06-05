<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWaliKelasToKelas extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // Add id_wali_kelas column to tb_kelas
        $this->forge->addColumn('tb_kelas', [
            'id_wali_kelas' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => true,
                'after'      => 'index_kelas',
            ],
        ]);

        // Add foreign key for id_wali_kelas to tb_kelas
        $this->db->query('ALTER TABLE tb_kelas ADD CONSTRAINT fk_tb_kelas_id_wali_kelas FOREIGN KEY (id_wali_kelas) REFERENCES tb_member(id_member) ON UPDATE NO ACTION ON DELETE RESTRICT');

        // Add id_member column to users table (Myth\Auth)
        $this->forge->addColumn('users', [
            'id_member' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'null'       => true,
                'after'      => 'id',
            ],
        ]);

        // Add foreign key for id_member in users table
        $this->db->query('ALTER TABLE users ADD CONSTRAINT fk_users_id_member FOREIGN KEY (id_member) REFERENCES tb_member(id_member) ON UPDATE NO ACTION ON DELETE RESTRICT');
    }

    public function down()
    {
        $db = \Config\Database::connect();

        // Drop foreign keys first
        if ($db->fieldExists('id_member', 'users')) {
            $this->db->query('ALTER TABLE users DROP FOREIGN KEY fk_users_id_member');
            $this->forge->dropColumn('users', 'id_member');
        }

        if ($db->fieldExists('id_wali_kelas', 'tb_kelas')) {
            $this->db->query('ALTER TABLE tb_kelas DROP FOREIGN KEY fk_tb_kelas_id_wali_kelas');
            $this->forge->dropColumn('tb_kelas', 'id_wali_kelas');
        }
    }
}
