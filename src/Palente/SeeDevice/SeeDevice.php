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
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\utils\Config;
use Palente\SeeDevice\Commands\SD;
use Palente\SeeDevice\Commands\FakeOs;
class SeeDevice extends PluginBase implements Listener{
  public static $instance;
  public static $prefix = "§a[SeeDevice] §f";
  private $os = [];
  private $device = [];
  public $fakeOsEnabled = true;
  private $OOHFormat; //OOH mean OsOverHead
  /*The list of these OS are from Virvolta a well known ""developper"" on roblox.
  Github: https://github.com/Virvolta
  */
  private $listOfOs = ["Unknown", "Android", "iOS", "macOS", "FireOS", "GearVR", "HoloLens", "Windows10", "Windows", "EducalVersion","Dedicated", "PlayStation4", "Switch", "XboxOne"];

  public function onLoad(){
      self::$instance = $this;
      $this->getServer()->getCommandMap()->register("SeeDevice", new SD("seedevice",$this));
      $this->getServer()->getCommandMap()->register("SeeDevice", new FakeOs("fakeos",$this));
  }

  /**
   * getInstance
   * @return static
   */
  public static function getInstance() : self{
      //Did you tried my well known plugin LuckyBlock?
      //No? Try it now: https://poggit.pmmp.io/p/LuckyBlock
      return self::$instance;
  }
  public function onEnable(){
      #PocketMine-MP doesn't allow me to send useless message so, Hey you!
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      @mkdir($this->getDataFolder());
      if(!file_exists($this->getDataFolder() . 'config.yml')) $this->saveResource('config.yml');
      $config = new Config($this->getDataFolder().'config.yml',Config::YAML);
      if($config->get("Enable_ShowOsOverHead",true) == "true") {
          $this->OOHFormat = $config->get("OsOverHead_Format", "§f\n[§c%health%§f/%max_health%]\n§5%os%");
          $this->getLogger()->info("[OsOverHead] is enabled!");
          $this->getScheduler()->scheduleRepeatingTask(new TheTask($this), 11);
      }else $this->getLogger()->info("[OsOverHead] is not enabled!");
      if($config->get("Enable_FakeOs",true) == "true") {
          $this->fakeOsEnabled = true;
          $this->getLogger()->info("[Command] The Command FakeOs is enabled.");
      } else {
          $this->fakeOsEnabled = false;
          $this->getLogger()->info("[Command] The Command FakeOs is disabled! To enable it set 'Enable_FakeOs' to true in config.yml");
      }
  }
  public function onPacketReceived(DataPacketReceiveEvent $e){
      if($e->getPacket() instanceof LoginPacket){
          //Is the line below useless?
          if($e->getPacket()->clientData["DeviceOS"] !== null){
              $this->os[strtolower($e->getPacket()->username) ?? "unavailable"] = $e->getPacket()->clientData["DeviceOS"];
              $this->device[strtolower($e->getPacket()->username) ?? "unavailable"] = $e->getPacket()->clientData["DeviceModel"];
          }
      }
  }

  /**
   * @param Player $player
   * @return String|null
   * Get the OS of the Player
   *
   */
    public function getPlayerOs(Player $player) : ?string{
        $name = strtolower($player->getName());
        if(!isset($this->os[$name]) OR $this->os[$name] == null) return null;
        return $this->listOfOs[$this->os[$name]];
    }
    /**
     * @param Player $player
     * @return string|null
     * Get The Device of the Player
     */
    public function getPlayerDevice(Player $player) : ?string{
        $name = strtolower($player->getName());
        if(!isset($this->device[$name]) OR $this->device[$name] == null) return null;
        return $this->device[$name];
    }
    /**
     * @param Player $player
     * @param string $os
     * Set the Os of the player.
     */
    public function setPlayerOs(Player $player, string $os){
        //DISCOURAGED METHOD
        $this->os[strtolower($player->getName())] = $os;
    }
    /**
     * @return mixed
     * Get The Format of the OsOverHead
     */
    public function getOOHFormat()
    {
        return $this->OOHFormat;
    }
}