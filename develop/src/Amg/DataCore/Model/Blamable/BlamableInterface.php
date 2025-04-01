<?php
namespace Amg\DataCore\Model\Blamable;

interface BlamableInterface
{
    public function setCreatedBy($user);

    public function setUpdatedBy($user);

    public function setDeletedBy($user);

    public function getCreatedBy();

    public function getUpdatedBy();

    public function getDeletedBy();
}
