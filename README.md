[![](https://poggit.pmmp.io/shield.state/LockedItem)]
<div align="center">
<h1>LockedItem| v1.0.0<h1>
<p>Player's item lock</p>
</div>

## Features
- Player's item lock
- Players aren't afraid of losing items

## For Devolopers
You can access to LockedItem by using ```LockedItem::getInstance()```
 
 <br>
## All LockedItem Commands:

| **Command** | **Description** |
| --- | --- |
| **/setlock** | **Lock the item in hand** |
| **/unlock** | **Unlock the item in hand** |
<br>
## 📃  Permissions:

- You can use permission `lockeditem.setlock` for command /setlock
- You can use permission `lockeditem.unlock` for command /unlock
<br>
**Example:**
```php
LockedItem::getInstance()->setLocked($item);
```
 
 # Configs
## config.yml
 ```
 ---
# Config Main of LockedItem
perm-message: You are not allowed to use this command!
lock-message: Your item has been locked successfully!
no-lock-message: Your item was previously locked!
unlock-message: Your item has been successfully unlocked!
no-unlock-message: Your item has not been locked before!
item-hand-message: You need to hold the item in your hand to unlock!

#Lore of item when locked
item-lore: LOCKED
# The item locked will not be able to interact with the itemframe if this is true
no-touch: true
...
 ```
## Project Infomation

| Plugin Version | Pocketmine API | PHP Version | Plugin Status |
|---|---|---|---|
| 1.0.0 | 3.x.x | 7.4 | Completed |
 
