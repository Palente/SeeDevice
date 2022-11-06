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

namespace Palente\SeeDevice;

use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class TheTask extends Task
{
    /** @var SeeDevice */
    private SeeDevice $plugin;

    public function __construct(SeeDevice $caller)
    {
        $this->plugin = $caller;
    }

    public function onRun(): void
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            $format = $this->replaceFormat($player);
            $player->setScoreTag($format);
        }
    }

    /**
     * @param Player $player
     * @return string
     */
    private function replaceFormat(Player $player): string
    {
        return str_replace(array("%health%", "%max_health%", "%os%"), array(round($player->getHealth()), $player->getMaxHealth(), (is_null($this->plugin->getFakeOs($player)) ? $this->plugin->getPlayerOs($player) : $this->plugin->getFakeOs($player))), $this->plugin->getOOHFormat());
    }
}
