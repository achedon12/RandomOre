<?php

namespace achedon\randomOre;

use achedon\randomOre\Block\ore;
use pocketmine\block\BlockFactory;
use pocketmine\item\ItemFactory;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class RandomOre extends PluginBase{
    
    use SingletonTrait;

    public int $id;
    public int $meta;
    public array $drops = [];

    protected function onEnable(): void
    {
        @mkdir(self::getDataFolder());
        $this->saveResource("config.yml");

        $this->id = (int)explode(":",(string)self::config()->get("randomOre"))[0];
        $this->meta = (int)explode(":",(string)self::config()->get("randomOre"))[1];
        foreach(self::config()->get("drop") as $value){
            $explode = explode(":",$value);
            $id = $explode[0];
            $meta = $explode[1] ?? 0;
            $this->drops[] = ItemFactory::getInstance()->get($id,$meta);
        }
        BlockFactory::getInstance()->register(new ore(),true);
    }

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    private static function config(): Config{
        return new Config(self::getInstance()->getDataFolder()."config.yml",Config::YAML);
    }

}