<?php

namespace SimpleEconomy\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as SE;
use SimpleEconomy\Loader;

class TopMoneyCommand extends Command {

    public function __construct() {
        parent::__construct("topmoney", "Shows the top 10 players with the most money");
        $this->setPermission("money.cmd");
    }

    public function execute(CommandSender $sender, string $label, array $args): void {
        if (!$this->testPermission($sender)) {
            return;
        }

        $prefix = Loader::getInstance()->getPluginConfig()->get("prefix", "&7[&6SimpleEconomy&7] &f» ");
        
        if (!$sender instanceof Player) {
            $sender->sendMessage(SE::colorize($prefix . Loader::getInstance()->getPluginConfig()->get("in_game", "&cEste comando solo puede ser ejecutado en el juego")));
            return;
        }

        $economyData = Loader::getInstance()->getEconomyManager()->getAllMoney();

        if (empty($economyData)) {
            $sender->sendMessage(SE::colorize($prefix . "&cNo hay datos disponibles."));
            return;
        }

        arsort($economyData);

        $sender->sendMessage(SE::colorize($prefix . "&6Top Money:"));
        $i = 1;
        foreach ($economyData as $playerName => $balance) {
            $sender->sendMessage(SE::colorize("&e{$i}. &f{$playerName} &7- &a{$balance}"));
            if ($i++ >= 10) break;
        }
    }
}