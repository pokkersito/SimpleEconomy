<?php

namespace SimpleEconomy\provider;

use pocketmine\utils\Config;
use SimpleEconomy\Loader;

class Provider {

	private Loader $plugin;
	private Config $economyData;

	public function __construct(Loader $plugin){
		$this->plugin = $plugin;
		$this->init();
	}

	private function init(): void {
		$folder = $this->plugin->getDataFolder();
		if (!is_dir($folder)) {
			@mkdir($folder, 0777, true);
		}
		$this->economyData = new Config($folder . "economy.json", Config::JSON);
	}

	public function getEconomyData(): Config {
		return $this->economyData;
	}

	public function saveEconomyData(): void {
		$this->economyData->save();
	}
}