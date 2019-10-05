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

namespace tim03we\crystalperms\cmd;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;

class SetGroupCommand extends Command {

    public function __construct(\tim03we\crystalperms\CrystalPerms $plugin)
    {
        parent::__construct("setgroup", "CrystalPerms Command", "/setgroup <player> <group>");
        $this->plugin = $plugin;
        $this->setPermission("cp.cmd.setgroup");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$this->testPermission($sender)) {
			return false;
		}
        if(isset($args[0]) && isset($args[1])) {
            $target = $this->plugin->getServer()->getPlayer($args[0]);
            if($target == null) {
                $pfile = new Config($this->plugin->getDataFolder() . "players/" . strtolower($args[0]) . ".yml", Config::YAML);
                if(!file_exists($this->plugin->getDataFolder() . "players/" . strtolower($args[0]) . ".yml")) {
                    if($this->plugin->gcfg->exists($args[1])) {
                        $pfile->set("group", $args[1]);
                        $pfile->save();
                        $msg = $this->plugin->cfg->getNested("messages.group-success");
                        $msg = str_replace("{player}", strtolower($args[0]), $msg);
                        $msg = str_replace("{group}", $args[1], $msg);
                        $sender->sendMessage($msg);
                    } else {
                        $sender->sendMessage($this->plugin->cfg->getNested("messages.group-not-exist"));
                    }
                } else {
                    if($this->plugin->gcfg->exists($args[1])) {
                        $pfile->set("group", $args[1]);
                        $pfile->save();
                        $msg = $this->plugin->cfg->getNested("messages.group-success");
                        $msg = str_replace("{player}", strtolower($args[0]), $msg);
                        $msg = str_replace("{group}", $args[1], $msg);
                        $sender->sendMessage($msg);
                    } else {
                        $sender->sendMessage($this->plugin->cfg->getNested("messages.group-not-exist"));
                    }
                }
            } else {
                $pfile = new Config($this->plugin->getDataFolder() . "players/" . strtolower($target->getName()) . ".yml", Config::YAML);
                if(!file_exists($this->plugin->getDataFolder() . "players/" . strtolower($target->getName()) . ".yml")) {
                    if($this->plugin->gcfg->exists($args[1])) {
                        $pfile->set("group", $args[1]);
                        $pfile->save();
                        $msg = $this->plugin->cfg->getNested("messages.group-success");
                        $msg = str_replace("{player}", strtolower($target->getName()), $msg);
                        $msg = str_replace("{group}", $args[1], $msg);
                        $sender->sendMessage($msg);
                        $kick = $this->plugin->cfg->getNested("messages.kick");
                        $kick = str_replace("{group}", $args[1], $kick);
                        $target->kick($kick, false);
                    } else {
                        $sender->sendMessage($this->plugin->cfg->getNested("messages.group-not-exist"));
                    }
                } else {
                    if($this->plugin->gcfg->exists($args[1])) {
                        $pfile->set("group", $args[1]);
                        $pfile->save();
                        $msg = $this->plugin->cfg->getNested("messages.group-success");
                        $msg = str_replace("{player}", strtolower($target->getName()), $msg);
                        $msg = str_replace("{group}", $args[1], $msg);
                        $sender->sendMessage($msg);
                        $kick = $this->plugin->cfg->getNested("messages.kick");
                        $kick = str_replace("{group}", $args[1], $kick);
                        $target->kick($kick, false);
                    } else {
                        $sender->sendMessage($this->plugin->cfg->getNested("messages.group-not-exist"));
                    }
                }
            }
        } else {
            $sender->sendMessage($this->getUsage());
        }
    }
}
