<?php

namespace achedon\randomOre;

use achedon\randomOre\Block\RandomOre;
use pocketmine\block\BlockFactory;
use pocketmine\item\ItemFactory;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase{

    private static Main $instance;

    public static int $id;
    public static int $meta;
    public static array $drops = [];

    protected function onEnable(): void
    {
        self::$instance = $this;

        @mkdir(self::getDataFolder());
        $this->saveResource("config.yml");

        $this->getLogger()->info("§2RandomOre enable");

        self::$id = explode(":",(string)self::config()->get("randomOre"))[0];
        self::$meta = explode(":",(string)self::config()->get("randomOre"))[1] ?? 0;
        foreach(self::config()->get("drop") as $value){
            $explode = explode(":",$value);
            $id = $explode[0];
            $meta = $explode[1] ?? 0;
            self::$drops[] = ItemFactory::getInstance()->get($id,$meta);
        }
        BlockFactory::getInstance()->register(new RandomOre(),true);
    }

    protected function onDisable(): void
    {
        $this->getLogger()->info("§4RandomOre disable");
    }

    public static function getInstance(): self{
        return self::$instance;
    }

    public static function config(): Config{
        return new Config(self::getInstance()->getDataFolder()."config.yml",Config::YAML);
    }

}