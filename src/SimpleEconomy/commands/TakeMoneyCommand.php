<?php

namespace SimpleEconomy\commands;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat as SE;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use SimpleEconomy\Loader;
use SimpleEconomy\manager\EconomyManager;

class TakeMoneyCommand extends Command {

    public function __construct() {
        parent::__construct("takemoney", "take another player's money");
        $this->setPermission('money.cmd.admin');
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
            $sender->sendMessage(SE::RED . "Usa: /takemoney (player) (cantidad)");
            return;
        }

        $player = Server::getInstance()->getPlayerExact($args[0]);
        $amount = (float)$args[1];
        $balance = Loader::getInstance()->getEconomyManager()->getMoney($player->getName());
        
        if($player !== null){
            if($player->getName() === $sender->getName()){
                $sender->sendMessage(SE::colorize($prefix . Loader::getInstance()->getPluginConfig()->get("no_take", "&cNo puedes quitarte saldo a ti mismo")));
                return;
            }
            
            if($balance > 0){
                $sender->sendMessage(SE::colorize(str_replace(["{player}", "{amount}"],[$player->getName(), $amount], $prefix . Loader::getInstance()->getPluginConfig()->get("take_money", "&aLe has quitado a &6{player} &aun total de &9{amount}"))));
                Loader::getInstance()->getEconomyManager()->addMoney($sender->getName(), $amount);
                Loader::getInstance()->getEconomyManager()->reduceMoney($player->getName(), $amount);
            }else{
                $sender->sendMessage(SE::colorize($prefix . Loader::getInstance()->getPluginConfig()->get("no_money_player", "&cEl Jugador no tiene saldo")));
            }
        } else {
            $sender->sendMessage(SE::colorize($prefix . Loader::getInstance()->getPluginConfig()->get("offline", "&cJugador no conectado")));
        }
    }
}