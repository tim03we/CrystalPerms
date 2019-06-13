<?php

/*
 * Copyright (c) 2019 tim03we  < https://github.com/tim03we >
 * Discord: tim03we | TP#9129
 *
 * This software is distributed under "GNU General Public License v3.0".
 * This license allows you to use it and/or modify it but you are not at
 * all allowed to sell this plugin at any cost. If found doing so the
 * necessary action required would be taken.
 *
 * CrystalPerms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 *
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 */

namespace tim03we\crystalperms;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\Config;

class ChatListener implements Listener {

    public function __construct(CrystalPerms $pl)
    {
        $this->plugin = $pl;
    }

    public function onChat(PlayerChatEvent $event) {
        $player = $event->getPlayer();
        $pfile = new Config($this->plugin->getDataFolder() . "players/" . strtolower($player->getName()) . ".yml", Config::YAML);
        $chat = $this->plugin->gcfg->getNested($pfile->get("group") . ".chat-format");
        $chat = str_replace("{player}", $player->getName(), $chat);
        $chat = str_replace("{msg}", $event->getMessage(), $chat);
        $event->setFormat($chat);
    }
}