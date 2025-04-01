<?php
namespace Amg\DataCore\Model\Timestampable;

interface TimestampableInterface
{
    public function setCreatedAt(\DateTime $createdAt);

    public function getCreatedAt();

    public function setUpdatedAt(\DateTime $updatedAt);

    public function getUpdatedAt();
}
