<?php
namespace Amg\DataCore\Model\LocaleAware;

interface LocaleAwareInterface
{
    public function getLocale();

    public function setLocale($locale);
}
