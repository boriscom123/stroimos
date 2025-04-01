<?php
namespace Import\Helper;

use Import\BaseImport;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class TargetField
{
    public $sourceName;
    public $targetName;

    /**
     * @var PropertyAccessor
     */
    protected $propertyAccessor;

    public function __construct($sourceName, $targetName = null)
    {
        if (!isset($targetName)) {
            $targetName = lcfirst(strtr(ucwords(strtr($sourceName, array('_' => ' ', '.' => '_ ', '\\' => '_ '))), array(' ' => '')));
        }

        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->sourceName = $sourceName;
        $this->targetName = $targetName;
    }

    public function canApply($entity)
    {
        return $this->propertyAccessor->isWritable($entity, $this->targetName);
    }

    public function apply($entity, $sourceValue)
    {
        $sourceValue = $this->convertValue($sourceValue);
        $this->setValue($entity, $sourceValue);
    }

    protected function convertValue($value)
    {
        return $value;
    }

    protected function setValue($entity, $sourceValue)
    {
        $this->propertyAccessor->setValue($entity, $this->targetName, $sourceValue);
    }
}

class BaseImportAwareTagsTargetField extends TargetField
{
    /**
     * @var BaseImport
     */
    protected $baseImport;

    public function __construct($sourceName, $targetName = null, BaseImport $baseImport)
    {
        parent::__construct($sourceName, $targetName);
        $this->baseImport = $baseImport;
    }
}

class BooleanTargetField extends TargetField
{
    protected function convertValue($value)
    {
        return !empty($value);
    }
}

class DateTimeTargetField extends TargetField
{
    protected function convertValue($value)
    {
        return new \DateTime($value);
    }
}

class TagsTargetField extends BaseImportAwareTagsTargetField
{
    protected function convertValue($value)
    {
        $titles = explode('|', $value);
        return $this->baseImport->getTagsReferencesArray($titles);
    }
}

class RubricsTargetField extends BaseImportAwareTagsTargetField
{
    protected function convertValue($value)
    {
        $titles = explode('|', $value);
        return $this->baseImport->getRubricsReferencesArray($titles);
    }
}

class CallableTargetValue extends TargetField
{
    /**
     * @var callable
     */
    private $callback;

    public function __construct($sourceName, $targetName = null, callable $callback)
    {
        parent::__construct($sourceName, $targetName);
        $this->callback = $callback;
    }

    protected function convertValue($value)
    {
        return $this->callback($value);
    }
}

class ContentProcessorTargetField extends TargetField
{
    protected function convertValue($value)
    {
        $value = preg_replace('~(href|src)="\s*http://stroi\.mos\.ru/~', '$1="/', $value);

        return $value;
    }
}

class CommonFieldSetter
{
    /**
     * @var TargetField[]
     */
    protected $importFieldMap = [];

    public function __construct()
    {
        $this->preProcessImportFieldMap();
    }

    protected function preProcessImportFieldMap()
    {
        /** @var TargetField[] $fields */
        $fields = [];
        $fields[] = new TargetField('name', 'title');
        $fields[] = new TargetField('description', 'teaser');
        $fields[] = new ContentProcessorTargetField('text', 'content');
        $fields[] = new ContentProcessorTargetField('page_text', 'content');
        $fields[] = new TargetField('slug');
        $fields[] = new TargetField('meta_description');
        $fields[] = new TargetField('meta_keywords');
        $fields[] = new BooleanTargetField('is_published', 'publishable');
        $fields[] = new DateTimeTargetField('published_at', 'publishStartDate');
        $fields[] = new DateTimeTargetField('created_at');
        $fields[] = new DateTimeTargetField('updated_at');

        foreach ($fields as $field) {
            $this->importFieldMap[$field->sourceName] = $field;
        }
    }

    public function addTargetField(TargetField $targetField)
    {
        $this->importFieldMap[$targetField->sourceName] = $targetField;
    }

    public function importCommonFields($entity, $sourceRow, array $excludeFields = [])
    {
        $excludeFields = array_flip($excludeFields);
        foreach ($this->importFieldMap as $sourceFieldName => $targetField) {
            if (
                isset($excludeFields[$sourceFieldName]) ||
                !isset($sourceRow[$sourceFieldName]) ||
                !$targetField->canApply($entity)
            ) {
                continue;
            }

            $targetField->apply($entity, $sourceRow[$sourceFieldName]);
        }
    }
}
