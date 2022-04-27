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
use pocketmine\Server;
use pocketmine\scheduler\Task;

class TheTask extends Task
{
    private SeeDevice $plugin;
    private string $format;

    public function __construct(SeeDevice $caller)
    {
        $this->plugin = $caller;
        $this->format = $this->plugin->getOOHFormat();
    }

    public function onRun(): void
    {
        foreach (Server::getInstance()->getOnlinePlayers() as $player) {
            $player->setNameTagVisible();
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
        $format = $this->format;
        $format = str_replace("%health%", round($player->getHealth()), $format);
        $format = str_replace("%max_health%", $player->getMaxHealth(), $format);
        $format = str_replace("%os%", (is_null($this->plugin->getFakeOs($player)) ? $this->plugin->getPlayerOs($player) : $this->plugin->getFakeOs($player)), $format);
        return $format;
    }
}