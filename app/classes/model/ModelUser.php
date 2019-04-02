<?php

namespace App\Model;

Class ModelUser {

    private $table_name;
    private $db;

    public function __construct(\Core\FileDB $db, $table_name) {
        $this->table_name = $table_name;
        $this->db = $db;
    }

    public function load($id) {
        $data_row = $this->db->getRow($this->table_name, $id);

        if ($data_row) {
            return new \App\User($data_row);
        } else {
            return false;
        }
    }

    public function insert($id, \App\User $user) {
        if (!$this->db->getRow($this->table_name, $id)) {
            $this->db->setRow($this->table_name, $id, $user->getData());
            $this->db->save();

            return true;
        } else {
            return false;
        }
    }

    public function update($id, \App\User $user) {
        if ($this->db->getRow($this->table_name, $id)) {
            $this->db->setRow($this->table_name, $id, $user->getData());
            $this->db->save();

            return true;
        } else {
            return false;
        }
    }

    public function delete($id) {
        if ($this->db->getRow($this->table_name, $id)) {
            $this->db->deleteRow($this->table_name, $id);
            $this->db->save();

            return true;
        } else {
            return false;
        }
    }

    public function loadAll() {
        $user_masyvas = [];

        foreach ($this->db->getRows($this->table_name) as $user) {
            $user_masyvas[] = new \App\User($user);
        }

        return $user_masyvas;
    }

    public function deleteAll() {
        if ($this->db->deleteRows($this->table_name)) {
            $this->db->save();
            return true;
        } else {
            return false;
        }
    }

    public function getCount() {
        $get_count = $this->db->getCount($this->table_name);

        if ($get_count) {
            return $get_count;
        }

        return 0;
    }

}
