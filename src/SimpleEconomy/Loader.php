<?php

namespace SimpleEconomy;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as SE;
use SimpleEconomy\manager\EconomyManager;
use SimpleEconomy\commands\CommandManager;
use SimpleEconomy\provider\Provider;
use SimpleEconomy\EventListener;
use pocketmine\utils\Config;

class Loader extends PluginBase {

    public static Loader $instance;

    private Provider $dataProvider;

    private EconomyManager $economyManager;

    private Config $pluginConfig;

    public function onLoad(): void {
        self::$instance = $this;
    }

    public function onEnable(): void {
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->saveDefaultConfig();
        $this->pluginConfig = $this->getConfig();
        $this->getLogger()->info(SE::colorize("SimpleEconomy On!"));
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->loadManagers();
        CommandManager::init();
    }

    public static function getInstance(): Loader {
        return self::$instance;
    }

    public function getProvider() : Provider {
		return $this->dataProvider;
	}

    public function getEconomyManager() : EconomyManager {
		return $this->economyManager;
	}

    public function loadManagers(){
        $this->dataProvider = new Provider($this);
		$this->economyManager = new EconomyManager();
	}

    public function getPluginConfig(): Config {
        return $this->pluginConfig;
    }
}