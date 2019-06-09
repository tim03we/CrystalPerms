# CrystalPerms
CrystalPerms is a small special system that allows players to assign groups and assign rights to these groups.

# Commands
Command | Permission | Default | Description
------- | ---------- | ------- | ------------
/setgroup | crystalperms.setgroup | op | Give a player another group

# API
Get the group from one player
```php
$this->getServer()->getPluginManager()->getPlugin("CrystalPerms")->getGroup($player);
```
Give a player another group
```php
$this->getServer()->getPluginManager()->getPlugin("CrystalPerms")->setGroup($player, "Player");
```
# Configs
```
# Choose true or false to enable/disable the chat function
chat-format: true

# Change the messages according to your choice.
messages:   
    kick: "You just got the {group} rank."
    group-success: "You gave the player {player} the group {group} assigned."
    group-not-exist: "This group does not exist."
```
```
default: "Player"

Player:
    permissions:
    - pocketmine.command.transfer
    inheritance: []
    chat-format: "§7Player §8| §7{player} §8> §f{msg}"
    nametag-format: "§7Player §8| §7{player}"
Owner:
    permissions:
    - pocketmine.command.ban
    - pocketmine.command.kick
    inheritance:
    - Player
    chat-format: "§4Owner§8 | §4{player} §8> §f{msg}"
    nametag-format: "§4Owner §8| §4{player}"
```