<?php

namespace SimpleEconomy\commands;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as SE;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use SimpleEconomy\Loader;
use SimpleEconomy\manager\EconomyManager;

class PayCommand extends Command {

    public function __construct() {
        parent::__construct("pay", "pay a user a balance you have with him/her");
        $this->setPermission('money.cmd');
    }

    public function execute(CommandSender $sender, string $label, array $args): void{

        $prefix = Loader::getInstance()->getPluginConfig()->get("prefix", "&7[&6SimpleEconomy7] &f» ");

        if (!$this->testPermission($sender)) {
            return;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage(SE::colorize($prefix . Loader::getInstance()->getPluginConfig()->get("only_players", "&cEste comando solo lo pueden usar los Jugadores")));
            return;
        }

        if (!isset($args[0]) || !isset($args[1])) {
            $sender->sendMessage(SE::RED . "Usa: /pay (player) (cantidad)");
            return;
        }

        $player = Server::getInstance()->getPlayerExact($args[0]);
        $amount = (float)$args[1];
        $balance = Loader::getInstance()->getEconomyManager()->getMoney($sender->getName());
        
        if($player !== null){
            if($player->getName() === $sender->getName()){
                $sender->sendMessage(SE::colorize($prefix . Loader::getInstance()->getPluginConfig()->get("no_pay", "&cNo puedes pagarte a ti mismo")));
                return;
            }
            
            if($balance >= $amount){
                $sender->sendMessage(SE::colorize(str_replace(["{player}", "{amount}"],[$player->getName(), $amount], $prefix . Loader::getInstance()->getPluginConfig()->get("pay", "&aLe has pagado a &6{player} &aun total de &9{amount}"))));
                Loader::getInstance()->getEconomyManager()->addMoney($player->getName(), $amount);
                Loader::getInstance()->getEconomyManager()->reduceMoney($sender->getName(), $amount);
            }else{
                $sender->sendMessage(SE::colorize($prefix . Loader::getInstance()->getPluginConfig()->get("no_money", "&cTu saldo es insuficiente")));
            }
        } else {
            $sender->sendMessage(SE::colorize($prefix . Loader::getInstance()->getPluginConfig()->get("offline", "&cJugador no conectado")));
        }
    }
}