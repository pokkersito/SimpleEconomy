<?php

namespace SimpleEconomy;

use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;
use SimpleEconomy\Loader;
use pocketmine\player\Player;

class EventListener implements Listener {

    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        if ($player->hasPlayedBefore()) return;
        Loader::getInstance()->getEconomyManager()->addMoney($player->getName(), 1000);
    }
}