<?php
/*
 * SeeDevice is a plugin working under the software pmmp
 *  Copyright (C) 2020  Palente

 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.

 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.

 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Palente\SeeDevice\Commands;
use Palente\SeeDevice\SeeDevice;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
class SD extends Command {
    private $plugin;
    public function __construct(string $name, SeeDevice $caller){
        parent::__construct(
            $name,
            "See the device/OS of a player",
            "/seedevice [player]",
            ["sd"]
            );
        $this->setPermission("SeeDevice.command.sd");
        $this->plugin = $caller;
    }
    public function execute(CommandSender $sender, $command, array $args){
        $usage = $this->getUsage();
        $pr = SeeDevice::$prefix;
        if(!$this->testPermission($sender))return;
        if(count($args) == 0){
            if(!$sender instanceof Player) return;
            //he want to see his own data
            if(!$this->plugin->getPlayerOs($sender) OR !$this->plugin->getPlayerDevice($sender)){
                $sender->sendMessage($pr."§4 An Error has occured, please try again later..");
                return;
            }
            $nm = $sender->getName();
            $os = $this->plugin->getPlayerOs($sender);
            $dv = $this->plugin->getPlayerDevice($sender);
            $ip = $sender->getAddress();
            $sender->sendMessage($pr."§e::INFORMATIONS::\n§6Player's Name: $nm\n§5Player's OS: $os\n§dPlayer's Device: $dv\n§2Player's IP: $ip");
            return;
        }else{
            $pl = $this->plugin->getServer()->getPlayer($args[0]);
            if(!$pl instanceof Player){$sender->sendMessage($pr."§4ERROR: §fThe player with the name \"$args[0]\" seem to don't be §aONLINE!"); return;}
            if(!$this->plugin->getPlayerOs($pl) OR !$this->plugin->getPlayerDevice($pl)){
                $sender->sendMessage($pr."§4An Error has occured, please try again later..");
                return;
            }
            $nm = $pl->getName();
            $os = $this->plugin->getPlayerOs($pl);
            $dv = $this->plugin->getPlayerDevice($pl);
            $ip = $pl->getAddress();
            $sender->sendMessage($pr."§eINFORMATIONS\n§6Player's Name: $nm\n§5Player's OS: $os\n§dPlayer's Device: $dv\n§2Player's IP: $ip");
            return;
        }
    }
}