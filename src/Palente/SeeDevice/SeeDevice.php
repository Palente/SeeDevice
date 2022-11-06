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

use Palente\SeeDevice\Commands\FakeOs;
use Palente\SeeDevice\Commands\SD;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class SeeDevice extends PluginBase implements Listener
{
    /** @var string */
    public static string $prefix = "§a[SeeDevice] §f";
    /** @var self|null */
    private static ?SeeDevice $instance;
    /** @var bool */
    public bool $fakeOsEnabled = true;
    /** @var bool */
    public bool $seeDeviceCommandEnabled = true;
    /** @var array<string> */
    private array $os = [];
    /** @var array<string> */
    private array $fakeOs = [];
    /** @var array<string> */
    private array $device = [];
    /** @var string */
    private string $formatSDCommand = ""; //Format SeeDevice Command
    /** @var string */
    private string $OOHFormat = ""; //OOH, mean OsOverHead
    /** @var array<string> */
    private array $listOfOs = ["Unknown", "Android", "iOS", "macOS", "FireOS", "GearVR", "HoloLens", "Windows10", "Windows", "EducalVersion", "Dedicated", "PlayStation4", "Switch", "XboxOne"];

    /**
     * @return SeeDevice|null
     */
    public static function getInstance(): ?SeeDevice
    {
        return self::$instance;
    }

    public function onLoad(): void
    {
        self::$instance = $this;
        $this->getServer()->getCommandMap()->register("SeeDevice", new SD("seedevice", $this));
        $this->getServer()->getCommandMap()->register("SeeDevice", new FakeOs("fakeos", $this));
    }

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        if (!file_exists($this->getDataFolder() . 'config.yml')) {
            $this->saveResource('config.yml');
        }
        $config = new Config($this->getDataFolder() . 'config.yml', Config::YAML);
        $heados = $config->get("OsOverHead_Format", "§f\n[§c%health%§f/%max_health%]\n§5%os%");
        if (($config->get("Enable_ShowOsOverHead", true) === true) && is_string($heados)) {
            $this->OOHFormat = $heados;
            $this->getLogger()->info("[OsOverHead] is enabled!");
            $this->getScheduler()->scheduleRepeatingTask(new TheTask($this), 20);
        } else {
            $this->getLogger()->info("[OsOverHead] is not enabled!");
        }
        if ($config->get("Enable_FakeOs", true) === true) {
            $this->fakeOsEnabled = true;
            $this->getLogger()->info("[Command] The Command FakeOs is enabled.");
        } else {
            $this->fakeOsEnabled = false;
            $this->getLogger()->info("[Command] The Command FakeOs is disabled! To enable it set 'Enable_FakeOs' to true in config.yml");
        }
        $format = $config->get("SeeDeviceCommand_Format");
        if (($config->get("Enable_SeeDeviceCommand", true) === true) && is_string($format)) {
            $this->seeDeviceCommandEnabled = true;
            $this->formatSDCommand = $format;
            $this->getLogger()->info("[Command] The Command SeeDevice is enabled.");
        } else {
            $this->seeDeviceCommandEnabled = false;
            $this->getLogger()->info("[Command] The Command SeeDevice is disabled! To enable it set 'Enable_SeeDeviceCommand' to true in config.yml");
        }
    }

    /**
     * @param PlayerLoginEvent $event
     * @return void
     */
    public function onPlayerLogin(PlayerLoginEvent $event): void
    {
        $player = $event->getPlayer();
        $data = $player->getPlayerInfo()->getExtraData();
        /** @var array<string> $data */
        if ($data["DeviceOS"] !== null) {
            $this->os[$player->getName()] = $data["DeviceOS"];
        }
        if ($data["DeviceModel"] !== null) {
            $this->device[$player->getName()] = $data["DeviceModel"];
        }
    }

    /**
     * @param Player $player
     * @return String|null
     * Get the OS of the Player
     */
    public function getPlayerOs(Player $player): ?string
    {
        if (!isset($this->os[$player->getName()]) || is_null($this->os[$player->getName()])) {
            return null;
        }
        return $this->listOfOs[$this->os[$player->getName()]];
    }

    /**
     * @param Player $player
     * @return string|null
     * Get The Device of the Player
     */
    public function getPlayerDevice(Player $player): ?string
    {
        if (!isset($this->device[$player->getName()]) || is_null($this->device[$player->getName()])) {
            return null;
        }
        return $this->device[$player->getName()];
    }

    /**
     * @param Player $player
     * @param string $os
     * Set the Os of the player.
     */
    public function setPlayerOs(Player $player, string $os): void
    {
        //DISCOURAGED METHOD
        $this->os[$player->getName()] = $os;
    }

    /**
     * @return string
     * Get The Format of the OsOverHead
     */
    public function getOOHFormat(): string
    {
        return $this->OOHFormat;
    }

    /**
     * @return string
     * Get The Format of the SeeDevice Command
     */
    public function getSDCFormat(): string
    {
        return $this->formatSDCommand;
    }

    /**
     * @param Player $player
     * @return string|null Get The FakeOs of a player
     * Get The FakeOs of a player
     */
    public function getFakeOs(Player $player): ?string
    {
        return $this->fakeOs[$player->getName()] ?? null;
    }

    /**
     * @param Player $player
     * @param string $fakeOs
     * @return bool
     * Set The FakeOs of a player
     */
    public function setFakeOs(Player $player, string $fakeOs): bool
    {
        if ($fakeOs === "") {
            return false;
        }
        $this->fakeOs[$player->getName()] = $fakeOs;
        return true;
    }

    /**
     * @param Player $player
     * Remove The FakeOs
     */
    public function removeFakeOs(Player $player): void
    {
        unset($this->fakeOs[$player->getName()]);
    }
}
