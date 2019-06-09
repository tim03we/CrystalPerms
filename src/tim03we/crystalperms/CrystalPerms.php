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
use pocketmine\permission\PermissionManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class CrystalPerms extends PluginBase implements Listener {

    public function onEnable() {
        @mkdir($this->getDataFolder() . "players/");
        $this->saveResource("settings.yml");
        $this->saveResource("groups.yml");
        $this->cfg = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        $this->gcfg = new Config($this->getDataFolder() . "groups.yml", Config::YAML);
        $this->getServer()->getPluginManager()->registerEvents(new LoginListener($this), $this);
        if($this->cfg->get("chat-format", !false)) {
            $this->getServer()->getPluginManager()->registerEvents(new ChatListener($this), $this);
        }
        $this->getServer()->getCommandMap()->register("setgroup", new \tim03we\crystalperms\cmd\SetGroupCommand($this));
    }

    public function format(array $permissions) {
        $last = [];
        foreach ($permissions as $permission) {
            if ($permission === "*") {
                foreach(PermissionManager::getInstance()->getPermissions() as $perm) {
                    $last[$perm->getName()] = true;
                }
            } else {
                $last[$permission] = true;
            }
        }
        return $last;
    }

    public function givePermissions($player, $playerfile) {
        $player->addAttachment($this)->clearPermissions();
        $group = $playerfile->get("group");
        foreach ($this->gcfg->getNested($group . ".inheritance") as $groups) {
            $player->addAttachment($this)->setPermissions($this->format(array_merge($this->gcfg->getNested($group . ".permissions"), $this->gcfg->getNested($groups . ".permissions"))));
        }
    }

    public function getPlayerFile($player) {
        $playerfile = new Config($this->getDataFolder() . "players/" . strtolower($player->getName()) . ".yml", Config::YAML);
        return $playerfile;
    }

    public function getGroup($player) {
        return $this->getPlayerFile($player)->get("group");
    }

    public function setGroup($player, $group) {
        $this->getPlayerFile($player)->set("group", $group);
        $this->getPlayerFile($player)->save();
    }
}