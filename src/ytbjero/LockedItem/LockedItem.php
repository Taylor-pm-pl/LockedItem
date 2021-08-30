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
use pocketmine\nbt\tag\StringTag;
class LockedItem extends PluginBase implements Listener
{
	private static LockedItem $instance;
	public $prefix = "§d§l⊹⊱§eLock Item§d⊰⊹";
	public const KEY_VALUE = "§l§d[LOCKED]";

    public function onLoad() : void 
    {
        $start = !isset(LockedItem::$instance);
        LockedItem::$instance = $this;
    }
    
	public function onEnable() : void
	{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	  public static function getInstance(): LockedItem 
	  {
        return LockedItem::$instance;
    }

	public function ItemMove(PlayerDropItemEvent $event) 
	{
		$item = $event->getItem();
		$lore = $event->getItem()->getLore();
		if($item->getNameTag()->hasTag("Status")){
		 if($item->getNameTag()->getString("Status") == self::KEY_VALUE){
		 	$event->setCancelled(true);
		 }
		}
	}

	public function setLocked(Item $item) : Item
	{
		$item->setNameTagEntry(new StringTag("Status", self::KEY_VALUE));
		$status = $item->getLore();
		$status[] = "LOCKED";
		$item->setLore($status);
		return $item;
	}
}
