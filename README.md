# SeeDevice
A pmmp plugin for Minecraft(W10,BE) [PHP]
## Some Informations
This is a "api" plugin to get more easly user's Device<br>
*Don't be afraid by opening a issue or a pull request*
**An important lexical error have been resolved, so the API have Been Changed!!**
**How to Get the device of an user with our plugin**<br>
Just so easy: ``` $userDevice =SeeDevice::getInstance()->getUsd($player);```<br>
And you get it but before doing that, just check if the plugin is enabled You have lot of possibility to call our fonction getUsD<br>
**I want to get The OS of player**<br>
Just do that: ```
$userOs = SeeDevice::getInstance()->getUos($player);```

## LAST UPDATES
In the last update we have correct some error, and added 2 commands.
We added the possibility to show the os of all player.(Can be disabled in config.yml)
### Commands
**How to see user's (device, os):** */seedevice [player]*
**How to Edit user's os:** */fakeos <playername-self> <name_of_device>*

### Permission
To have acces to the 2 command the player have to get the permission "SeeDevice.command.\*"
## Future Release
- [x] Create the Plugin<br>
- [x] Do the Readme <br>
- [x] Possibility to change the name of the OS<br>
- [x] Create a command to get The Device Name of the user<br>
- [ ] Config have more controls! Enable or Disable the command<br>
