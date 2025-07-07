<?php

namespace SimpleEconomy\manager;

use SimpleEconomy\Loader;

class EconomyManager {

	public function getMoney(string $player): int {
		$data = Loader::getInstance()->getProvider()->getEconomyData();
		return (int) ($data->get(strtolower($player)) ?? 0);
	}

	public function setMoney(string $player, int $amount): void {
		$data = Loader::getInstance()->getProvider()->getEconomyData();
		$data->set(strtolower($player), $amount);
		Loader::getInstance()->getProvider()->saveEconomyData();
	}

	public function addMoney(string $player, int $amount): void {
		$this->setMoney($player, $this->getMoney($player) + $amount);
	}

	public function reduceMoney(string $player, int $amount): void {
		$this->setMoney($player, max(0, $this->getMoney($player) - $amount));
	}
}