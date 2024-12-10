<?php

declare(strict_types=1);

namespace Tatsomi\JoinTitle;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\utils\Config;

use jojoe77777\FormAPI\SimpleForm;

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
        $player->sendTitle($this->config->get("welcometitle"));
        $player->sendSubtitle($this->config->get("welcomesubtitle"));
        $this->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($player) {
            $this->form($player);
        }), 45);
    }

    public function form(Player $player): void
    {
        $form = new SimpleForm(function (Player $player, $data = null){
            if ($data === null) {
                $this->close($player);
            }
        });
        $form->setTitle($this->config->get("formtitle"));
        $form->setContent($this->config->get("formcontent"));
        $form->addButton($this->config->get("closebutton"));

        $form->sendToPlayer($player);
    }

    public function close(Player $player): void
    {
        /*
         * | خالی باشه مشکلی نیست |
         */
    }
}
