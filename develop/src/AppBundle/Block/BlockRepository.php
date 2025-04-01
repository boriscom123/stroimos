<?php


namespace AppBundle\Block;


use Sonata\BlockBundle\Model\BlockInterface;

class BlockRepository
{

    protected $blocks;

    public function __construct()
    {
        $this->blocks = [];
    }

    public function addBlock(BlockInterface $block)
    {
        $this->blocks[] = $block;
    }
}
