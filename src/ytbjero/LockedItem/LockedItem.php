<?php

declare (strict_types=1);

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

use pocketmine\utils\Config;

use ytbjero\LockedItem\libs\JackMD\UpdateNotifier\UpdateNotifier;
class LockedItem extends PluginBase implements Listener
{
	private static $instance;
	const KEY_VALUE = "Locked";

	/** @var Config */
	public $history;

	public function onLoad() : void 
    {
        UpdateNotifier::checkUpdate($this->getDescription()->getName(), $this->getDescription()->getVersion());
    }

	public function onEnable() : void
	{
		self::$instance = $this;
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->history = new Config($this->getDataFolder()."history.yml", Config::YAML);
		if($this->getConfig()->getNested("History.Delete-onEnable") == true){
			 foreach ($this->history->getAll() as $history => $data) {
                $this->history->remove($history);
            }
            $this->history->save();
		}
	}

	public static function getInstance() : self
	{
		return self::$instance;
	}

	public function onCommand(CommandSender $sender, Command $command, String $label, Array $args) : bool
	{
		if ($command->getName() == "setlock") {
			if (!$sender->hasPermission("lockeditem.setlock")) {
				$sender->sendMessage(TF::RED. " You don't have permisson to use this command!");
				return false;
			}
			$item = $sender->getInventory()->getItemInHand();
			if ($item->getNamedTag()->hasTag("Status", StringTag::class)) {
				$sender->sendMessage(TF::RED . "Your item is already locked!");
				return false;
			}
			if ($item->getId() == 0) {
				$sender->sendMessage(TF::RED . "You need to hold the item in your hand to lock it!");
				return false;
			}
			$item = $sender->getInventory()->getItemInHand();
			$username = $sender->getName();
			$item_name = $item->getName();
			$day = date('d/m - H:i:s',time());
			$item->setNamedTagEntry(new StringTag("Status", self::KEY_VALUE));
			$status = $item->getLore();
		    $status = ["LOCKED"];
		    $item->setLore($status);
			$sender->getInventory()->setItemInHand($item);
					$txt = "$username lock the item with name $item_name.";
					$this->history->set($day, $txt);
					$this->history->save(); 
			$sender->sendMessage(TF::GREEN . "The item in your hand is locked!");
			return true;
		}
		if ($command->getName() == "unlock") {
			if (!$sender->hasPermission("lockeditem.unlock")) {
				$sender->sendMessage(TF::RED . "You don't have permisson to use this command!");
				return false;
			}
			$item = $sender->getInventory()->getItemInHand();
			if (!$item->getNamedTag()->hasTag("Status", StringTag::class)) {
				$sender->sendMessage(TF::RED . "Can not! Item has not been locked before.");
				return false;
			}
			if ($item->getId() == 0) {
				$sender->sendMessage(TF::RED . "You need to hold the item in your hand to unlock it!");
				return false;
			}
			$item->getNamedTag()->removeTag("Status");
			$status = $item->getLore();
			$username = $sender->getName();
			$item_name = $item->getName();
			$day = date('d/m - H:i:s',time());
			unset($status[array_search(["LOCKED"], $status)]);
			$item->setLore($status);
			$sender->getInventory()->setItemInHand($item);
					$txt = "$username unlock the item with name $item_name.";
					$this->history->set($day, $txt);
					$this->history->save(); 
			$sender->sendMessage(TF::GREEN . "The item in your hand is unlocked!");
			return true;
		}
		return true;
	}

	public function ItemMove(PlayerDropItemEvent $event)
	{
		$item = $event->getItem();
		$player = $event->getPlayer()->getName();
		$item_name = $item->getName();
		if ($item->getNamedTag()->hasTag("Status")) {
			if ($item->getNamedTag()->getString("Status") == self::KEY_VALUE) {
				$event->setCancelled(true);
					$day = date('d/m - H:i:s',time());
					$txt = "$player have item with name $item_name is locked.";
					$this->history->set($day, $txt);
					$this->history->save(); 
				}
		} 
		if($this->getConfig()->getNested("History.SaveUnlockItem") == true){
			if (!$item->getNamedTag()->hasTag("Status", StringTag::class)) {
				$day = date('d/m - H:i:s',time());
					$txt = "$player have item with name $item_name is unlocked.";
					$this->history->set($day, $txt);
					$this->history->save(); 
			}
		}
	}

	public function setLocked(Item $item) : Item
	{
		$item->setNamedTagEntry(new StringTag("Status", self::KEY_VALUE));
		$status = $item->getLore();
		$status[] = "LOCKED";
		$item->setLore($status);
		return $item;
	}
}
