<?php

namespace App\Model;

/**
 * Class for working between database class and "Gerimai" class.
 */
Class ModelGerimai {

    /**
     *
     * @var type string Name of a table
     */
    private $table_name;

    /**
     *
     * @var type Class FileDB class
     */
    private $db;

    public function __construct(\Core\FileDB $db, $table_name) {
        $this->table_name = $table_name;
        $this->db = $db;
    }

    /**
     * Loads the specific drink from given ID
     * @param type string $id
     * @return boolean|\App\Item\Gerimas object.
     */
    public function load($id) {
        $data_row = $this->db->getRow($this->table_name, $id);

        if ($data_row) {
            return new \App\Item\Gerimas($data_row);
        } else {
            return false;
        }
    }

    /**
     * Checks if row by this ID exists and Inserts specific row into given table and saves it.
     * @param type string $id
     * @param \App\Item\Gerimas $gerimas Class
     * @return boolean
     */
    public function insert($id, \App\Item\Gerimas $gerimas) {
        if (!$this->db->getRow($this->table_name, $id)) {
            $this->db->setRow($this->table_name, $id, $gerimas->getData());
            $this->db->save();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if row by this ID exists and Updates specific row into given table and saves it.
     * @param type string $id
     * @param \App\Item\Gerimas $gerimas Class
     * @return boolean
     */
    public function update($id, \App\Item\Gerimas $gerimas) {
        if ($this->db->getRow($this->table_name, $id)) {
            $this->db->setRow($this->table_name, $id, $gerimas->getData());
            $this->db->save();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes given row by the ID and saves into the database.
     * @param type string $id
     * @return boolean
     */
    public function delete($id) {
        if ($this->db->getRow($this->table_name, $id)) {
            $this->db->deleteRow($this->table_name, $id);
            $this->db->save();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Loads all the rows from given table as array of objects.
     * @return \App\Item\Gerimas[]
     */
    public function loadAll() {
        $gerimu_masyvas = [];

        foreach ($this->db->getRows($this->table_name) as $gerimas) {
            $gerimu_masyvas[] = new \App\Item\Gerimas($gerimas);
        }

        return $gerimu_masyvas;
    }

    /**
     * Deletes all the rows from the given table, and saves into the database.
     * @return boolean
     */
    public function deleteRows() {
        if ($this->db->deleteRows($this->table_name)) {
            $this->db->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes whole given table and saves it into the database.
     * @return boolean
     */
    public function deleteTable() {
        if ($this->db->deleteTable($this->table_name)) {
            $this->db->save();
            return true;
        } else {
            return false;
        }
    }

}
