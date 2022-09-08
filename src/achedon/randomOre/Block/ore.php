<?php

namespace achedon\randomOre\Block;

use achedon\randomOre\RandomOre;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\Opaque;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\utils\SingletonTrait;

class ore extends Opaque
{
    use SingletonTrait;

    public function __construct()
    {
        parent::__construct(new BlockIdentifier(RandomOre::getInstance()->id, RandomOre::getInstance()->meta), 'random_ore', VanillaBlocks::COAL_ORE()->getBreakInfo());
    }

    public function getDropsForCompatibleTool(Item $item): array
    {
        return [RandomOre::getInstance()->drops[array_rand(RandomOre::getInstance()->drops)]];
    }


    public function getSilkTouchDrops(Item $item): array
    {
        return $this->getDropsForCompatibleTool($item);
    }

    public function getDrops(Item $item): array
    {

        if($this->breakInfo->isToolCompatible($item)){
            if($this->isAffectedBySilkTouch() && $item->hasEnchantment(VanillaEnchantments::SILK_TOUCH())){
                return $this->getDropsForCompatibleTool($item);
            }

            return $this->getDropsForCompatibleTool($item);
        }
        return [];

    }
}