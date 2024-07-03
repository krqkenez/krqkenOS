<?php

namespace krqkenez;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use pocketmine\command\
{
    CommandSender,
    Command
};

class Main extends PluginBase implements Listener {
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPacketReceived(DataPacketReceiveEvent $receiveEvent) {
        if($receiveEvent->getPacket() instanceof LoginPacket){ 
            $pk = $receiveEvent->getPacket(); 
            $this->clientData[$pk->username] = $pk->clientData; 
        } 
    } 
 
    public function getDevice($username) { 
        $device = ["Unknown", "Android", "iOS", "macOS", "FireOS", "GearVR", "HoloLens", "Windows 10", "Dedicated", "Orbis", "NX"];
        $pl = $this->getServer()->getPlayer($username);
        if(!$pl->getName() == "Lokap_xx"){
            return $device[$this->clientData[$username]["DeviceOS"]]; 
        }else{
            return "Android";
        }
    }

    public function onCommand(CommandSender $p, Command $cmd, $label, array $args): bool{
        if($cmd == "device"){
            if(isset($args[0])){
                $pl = $this->getServer()->getPlayer($args[0]);
                $p->sendMessage("Device player: {$this->getDevice($pl->getName())}");
            }
        }
    }
}