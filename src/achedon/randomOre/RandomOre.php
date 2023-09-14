<?php

namespace achedon\randomOre;

use achedon\randomOre\events\PlayerEvents;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class RandomOre extends PluginBase
{

    use SingletonTrait;

    /** @var Item[] $drops */
    public array $drops = [];
    public string $randomOre;

    protected function onEnable(): void
    {
        @mkdir(self::getDataFolder());
        $this->saveResource("config.yml");

        $this->randomOre = self::config()->get("randomOre");

        $parser = StringToItemParser::getInstance();
        foreach (self::config()->get("drop") as $value) {
            $drop = $parser->parse($value);
            if (!is_null($drop)) $this->drops[] = $drop;
        }

        $this->getServer()->getPluginManager()->registerEvents(new PlayerEvents(), $this);
    }

    private static function config(): Config
    {
        return new Config(self::getInstance()->getDataFolder() . "config.yml", Config::YAML);
    }

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

}