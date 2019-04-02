<?php

namespace App;

Class User {

    private $data;

    const ORIENTATION_GAY = 'g';
    const ORIENTATION_STRAIGHT = 's';
    const ORIENTATION_BISEXUAL = 'b';
    const GENDER_MALE = 'm';
    const GENDER_FEMALE = 'f';

    public function __construct($data = null) {
        if (!$data) {
            $this->data = [
                'username' => null,
                'email' => null,
                'full_name' => null,
                'age' => null,
                'gender' => null,
                'orientation' => null,
                'photo' => null,
            ];
        } else {
            $this->setData($data);
        }
    }

    public function setUserName(string $name) {
        $this->data['username'] = $name;
    }

    public function setEmail(string $email) {
        $this->data['email'] = $email;
    }

    public function setFullName(string $full_name) {
        $this->data['full_name'] = $full_name;
    }

    public function setAge(int $age) {
        $this->data['age'] = $age;
    }

    public function setGender(string $gender) {
        if (in_array($gender, [$this::GENDER_MALE, $this::GENDER_FEMALE])) {
            $this->data['gender'] = $gender;
        }
    }

    public function setOrientation(string $orientation) {
        if (in_array($orientation, [
                    $this::ORIENTATION_GAY,
                    $this::ORIENTATION_STRAIGHT,
                    $this::ORIENTATION_BISEXUAL])) {
            $this->data['orientation'] = $orientation;
        }
    }

    public function setPhoto(string $photo) {
        $this->data['photo'] = $photo;
    }

    public function getUsername() {
        return $this->data['username'];
    }

    public function getEmail() {
        return $this->data['email'];
    }

    public function getFullName() {
        return $this->data['full_name'];
    }

    public function getAge() {
        return $this->data['age'];
    }

    public function getGender() {
        return $this->data['gender'];
    }

    public function getOrientation() {
        return $this->data['orientation'];
    }

    public static function getGenderOptions() {
        return [self::GENDER_FEMALE => 'Female',
            self::GENDER_MALE => 'Male'];
    }

    public static function getOrientationOptions() {
        return [self::ORIENTATION_GAY => 'Gay',
            self::ORIENTATION_STRAIGHT => 'Straight',
            self::ORIENTATION_BISEXUAL => 'Bisexual'];
    }

    public function getPhoto() {
        return $this->data['photo'];
    }

    public function setData(array $data) {
        $this->setUsername($data['username'] ?? '');
        $this->setEmail($data['email'] ?? '');
        $this->setFullName($data['full_name'] ?? '');
        $this->setAge($data['age'] ?? null);
        $this->setGender($data['gender'] ?? '');
        $this->setOrientation($data['orientation'] ?? '');
        $this->setPhoto($data['photo'] ?? '');
    }

    public function getData() {
        return $this->data;
    }

}
