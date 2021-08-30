<?php 

declare(strict_types=1);

namespace ytbjero\LockedItem;

use pocketmine\plugin\PluginBase;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\item\Item;
use pocketmine\block\Block;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

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

    public function onCommand(CommandSender $sender, Command $command, String $label, Array $args) : bool 
    {
    	if($command->getName() == "setlock"){
    		if(!$sender->hasPermission("lockeditem.setlock")){
    			$sender->sendMessage($this->prefix. " You don't have permisson to use this command!");
    			return false;
    		}
    		$item = $sender->getInventory()->getItemInHand();
    		if($item->getId() == 0){
    			$sender->sendMessage($this->prefix. " You need to hold the item in your hand to lock it!");
    			return false;
    		}
    		$item = $sender->getInventory()->getItemInHand();
    		$item->setNamedTagEntry(new StringTag("Status", self::KEY_VALUE));
    		$status[] = "[LOCKED]";
		    $item->setLore($status);
		    $sender->getInventory()->setItemInHand($item);
		    $sender->sendMessage($this->prefix. " The item in your hand is locked!");
		    return false;
    	}
    	if($command->getName() == "unlock"){
    		if(!$sender->hasPermission("lockeditem.unlock")){
    			$sender->sendMessage($this->prefix. " You don't have permisson to use this command!");
    			return false;
    		}
    		$item = $sender->getInventory()->getItemInHand();
    		if($item->getId() == 0){
    			$sender->sendMessage($this->prefix. " You need to hold the item in your hand to unlock it!");
    			return false;
    		}
    		$item = $sender->getInventory()->getItemInHand();
    			$item->setNamedTagEntry(new StringTag("Status", "§l§d[UNLOCKED]"));
    		$status[] = "[UNLOCKED]";
		    $item->setLore($status);
		    $sender->getInventory()->setItemInHand($item);
		    $sender->sendMessage($this->prefix. " The item in your hand is unlocked!");
		    return false;
    	}
    	return true;
    }

	public function ItemMove(PlayerDropItemEvent $event) 
	{
		$item = $event->getItem();
		if($item->getNamedTag()->hasTag("Status")){
		 if($item->getNamedTag()->getString("Status") == self::KEY_VALUE){
		 	$event->setCancelled(true);
		 }
		}
	}

	public function setLocked(Item $item) : Item
	{
		$item->setNamedTagEntry(new StringTag("Status", self::KEY_VALUE));
		$status = $item->getLore();
		$status[] = "[LOCKED]";
		$item->setLore($status);
		return $item;
	}
}
