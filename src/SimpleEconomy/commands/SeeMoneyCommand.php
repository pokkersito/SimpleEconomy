<?php

namespace SimpleEconomy\commands;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as SE;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use SimpleEconomy\Loader;
use SimpleEconomy\manager\EconomyManager;

class SeeMoneyCommand extends Command {

    public function __construct() {
        parent::__construct("seemoney", "look at the player's balance");
        $this->setPermission('money.cmd.admin');
    }

    public function execute(CommandSender $sender, string $label, array $args): void{

        if (!$this->testPermission($sender)) {
            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage(SE::RED . "Usa: /seemoney (player)");
            return;
        }

        $player = Server::getInstance()->getPlayerExact($args[0]);
        $prefix = Loader::getInstance()->getPluginConfig()->get("prefix", "&7[&6SimpleEconomy7] &f» ");

        if($player){
            $saldo = Loader::getInstance()->getEconomyManager()->getMoney($player->getName());
            $sender->sendMessage(SE::colorize($prefix . "&aEl saldo de {$player->getName()} es: &9{$saldo}"));
            return;
        }else{
            $sender->sendMessage(SE::colorize($prefix . Loader::getInstance()->getPluginConfig()->get("offline", "&cJugador no conectado")));
        }
    }
}