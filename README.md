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
# Config Main for LockedItem
History:
#Set Delete-onEnable: true if you want to clear the history of players who have item locked, unlocked and use the command when the server is on.
#Set Delete-onEnable: false if you don't want to clear the history of players who have item locked, unlocked and use the command when the server is on.
 Delete-onEnable: false
#Set SaveUnlockItem: true if you want to save player history with unlocked item.
#Set SaveUnlockItem: false if you don't want to save player history with unlocked item.
 SaveUnlockItem: false
...
 ```
## Project Infomation

| Plugin Version | Pocketmine API | PHP Version | Plugin Status |
|---|---|---|---|
| 1.0.0 | 3.x.x | 7.4 | Completed |
 
