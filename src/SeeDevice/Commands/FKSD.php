<?php
namespace SeeDevice\Commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase as Plugin;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\lang\TranslationContainer;
class FKSD extends Command {
	public static $pr = "§a[SeeDevice] §f";

public function __construct(string $name, Plugin $callerapi){
		parent::__construct(
			$name,
			"Edit the device of a player",
			"/fakeos <playername-self> <name_of_OS>",
			["fkos"]
		);
	$this->setPermission("SeeDevice.command.fakeos");
	$this->api = $callerapi;
	}
public function execute(CommandSender $sender, $command, array $args){
		$usages = "/fakedevice <playername-self> <name_of_OS>";
		if(!$this->testPermission($sender)){
			
			return $sender->sendMessage(self::$pr.new TranslationContainer("commands.generic.permission"));
		}
		if(count($args) !=2){$sender->sendMessage(self::$pr."§4ERROR:§f You are using a bad usage of the command! Usage:".$usages);return false;}
		if($args[0] == "self"){
			if(!$sender instanceof Player){ $sender->sendMessage(self::$pr."§4ERROR:§f You are using the usage for edit your name OS in game! The console can't edit her device name".$usages);return false;}
			$os = $this->api->getUos($sender);
			$this->api->os[$sender->getName()] = $args[1];
			$sender->sendMessage(self::$pr."You have successfully changed your os name.\n§3Before: $os\n§7Now: ".$this->api->os[$sender->getName()]);
			return true;
		}else{
			$pl = $this->api->getServer()->getPlayer($args[0]);
			if(!$pl instanceof Player){$sender->sendMessage(self::$pr."§4ERROR: §fThe player with the name \"$args[0]\" seem to don't be §aONLINE!"); return false;}
			$os = $this->api->getUos($pl);
			$this->api->os[$pl->getName()] = $args[1];
			$sender->sendMessage(self::$pr."You have successfully changed your os name.\n§3Before: $os\n§7Now: ".$this->api->os[$pl->getName()]);
			return true;
		}
}
}