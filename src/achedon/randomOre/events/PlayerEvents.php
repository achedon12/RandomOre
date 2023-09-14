<?php

namespace achedon\randomOre\events;

use achedon\randomOre\RandomOre;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;

class PlayerEvents implements Listener
{

    public function onBreak(BlockBreakEvent $event): void
    {
        $block = $event->getBlock();

        $instance = RandomOre::getInstance();
        $randomOreBlockName = $instance->randomOre;
        if ($block->getName() === $randomOreBlockName) {
            $event->setDrops([$instance->drops[array_rand($instance->drops)]->setCount(mt_rand(1, 3))]);
        }
    }
}