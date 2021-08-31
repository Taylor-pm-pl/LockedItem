<div align="center">
 
 ![LockedItem](https://poggit.pmmp.io/shield.state/LockedItem)
 
 <h1>LockedItem | Player's item lock<h1>
</div>

## Features
- Player's item lock
- Players aren't afraid of losing items

## For Devolopers
You can access to LockedItem by using `LockedItem::getInstance()`
 <br>
 
## All LockedItem Commands:

| **Command** | **Description** |
| --- | --- |
| **/setlock** | **Lock the item in hand** |
| **/unlock** | **Unlock the item in hand** |
 
<br>
 
## 📃Permissions:

- You can use permission `lockeditem.setlock` for command /setlock
- You can use permission `lockeditem.unlock` for command /unlock
 
<br>

**Example:**
`
LockedItem::getInstance()->setLocked($item);
`
 
## Project Infomation

| Plugin Version | Pocketmine API | PHP Version | Plugin Status |
|---|---|---|---|
| 1.0.0 | 3.x.x | 7.4 | Completed |
 
