<?php
#c'est un bon début
namespace SeeDevice;

#use tamere/lasauvage
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TX;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ServerSettingsRequestPacket;
use pocketmine\network\mcpe\protocol\ServerSettingsResponsePacket;
#gngngngn ta oublyai les config
#Bz ta mere
use pocketmine\utils\Config;
#Eh meh c pas maintenant les Config NON
class SeeDevice extends PluginBase implements Listener{
#ah
  
}public static $logger = null;
	public static $instance;
	
	public function onLoad(){
		self::$instance =$this;
    #Plus tard
#$this->getServer()->getCommandMap()->register("bztamere", new CommandInFuture("waaay digi les bz",$this));
}
	public function onEnable(){
  #Config un jour
 #Pmmp dont want not useful message so Hey!
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
}
public static function getInstance(){
	return self::$instance;
	}
#END OF THE PLUGIIINACER ZE Z ZOSN
}
public function onPacketReceived(DataPacketReceiveEvent $e){
    if($e->getPacket() instanceof \pocketmine\network\mcpe\protocol\LoginPacket){
      if($e->getPacket()->clientData["DeviceOS"] !== null){
      	$this->device[$e->getPacket()->username]=$e->getPacket()->clientData["DeviceOS"];
       }
}
  }
#La GROSSE FONCTION DE SES MORTS
public function getUD(Player $player){
  if(!isset($this->device[$player->getName()])) return 404;
 #Lol on retourne 404 genre c une erreur Html...
  if($this->device[$player->getName()] == null) return 404;
  $digilespd = $this->device[$player->getName()];
  return $this->translateVersion($digilespd);
}
#Traduction des Versions oui car sa retourne un chiffre enft mek
public function translateVersion($fdp){
  switch($fdp)
    case 1:
  $akha = "Android";
  break;
    case 2:
  $akha = "IOS";#Ios not good...
  break;
    case 3:
  $akha = "Mac";#Oh le fdp il a un mac eclater #FilsAPapa
  break;
    case 4:
  $akha = "FireOS"; #After forks of pmmp Forks of Android.. By Amazon
  break;
    case 5:
  $akha = "GearVR";#Reality Virtuel fdp de Leader Price
  break;
    case 6:
  $akha = "Hololens";#Euh.... just search on google..
  break;
    case 7:
  $akha = "Windows 10";
  break;
    case 8:
  $akha = "Windows 32, Educal version";
  break;
    case 9:
  $akha = "No name..";#If you have the Name of that
  break;
    case 10:
  $akha = "Playstation 4";
  break;
    case 11:
  $akha = "NX....";#NX no name...
  break;
 
  default:
  $akha = "Spoil casa de papel Moscou is dead.";
  break;
  }
}
#We close the tag php its Important
?>
