<?php
namespace Amg\DataCore\Model\Translatable;

interface TranslationInterface
{
    public function getId();

    public function setTranslatable($translatable);

    public function getTranslatable();

    public function setLocale($locale);

    public function getLocale();

    public function isEmpty();
}
