<?php

namespace SimpleEconomy\commands;

use SimpleEconomy\Loader;
use SimpleEconomy\commands\MoneyCommand;
use SimpleEconomy\commands\SetMoneyCommand;
use SimpleEconomy\commands\PayCommand;
use SimpleEconomy\commands\TakeMoneyCommand;
use SimpleEconomy\commands\SeeMoneyCommand;


class CommandManager {

    public static function init(): void 
    {
    Loader::getInstance()->getServer()->getCommandMap()->register("SimpleEconomy", new MoneyCommand());
    Loader::getInstance()->getServer()->getCommandMap()->register("SimpleEconomy", new SetMoneyCommand());
    Loader::getInstance()->getServer()->getCommandMap()->register("SimpleEconomy", new PayCommand());
    Loader::getInstance()->getServer()->getCommandMap()->register("SimpleEconomy", new SeeMoneyCommand());
    Loader::getInstance()->getServer()->getCommandMap()->register("SimpleEconomy", new TakeMoneyCommand());
    Loader::getInstance()->getServer()->getCommandMap()->register("SimpleEconomy", new AddMoneyCommand());
    }
    
    public function register(BaseCommand $command): void
    {
        Loader::getInstance()->getServer()->getCommandMap()->register($command->getName(), $command);
    }
}