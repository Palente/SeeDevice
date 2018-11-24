<?php
#c'est un bon début
namespace SeeDevice; 
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TX;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ServerSettingsRequestPacket;
use pocketmine\network\mcpe\protocol\ServerSettingsResponsePacket;
use pocketmine\utils\Config;
use SeeDevice\Commands\SD;
use SeeDevice\Commands\FKSD;
use SeeDevice\TheTask;
class SeeDevice extends PluginBase implements Listener{
  public static $logger = null;
	public static $instance;
	
	public function onLoad(){
		self::$instance = $this;
    #https://forums.pmmp.io/threads/enforcement-of-rule-c2a-fallback-prefix.6995/ UPDATED
    $this->getServer()->getCommandMap()->register("SeeDevice", new SD("seedevice",$this));
    $this->getServer()->getCommandMap()->register("SeeDevice", new FKSD("fakeos",$this));
}
	public function onEnable(){
    #Pmmp dont want not useful message so Hey!
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    @mkdir($this->getDataFolder());
    if(!file_exists($this->getDataFolder() . 'config.yml')) {
      $this->saveResource('config.yml');
    }
    $config = new Config($this->getDataFolder().'config.yml',Config::YAML);
    if($config->get("TaskName_Device") == "true"){
      $this->getScheduler()->scheduleRepeatingTask(new TheTask($this), 11);
    }
}
  public static function getInstance(){
  	return self::$instance;
  	}
  public function onPacketReceived(DataPacketReceiveEvent $e){
    if($e->getPacket() instanceof \pocketmine\network\mcpe\protocol\LoginPacket){
      if($e->getPacket()->clientData["DeviceOS"] !== null){
        $this->os[$e->getPacket()->username]=$e->getPacket()->clientData["DeviceOS"];
        $this->device[$e->getPacket()->username]=$e->getPacket()->clientData["DeviceModel"];
      }
    }
  }
  #Get The device OS like Android
  public function getUos(Player $player){
    if(!isset($this->os[$player->getName()])) return 404;
    if($this->os[$player->getName()] == null) return 404;
    $hirss = $this->os[$player->getName()];
    #Now We can change the name of the os So we have to check if its an int
    if(is_int($hirss)) return $this->translateVersion($hirss);
    else return $hirss;
  }
  public function getUsd(Player $player){
    if(!isset($this->device[$player->getName()])) return 404;
    if($this->device[$player->getName()] == null) return 404;
    return $this->device[$player->getName()];
  }
#Traduction des Versions oui car sa retourne un chiffre enft mek
  public function translateVersion($fdp){
    switch($fdp){
      case 1:
        $akha = "Android";
      break;
      case 2:
        $akha = "IOS";
      break;
      case 3:
        $akha = "Mac"; 
      break;
      case 4:
        $akha = "FireOS"; #After forks of pmmp Forks of Android.. By Amazon
      break;
      case 5:
        $akha = "GearVR"; 
      break;
      case 6:
        $akha = "Hololens";
      break;
      case 7:
        $akha = "Windows_10";
      break;
      case 8:
        $akha = "Windows_32,Educal_version"; # Minecraft help people with learning programmation waaaaw waaaaw And?
      break;
      case 9:
        $akha = "NoName"; #If you have the Name of that send me a mp
      break;
      case 10:
        $akha = "Playstation_4";
      break;
      case 11:
        $akha = "NX"; #NX no name... wollah c vrai
      break;
   
      default:
        $akha = "Not_Registered!"; # Maybe i missed one
      break;
    }
    return $akha;
  }
}