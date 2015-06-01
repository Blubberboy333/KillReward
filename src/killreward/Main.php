<?php

namespace KillReward;

use pocketmine\plugin\PluginBase as Base;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\event\Listener;
use pocketmine\event\EntityDamageByEntityEvent;
use pocketmine\Player;

class Main extends Base implements Listener{
  public function onEnable(){
    $this->getLogger()->info(TextFormat::BLUE . "KillReward enabled");
    $this->getServer()->getPluginManager->registerEvents($this, $this);
    $this->saveDefaultConfig();
  }
  public function onDisable(){
    $this->getLogger()->info(TextFormat::RED . "KillReward disabled");
  }
  private function onAdd(Player $player){
    $player->getInventory()->addItem($this->getConfig()->get("Item"));
    $player->sendPopup("You have been given " .$this->getConfig()->get("Item"). " for killing another player");
  }
  
  public function onKill(EntityDamageByEntityEvent $event){
    $damager = $event->getDamager();
    if($damager->hasPermission("killreward") || $damager->hasPermission("killreward.add")){
      $this->onAdd($damager);
    }
  }
}
