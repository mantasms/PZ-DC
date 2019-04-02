<?php

namespace App\Item;

/**
 * Class for creating drinks with specific data.
 */
Class Gerimas {

    /** @var array Array of data */
    private $data;

    /**
     * 
     * @param type $data
     */
    public function __construct($data = null) {
        if (!$data) {
            $this->data = [
                'name' => null,
                'amount_ml' => null,
                'abarot' => null,
                'image' => null
            ];
        } else {
            $this->setData($data);
        }
    }

    /**
     * Sets the name value.
     * @param string $name
     */
    public function setName(string $name) {
        $this->data['name'] = $name;
    }

    /**
     * Sets the amount value.
     * @param int $amount
     */
    public function setAmount(int $amount) {
        $this->data['amount_ml'] = $amount;
    }

    /**
     * Sets the abarot value.
     * @param float $abarot
     */
    public function setAbarot(float $abarot) {
        $this->data['abarot'] = $abarot;
    }

    /**
     * Sets the image of given object.
     * @param string $image
     */
    public function setImage(string $image) {
        $this->data['image'] = $image;
    }

    /**
     * Gets the name of given object.
     * @return string
     */
    public function getName() {
        return $this->data['name'];
    }

    /**
     * Gets the amount of given object.
     * @return float
     */
    public function getAmount() {
        return $this->data['amount_ml'];
    }

    /**
     * Gets the abarot of given object.
     * @return int
     */
    public function getAbarot() {
        return $this->data['abarot'];
    }

    /**
     * Gets the image of given object.
     * @return string
     */
    public function getImage() {
        return $this->data['image'];
    }

    /**
     * Sets the given data array by the indexes into the object.
     * @param array $data
     */
    public function setData(array $data) {
        $this->setName($data['name'] ?? '');
        $this->setAmount($data['amount_ml'] ?? 0);
        $this->setAbarot($data['abarot'] ?? 0);
        $this->setImage($data['image'] ?? '');
    }

    /**
     * Gets the all objects data.
     * @return type array
     */
    public function getData() {
        return $this->data;
    }

}
