# SeeDevice
A pmmp plugin for Minecraft(W10,BE) [PHP]
[![](https://poggit.pmmp.io/shield.dl.total/SeeDevice)](https://poggit.pmmp.io/p/SeeDevice)
## Some Information
This is an "API" plugin to get more easily user's Device<br>

### The Famous "API"
*This is not really an API btw*<br>
**How to Get the Os of a Player with SeeDevice**<br>
It's easy: ``` $userOs =SeeDevice::getInstance()->getPlayerOs($player);```<br>
**How to Get the Device of a Player with SeeDevice**<br>
A bit more difficult than before: ```$userDevice = SeeDevice::getInstance()->getPlayerDevice($player);```
*Be sure to have the class in your use statement and that Player is an instance of Player*<br>
*Don't forget to check if the plugin is online*
## LAST UPDATES
**What happened in the last update?**<br>
*(1.1.0)* Now all Commands can be managed(2 commands). You can now See the Real Device of the player from /seedevice.<br>
*(1.0.0)* Nothing particular (*Lot of things*), just a remake of the plugin, because you and me, changed and it was the time to fix bugs.<br>
You can Now customize the format of the Score Tag to show or not the Os and what do you want.<br>
You can now disable the FakeOs Command..
#### Commands
**How to see user's (device, os):** */seedevice [player]*<br>
**How to Edit user's os:** */fakeos <playername-self> <name_of_device>* (Only if it's enabled.)

#### Permission
To have access to the two commands, the player has to get the permission "SeeDevice.command.\*"
## Future Release
- [x] Create the Plugin<br>
- [x] Do the Readme <br>
- [x] Possibility to change the name of the OS<br>
- [x] Create a command to get the Device Name of the user<br>
- [x] Config has more control! Enable or Disable the command<br>
- [ ] Get a serious list of Os <br>
- [ ] Re-Make the Config <br>
*Don't be afraid by opening an issue or a pull request*