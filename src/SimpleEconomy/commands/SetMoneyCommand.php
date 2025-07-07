<?php

namespace SimpleEconomy\commands;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as SE;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use SimpleEconomy\Loader;
use SimpleEconomy\manager\EconomyManager;

class SetMoneyCommand extends Command {

    public function __construct() {
        parent::__construct("setmoney", "give a player a new amount of money");
        $this->setPermission('money.cmd.admin');
    }

    public function execute(CommandSender $sender, string $label, array $args): void{

        if (!$this->testPermission($sender)) {
            return;
        }

        if (!isset($args[0]) || !isset($args[1])) {
            $sender->sendMessage(SE::RED . "Usa: /setmoney (player) (cantidad)");
            return;
        }

        $player = Server::getInstance()->getPlayerExact($args[0]);
        $amount = (float)$args[1];
        $prefix = Loader::getInstance()->getPluginConfig()->get("prefix", "&7[&6SimpleEconomy7] &f» ");

        if($player){
            $sender->sendMessage(SE::colorize(str_replace(["{player}", "{amount}"],[$player->getName(), $amount], $prefix . Loader::getInstance()->getPluginConfig()->get("set_money", "&aLe haz puesto a &6{player}, &a un total de &9{amount}"))));
            Loader::getInstance()->getEconomyManager()->setMoney($player->getName(), $amount);
            return;
        }else{
            $sender->sendMessage(SE::colorize($prefix . Loader::getInstance()->getPluginConfig()->get("offline", "&cJugador no conectado")));
        }
    }
}