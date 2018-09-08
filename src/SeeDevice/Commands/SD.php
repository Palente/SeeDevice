<?php
namespace SeeDevice\Commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase as Plugin;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\lang\TranslationContainer;
class SD extends Command {
	public static $pr = "§a[SeeDevice] §f";
public function __construct(string $name, Plugin $callerapi){
		parent::__construct(
			$name,
			"See the device/OS of a player",
			"/seedevice [player]",
			["sd"]
		);
	$this->setPermission("SeeDevice.command.sd");
	$this->api = $callerapi;
	}
public function execute(CommandSender $sender, $command, array $args){
		$usages = "/seedevice [player]";
		if(!$this->testPermission($sender)){
			
			return $sender->sendMessage(self::$pr.TranslationContainer("commands.generic.permission"));
		}
		if(count($args) == 0){
			if(!$sender instanceof Player) return false;
			#he want to see his own data
			if($this->api->getUos($sender) == 404 OR $this->api->getUsd($sender) == 404){
			$sender->sendMessage(self::$pr."§4 An Error has occured, please retry Later..");
			return false;
		}
		$nm = $sender->getName();
		$os = $this->api->getUos($sender);
		$dv = $this->api->getUsd($sender);
		$ip = $sender->getAddress();
		$sender->sendMessage(self::$pr."§e::INFORMATIONS::\n§6Player's Name: $nm\n§5Player's OS: $os\n§dPlayer's Device: $dv\n§2Player's IP: $ip");
		return true;
		}else{
			$pl = $this->api->getServer()->getPlayer($args[0]);
			if(!$pl instanceof Player){$sender->sendMessage(self::$pr."§4ERROR: §fThe player with the name \"$args[0]\" seem to don't be §aONLINE!"); return false;}
			if($this->api->getUos($pl) == 404 OR $this->api->getUsd($pl) == 404){
			$player->sendMessage(self::$pr."§4An Error has occured, please retry Later..");
			return false;
		}
			$nm = $pl->getName();
		$os = $this->api->getUos($pl);
		$dv = $this->api->getUsd($pl);
		$ip = $pl->getAddress();
		$sender->sendMessage(self::$pr."§eINFORMATIONS\n§6Player's Name: $nm\n§5Player's OS: $os\n§dPlayer's Device: $dv\n§2Player's IP: $ip");
		return true;
		}
}
}