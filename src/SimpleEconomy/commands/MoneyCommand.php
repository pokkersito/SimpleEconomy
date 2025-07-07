<?php

namespace SimpleEconomy\commands;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as SE;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use SimpleEconomy\Loader;
use SimpleEconomy\manager\EconomyManager;

class MoneyCommand extends Command {

    public function __construct() {
        parent::__construct("money", "look how much money you have");
        $this->setPermission('money.cmd');
    }

    public function execute(CommandSender $sender, string $label, array $args): void{

        if (!$this->testPermission($sender)) {
            return;
        }

        $money = Loader::getInstance()->getEconomyManager()->getMoney($sender->getName());
        $prefix = Loader::getInstance()->getPluginConfig()->get("prefix", "&7[&6SimpleEconomy7] &f» ");

        if($sender instanceof Player){
            $sender->sendMessage(SE::colorize("&aTu Saldo:&9 {$money}"));
        }else{
            $sender->sendMessage(SE::colorize($prefix . Loader::getInstance()->getPluginConfig()->get("in_game", "&cEste comando solo puede ser ejecutado en el juego")));
        }
    }
}