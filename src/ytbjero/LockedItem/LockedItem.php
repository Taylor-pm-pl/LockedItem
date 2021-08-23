<?php 

declare(strict_types=1);

namespace ytbjero\LockedItem;

use pocketmine\plugin\PluginBase;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\item\Item;
use pocketmine\block\Block;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;

use pocketmine\utils\TextFormat as TF;

class LockedItem extends PluginBase implements Listener
{
	private static LockedItem $instance;
	public $prefix = "§d§l⊹⊱§eLock Item§d⊰⊹";

    public function onLoad() : void 
    {
        $start = !isset(LockedItem::$instance);
        LockedItem::$instance = $this;
    }
    
	public function onEnable() : void
	{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	  public static function getInstance(): LockedItem {
        return LockedItem::$instance;
    }

	public function ItemMove(PlayerDropItemEvent $event) 
	{
		$lore = $event->getItem()->getLore();
		 if(in_array("\n§l§d[LOCKED]", $lore) or in_array("§l§d[LOCKED]", $lore) or in_array("\n§o§l§d[LOCKED]", $lore) or $lore == "§l§d[LOCKED]"){
		 	$event->setCancelled(true);
		 }
	}

	public function setLock($item)
	{
		$item->setLore(array("§l§d[LOCKED]"));
	}
}
