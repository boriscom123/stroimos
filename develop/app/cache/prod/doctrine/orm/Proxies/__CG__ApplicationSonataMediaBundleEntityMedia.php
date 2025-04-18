<?php

namespace Proxies\__CG__\Application\Sonata\MediaBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Media extends \Application\Sonata\MediaBundle\Entity\Media implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'id', 'category', 'copyright', '' . "\0" . 'Application\\Sonata\\MediaBundle\\Entity\\Media' . "\0" . 'createCategory', 'name', 'description', 'enabled', 'providerName', 'providerStatus', 'providerReference', 'providerMetadata', 'width', 'height', 'length', 'authorName', 'context', 'cdnIsFlushable', 'cdnFlushAt', 'cdnStatus', 'updatedAt', 'createdAt', 'binaryContent', 'previousProviderReference', 'contentType', 'size', 'galleryHasMedias');
        }

        return array('__isInitialized__', 'id', 'category', 'copyright', '' . "\0" . 'Application\\Sonata\\MediaBundle\\Entity\\Media' . "\0" . 'createCategory', 'name', 'description', 'enabled', 'providerName', 'providerStatus', 'providerReference', 'providerMetadata', 'width', 'height', 'length', 'authorName', 'context', 'cdnIsFlushable', 'cdnFlushAt', 'cdnStatus', 'updatedAt', 'createdAt', 'binaryContent', 'previousProviderReference', 'contentType', 'size', 'galleryHasMedias');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Media $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getCategory()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCategory', array());

        return parent::getCategory();
    }

    /**
     * {@inheritDoc}
     */
    public function setCategory($category)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCategory', array($category));

        return parent::setCategory($category);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateCategory()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreateCategory', array());

        return parent::getCreateCategory();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreateCategory($createCategory)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreateCategory', array($createCategory));

        return parent::setCreateCategory($createCategory);
    }

    /**
     * {@inheritDoc}
     */
    public function createCategory(\Doctrine\ORM\Event\LifecycleEventArgs $eventArgs)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'createCategory', array($eventArgs));

        return parent::createCategory($eventArgs);
    }

    /**
     * {@inheritDoc}
     */
    public function setCopyright($copyright)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCopyright', array($copyright));

        return parent::setCopyright($copyright);
    }

    /**
     * {@inheritDoc}
     */
    public function getCopyright()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCopyright', array());

        return parent::getCopyright();
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'prePersist', array());

        return parent::prePersist();
    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'preUpdate', array());

        return parent::preUpdate();
    }

    /**
     * {@inheritDoc}
     */
    public function setBinaryContent($binaryContent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setBinaryContent', array($binaryContent));

        return parent::setBinaryContent($binaryContent);
    }

    /**
     * {@inheritDoc}
     */
    public function getBinaryContent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBinaryContent', array());

        return parent::getBinaryContent();
    }

    /**
     * {@inheritDoc}
     */
    public function getMetadataValue($name, $default = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMetadataValue', array($name, $default));

        return parent::getMetadataValue($name, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function setMetadataValue($name, $value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMetadataValue', array($name, $value));

        return parent::setMetadataValue($name, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function unsetMetadataValue($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'unsetMetadataValue', array($name));

        return parent::unsetMetadataValue($name);
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', array($name));

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', array());

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescription($description)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescription', array($description));

        return parent::setDescription($description);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescription', array());

        return parent::getDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function setEnabled($enabled)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEnabled', array($enabled));

        return parent::setEnabled($enabled);
    }

    /**
     * {@inheritDoc}
     */
    public function getEnabled()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEnabled', array());

        return parent::getEnabled();
    }

    /**
     * {@inheritDoc}
     */
    public function setProviderName($providerName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProviderName', array($providerName));

        return parent::setProviderName($providerName);
    }

    /**
     * {@inheritDoc}
     */
    public function getProviderName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProviderName', array());

        return parent::getProviderName();
    }

    /**
     * {@inheritDoc}
     */
    public function setProviderStatus($providerStatus)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProviderStatus', array($providerStatus));

        return parent::setProviderStatus($providerStatus);
    }

    /**
     * {@inheritDoc}
     */
    public function getProviderStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProviderStatus', array());

        return parent::getProviderStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setProviderReference($providerReference)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProviderReference', array($providerReference));

        return parent::setProviderReference($providerReference);
    }

    /**
     * {@inheritDoc}
     */
    public function getProviderReference()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProviderReference', array());

        return parent::getProviderReference();
    }

    /**
     * {@inheritDoc}
     */
    public function setProviderMetadata(array $providerMetadata = array (
))
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProviderMetadata', array($providerMetadata));

        return parent::setProviderMetadata($providerMetadata);
    }

    /**
     * {@inheritDoc}
     */
    public function getProviderMetadata()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProviderMetadata', array());

        return parent::getProviderMetadata();
    }

    /**
     * {@inheritDoc}
     */
    public function setWidth($width)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWidth', array($width));

        return parent::setWidth($width);
    }

    /**
     * {@inheritDoc}
     */
    public function getWidth()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWidth', array());

        return parent::getWidth();
    }

    /**
     * {@inheritDoc}
     */
    public function setHeight($height)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHeight', array($height));

        return parent::setHeight($height);
    }

    /**
     * {@inheritDoc}
     */
    public function getHeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHeight', array());

        return parent::getHeight();
    }

    /**
     * {@inheritDoc}
     */
    public function setLength($length)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLength', array($length));

        return parent::setLength($length);
    }

    /**
     * {@inheritDoc}
     */
    public function getLength()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLength', array());

        return parent::getLength();
    }

    /**
     * {@inheritDoc}
     */
    public function setAuthorName($authorName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAuthorName', array($authorName));

        return parent::setAuthorName($authorName);
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthorName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAuthorName', array());

        return parent::getAuthorName();
    }

    /**
     * {@inheritDoc}
     */
    public function setContext($context)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContext', array($context));

        return parent::setContext($context);
    }

    /**
     * {@inheritDoc}
     */
    public function getContext()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContext', array());

        return parent::getContext();
    }

    /**
     * {@inheritDoc}
     */
    public function setCdnIsFlushable($cdnIsFlushable)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCdnIsFlushable', array($cdnIsFlushable));

        return parent::setCdnIsFlushable($cdnIsFlushable);
    }

    /**
     * {@inheritDoc}
     */
    public function getCdnIsFlushable()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCdnIsFlushable', array());

        return parent::getCdnIsFlushable();
    }

    /**
     * {@inheritDoc}
     */
    public function setCdnFlushAt(\DateTime $cdnFlushAt = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCdnFlushAt', array($cdnFlushAt));

        return parent::setCdnFlushAt($cdnFlushAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getCdnFlushAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCdnFlushAt', array());

        return parent::getCdnFlushAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedAt', array($updatedAt));

        return parent::setUpdatedAt($updatedAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedAt', array());

        return parent::getUpdatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt(\DateTime $createdAt = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedAt', array($createdAt));

        return parent::setCreatedAt($createdAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedAt', array());

        return parent::getCreatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setContentType($contentType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setContentType', array($contentType));

        return parent::setContentType($contentType);
    }

    /**
     * {@inheritDoc}
     */
    public function getContentType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getContentType', array());

        return parent::getContentType();
    }

    /**
     * {@inheritDoc}
     */
    public function getExtension()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExtension', array());

        return parent::getExtension();
    }

    /**
     * {@inheritDoc}
     */
    public function setSize($size)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSize', array($size));

        return parent::setSize($size);
    }

    /**
     * {@inheritDoc}
     */
    public function getSize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSize', array());

        return parent::getSize();
    }

    /**
     * {@inheritDoc}
     */
    public function setCdnStatus($cdnStatus)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCdnStatus', array($cdnStatus));

        return parent::setCdnStatus($cdnStatus);
    }

    /**
     * {@inheritDoc}
     */
    public function getCdnStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCdnStatus', array());

        return parent::getCdnStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function getBox()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getBox', array());

        return parent::getBox();
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__toString', array());

        return parent::__toString();
    }

    /**
     * {@inheritDoc}
     */
    public function setGalleryHasMedias($galleryHasMedias)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGalleryHasMedias', array($galleryHasMedias));

        return parent::setGalleryHasMedias($galleryHasMedias);
    }

    /**
     * {@inheritDoc}
     */
    public function getGalleryHasMedias()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGalleryHasMedias', array());

        return parent::getGalleryHasMedias();
    }

    /**
     * {@inheritDoc}
     */
    public function getPreviousProviderReference()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPreviousProviderReference', array());

        return parent::getPreviousProviderReference();
    }

    /**
     * {@inheritDoc}
     */
    public function isStatusErroneous(\Symfony\Component\Validator\ExecutionContextInterface $context)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isStatusErroneous', array($context));

        return parent::isStatusErroneous($context);
    }

}
