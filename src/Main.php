<?php

declare(strict_types=1);

namespace Tatsomi\JoinTitle;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener
{
    public Config $config;

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function onJoin(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();
        $player->sendTitle($this->config->get("title"));
    }
}
