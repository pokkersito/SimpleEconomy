<?php

namespace SimpleEconomy\commands;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as SE;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use SimpleEconomy\Loader;
use SimpleEconomy\manager\EconomyManager;

class AddMoneyCommand extends Command {

    public function __construct() {
        parent::__construct("addmoney", "add more money than a person has");
        $this->setPermission('money.cmd.admin');
    }

    public function execute(CommandSender $sender, string $label, array $args): void{

        $prefix = Loader::getInstance()->getPluginConfig()->get("prefix", "&7[&6SimpleEconomy7] &f» ");

        if (!$this->testPermission($sender)) {
            return;
        }

        if (!isset($args[0]) || !isset($args[1])) {
            $sender->sendMessage(SE::RED . "Usa: /addmoney (player) (cantidad)");
            return;
        }

         $player = Server::getInstance()->getPlayerExact($args[0]);
         $amount = (float)$args[1];

         if($player){
            Loader::getInstance()->getEconomyManager()->addMoney($player->getName(), $amount);
            $sender->sendMessage(SE::colorize(str_replace(["{amount}", "{player}"], [$amount, $player->getName()], Loader::getInstance()->getPluginConfig()->get("add_money", "&aAgregaste {amount} al saldo de {player}"))));
         }else{
            $sender->sendMessage(SE::colorize($prefix . Loader::getInstance()->getPluginConfig()->get("offline", "&cJugador no conectado")));
         }
    }
}