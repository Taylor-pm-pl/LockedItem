# LockedItem
[![](https://poggit.pmmp.io/shield.state/LockedItem)](https://poggit.pmmp.io/p/LockedItem)
<a href="https://poggit.pmmp.io/p/LockedItem"><img src="https://poggit.pmmp.io/shield.state/LockedItem"></a>
[![](https://poggit.pmmp.io/shield.api/LockedItem)](https://poggit.pmmp.io/p/LockedItem)
<a href="https://poggit.pmmp.io/p/LockedItem"><img src="https://poggit.pmmp.io/shield.api/LockedItem"></a>

Player's item lock
# Features
- Player's item lock
- Players aren't afraid of losing items
- So that players don't throw items indiscriminately, causing server lag.
# How to lock items
After installing the LockItem plugin

Add lore `§l§d[LOCKED]` on the item you want to lock!.
# For Devolopers
You can access to LockedItem by using ```LockedItem::getInstance()```

**Example:**
```php
LockedItem::getInstance()->setLock($item);
```
# License
MIT License

Copyright (c) 2021 JeroGamingYT

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
