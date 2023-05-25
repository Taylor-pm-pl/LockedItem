<?php

declare(strict_types=1);

namespace ytbjero\LockedItem;

use pocketmine\block\inventory\ChestInventory;
use pocketmine\block\inventory\DoubleChestInventory;
use pocketmine\block\inventory\EnderChestInventory;
use pocketmine\block\inventory\FurnaceInventory;
use pocketmine\block\inventory\HopperInventory;
use pocketmine\block\inventory\ShulkerBoxInventory;
use pocketmine\block\ItemFrame;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\inventory\PlayerInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use function array_search;

class LockedItem extends PluginBase implements Listener
{
    private static $instance;

    const KEY_VALUE = "isLocked";

    /**
     * @return void
     */
    public function onEnable(): void
    {
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->checkUpdate();
    }

    /**
     * @param bool $isRetry
     * @return void
     */
    public function checkUpdate(bool $isRetry = false): void
    {
        $this->getServer()->getAsyncPool()->submitTask(
            new CheckUpdateTask(
                $this->getDescription()->getName(),
                $this->getDescription()->getVersion()
            )
        );
    }

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        return self::$instance;
    }

    /**
     * @param PlayerDropItemEvent $event
     * @return void
     */
    public function onDrop(PlayerDropItemEvent $event): void
    {
        $item = $event->getItem();
        if ($this->isLocked($item)) {
            $event->cancel();
        }
    }

    /**
     * @param PlayerInteractEvent $event
     * @return void
     */
    public function onTouch(PlayerInteractEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $player->getInventory()->getItemInHand();
        $block = $event->getBlock();
        if ($block instanceof ItemFrame && $this->getConfig()->get("no-touch")) {
            if ($this->isLocked($item)) {
                $event->cancel();
            }
        }
    }

    /**
     * @param InventoryTransactionEvent $event
     * @return void
     */
    public function onTitle(InventoryTransactionEvent $event): void
    {
        $iPlayer = null;
        $iChest = null;
        foreach ($event->getTransaction()->getActions() as $action) {
            foreach ($event->getTransaction()->getInventories() as $inventory) {
                if (!$inventory instanceof PlayerInventory) {
                    $iPlayer = true;
                }
                if (
                    $inventory instanceof ChestInventory ||
                    $inventory instanceof DoubleChestInventory ||
                    $inventory instanceof EnderChestInventory ||
                    $inventory instanceof FurnaceInventory ||
                    $inventory instanceof ShulkerBoxInventory ||
                    $inventory instanceof HopperInventory
                ) {
                    $iChest = true;
                }
                if ($iPlayer && $iChest) {
                    $item = $action->getTargetItem();
                    if ($this->getConfig()->get("no-change-inventory")) {
                        if ($this->isLocked($item)) {
                            $event->cancel();
                        }
                    }
                }
            }
        }
    }

    /**
     * @param CommandSender $sender
     * @param Command $command
     * @param string $label
     * @param array $args
     * @return bool
     */
    public function onCommand(
        CommandSender $sender,
        Command $command,
        string $label,
        array $args
    ): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TF::RED . "This command only works in game!");
            return false;
        }
        $item = $sender->getInventory()->getItemInHand();
        if ($item->getId() == 0) {
            $sender->sendMessage($this->getConfig()->get("item-hand-message"));
            return false;
        }
        if ($command->getName() == "setlock") {
            if (!$sender->hasPermission("lockeditem.setlock")) {
                $sender->sendMessage($this->getConfig()->get("perm-message"));
                return false;
            }
            if ($this->isLocked($item)) {
                $sender->sendMessage($this->getConfig()->get("no-lock-message"));
                return false;
            }
            $sender->getInventory()->setItemInHand($this->setLocked($item));
            $sender->sendMessage($this->getConfig()->get("lock-message"));
        }
        if ($command->getName() == "unlock") {
            if (!$sender->hasPermission("lockeditem.unlock")) {
                $sender->sendMessage($this->getConfig()->get("perm-message"));
                return false;
            }
            if (!$this->isLocked($item)) {
                $sender->sendMessage($this->getConfig()->get("no-unlock-message"));
                return false;
            }
            $sender->getInventory()->setItemInHand($this->unLock($item));
            $sender->sendMessage($this->getConfig()->get("unlock-message"));
        }
        return true;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isLocked(Item $item): bool
    {
        return $item->getNamedTag()->getTag("Status") !== null;
    }

    /**
     * @param Item $item
     * @return Item
     */
    public function setLocked(Item $item): Item
    {
        if (!$this->isLocked($item)) {
            $nbt = $item->getNamedTag()->setString("Status", self::KEY_VALUE);
            $item->setNamedTag($nbt);
            $status = $item->getLore();
            $status[] = $this->getConfig()->get("item-lore");
            $item->setLore($status);
        }
        return $item;
    }

    /**
     * @param Item $item
     * @return Item
     */
    public function unLock(Item $item): Item
    {
        if ($this->isLocked($item)) {
            $item->getNamedTag()->removeTag("Status");
            $status = $item->getLore();
            unset($status[array_search($this->getConfig()->get("item-lore"), $status, true)]);
            $item->setLore($status);
        }
        return $item;
    }
}
