<?php

namespace App;

class Balius {

    /** @var User[] */
    private $users;

    /** @var Gerimai[] */
    private $gerimai;

    const STATUS_POOP = 'poop';
    const STATUS_PUSSY = 'pussy';
    const STATUS_GOOD = 'good';
    const STATUS_FIRE = 'fire';
    const STATUS_VOMITTRON = 'vomittron';
    const STATUS_PENDING = 'pending';
    const PURE_ALC_IN_VODKA_L = 400;

    public function __construct(\App\Model\ModelUser $model_user, \App\Model\ModelGerimai $model_gerimai) {
        $this->gerimai = $model_gerimai->loadAll();
        $this->users = $model_user->loadAll();
    }

    public function getUserCount() {
        return count($this->users);
    }

    public function getPureAlcoholTotal() {
        $alcohol_total = 0;

        foreach ($this->gerimai as $gerimas) {
            $alcohol_total += $gerimas->getAbarot() * $gerimas->getAmount() / 100;
        }

        return $alcohol_total;
    }

    public function getPureAlcoholPerUser() {
        $user_count = $this->getUserCount();

        if ($user_count > 0) {
            return $this->getPureAlcoholTotal() / $user_count;
        }

        return false;
    }

    public function getPartyStatus() {
        $alco_per_user = $this->getPureAlcoholPerUser();

        if ($alco_per_user != false) {
            if ($alco_per_user >= self::PURE_ALC_IN_VODKA_L * 0.7) {
                return self::STATUS_VOMITTRON;
            } elseif ($alco_per_user >= self::PURE_ALC_IN_VODKA_L * 0.5) {
                return self::STATUS_FIRE;
            } elseif ($alco_per_user >= self::PURE_ALC_IN_VODKA_L * 0.3) {
                return self::STATUS_GOOD;
            } elseif ($alco_per_user >= self::PURE_ALC_IN_VODKA_L * 0.1) {
                return self::STATUS_PUSSY;
            } elseif ($alco_per_user < self::PURE_ALC_IN_VODKA_L * 0.1) {
                return self::STATUS_POOP;
            }
        } else {
            return self::STATUS_PENDING;
        }
    }

}
