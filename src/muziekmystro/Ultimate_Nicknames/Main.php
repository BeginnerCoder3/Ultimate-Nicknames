<?php

declare(strict_types=1);

namespace muziekmystro\Ultimate_Nicknames;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

    public function onEnable(){        
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->getLogger()->info(TextFormat::BLUE . "Ultimate Nicknames is ready!");
    }

    public function onLoad(){
        $this->getLogger()->info(TextFormat::YELLOW . "Ultimate Nicknames is loading...");
      }
    
      public function onDisable(){
        $this->getLogger()->info(TextFormat::RED . "Ultimate Nicknames has failed!");
      }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {

         $bn1 = "bitch";
         $bn2 = "ass";
         $bn3 = "asshole";
         $bn4 = "bastard";
         $bn5 = "cunt";
         $bn6 = "fuck";
         $bn7 = "damn";
         $bn8 = "shit";
         $bn9 = "slut";

        switch($cmd->getName()){
  
            case "nick":
                if($sender->hasPermission("un.nick"))
                {
                    if(!$sender instanceof Player){
                        $sender->sendMessage("This Command Only Works for players! Please perform this command IN GAME!");
                    } else {
                        if(isset($args[0]))
                        {
                            if(strtolower($args[0]) !== $bn1 or $bn2 or $bn3 or $bn4 or $bn5 or $bn6 or $bn7 or $bn8 or $bn9)
                            {
                                $nick = $args[0];
                                $sender->setDisplayName($nick);
                                $player = $sender->getName();
                                $this->getConfig()->set($player, $nick);
                                $this->saveConfig();
                                $this->reloadConfig();
                            }
                        }
                    }
                } else {
                    $sender->sendMessage("You don't have permission to use this command");
                    return true;
                }
  
            break;
  
            case "unnick":
                if($sender->hasPermission("un.unnick"))
                {
                    if(!$sender instanceof Player){
                        $sender->sendMessage("This Command Only Works for players! Please perform this command IN GAME!");
                    } else {
                        if($this->getConfig()->get($sender->getName()))
                        {
                            $player = $sender->getName();
                            $sender->setDisplayName($player);
                            $this->getConfig()->set($player, ""); 
                            $this->saveConfig();
                            $this->reloadConfig();
                        }
                    }
                } else {
                    $sender->sendMessage("You don't have permission to use this command");
                    return true;
                }

            break;
        }
    return true;  
    }

    public function onLeave(PlayerQuitEvent $e){

        $player = $e->getPlayer();
        $name = $player->getName();

        if($this->getConfig()->get($name)) #if there is already a config for this player
        {
            $player->setDisplayName($name);
        } else {
            return true;
        }
    }
}