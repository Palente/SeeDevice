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
use pocketmine\player\Player;

class SD extends Command
{
    /** @var SeeDevice */
    private SeeDevice $plugin;

    public function __construct(string $name, SeeDevice $caller)
    {
        parent::__construct(
            $name,
            "See the device/OS of a player",
            "/seedevice [player]",
            ["sd"]
        );
        $this->setPermission("SeeDevice.seedevice");
        $this->plugin = $caller;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        $pr = SeeDevice::$prefix;
        if (!$this->testPermission($sender)) {
            return;
        }
        if (!$this->plugin->seeDeviceCommandEnabled) {
            return;
        }
        if (count($args) === 0) {
            if (!$sender instanceof Player) {
                return;
            }
            if (!$this->plugin->getPlayerOs($sender) || !$this->plugin->getPlayerDevice($sender)) {
                $sender->sendMessage("{$pr}§4What Happened, i can't get your OS! try again later! ");
                return;
            }
            $sender->sendMessage($pr . $this->replaceFormat($sender));
        } else {
            $pl = $this->plugin->getServer()->getPlayerByPrefix($args[0]);
            if (!$pl instanceof Player) {
                $sender->sendMessage("{$pr}§4ERROR: §fThe player with the name \"$args[0]\" seem to don't be §aONLINE!");
                return;
            }
            if (!$this->plugin->getPlayerOs($pl) || !$this->plugin->getPlayerDevice($pl)) {
                $sender->sendMessage("{$pr}This player has some problem with SeeDevice, try again later!");
                return;
            }
            $sender->sendMessage($pr . $this->replaceFormat($pl));
        }
    }

    /**
     * @param Player $player
     * @return string
     * replace the tags with real text! (Magic function)
     */
    private function replaceFormat(Player $player): string
    {
        return str_replace(array("%name%", "%os%", "%fakeos%", "%device%", "%ip%"), array($player->getName(), $this->plugin->getPlayerOs($player), $this->plugin->getFakeOs($player), $this->plugin->getPlayerDevice($player), $player->getNetworkSession()->getIp()), $this->plugin->getSDCFormat());
    }
}
