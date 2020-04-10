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
class FakeOs extends Command {
    private $plugin;
	public function __construct(string $name, SeeDevice $caller){
		parent::__construct(
			$name,
			"Edit the Os of a player",
			"/fakeos <player-self> <OS>",
			["fkos"]
		);
        $this->setPermission("SeeDevice.command.fakeos");
        $this->plugin = $caller;
	}
	public function execute(CommandSender $sender, $command, array $args){
		$usages = $this->getUsage();
		$pr = SeeDevice::$prefix;
		if(!$this->plugin->fakeOsEnabled)return;
		if(!$this->testPermission($sender)) return;
		if(count($args) !=2){
		    $sender->sendMessage($pr."§4ERROR:§f Bad Usage of the Command! Usage:".$usages);
		    return;
		}
		if($args[0] == "self"){
			if(!$sender instanceof Player){
			    $sender->sendMessage($pr."§4ERROR:§f Well, you no longer want to be a machine, i can't help you!");
			    return;
			}
			$fakeOs = implode(" ", array_slice($args, 1));
			if($fakeOs == ""){
			    $this->plugin->removeFakeOs($sender);
			    $sender->sendMessage($pr. "You have successfully removed your fake Os Name!");
			    return;
            }
			$os = $this->plugin->getPlayerOs($sender);
			$this->plugin->setFakeOs($sender, $fakeOs);
			$sender->sendMessage($pr."You have successfully changed your os name.\n§3Before: $os\n§7Now: ".$this->plugin->getFakeOs($sender));
			return;
		}else{
			$pl = $this->plugin->getServer()->getPlayer($args[0]);
			if(!$pl instanceof Player){
			    $sender->sendMessage($pr."§4ERROR: §fThe player with the name \"$args[0]\" seem to don't be §aONLINE!");
			    return;
			}
			$fakeOs = implode(" ", array_slice($args, 1));
            if($fakeOs == ""){
                $this->plugin->removeFakeOs($pl);
                $sender->sendMessage($pr. "You have successfully removed {$pl->getName()}'s fake Os Name!");
                return;
            }
			$this->plugin->setFakeOs($pl,$fakeOs);
			$sender->sendMessage($pr."You have successfully changed the os name of ".$pl->getName()."\n3To:".$this->plugin->getFakeOs($pl));
			return;
		}
	}
}