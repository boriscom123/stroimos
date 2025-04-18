<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Newsletter extends \AppBundle\Entity\Newsletter implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'id', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'date', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'status', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'subject', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'posts', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'infographicsNl', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'galleries', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'videos', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'documents', 'quote', 'highlight', 'galleryWallpaper', 'spotlightItemWallpaper', 'galleryWallpaperType', 'createdAt', 'updatedAt', 'createdBy', 'updatedBy', 'deletedBy');
        }

        return array('__isInitialized__', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'id', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'date', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'status', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'subject', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'posts', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'infographicsNl', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'galleries', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'videos', '' . "\0" . 'AppBundle\\Entity\\Newsletter' . "\0" . 'documents', 'quote', 'highlight', 'galleryWallpaper', 'spotlightItemWallpaper', 'galleryWallpaperType', 'createdAt', 'updatedAt', 'createdBy', 'updatedBy', 'deletedBy');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Newsletter $proxy) {
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
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', array($id));

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getDate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDate', array());

        return parent::getDate();
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', array());

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', array($status));

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function getPosts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPosts', array());

        return parent::getPosts();
    }

    /**
     * {@inheritDoc}
     */
    public function setPosts($posts)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPosts', array($posts));

        return parent::setPosts($posts);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatusLabel()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatusLabel', array());

        return parent::getStatusLabel();
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
    public function getInfographicsNl()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInfographicsNl', array());

        return parent::getInfographicsNl();
    }

    /**
     * {@inheritDoc}
     */
    public function setInfographicsNl($infographicsNl)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInfographicsNl', array($infographicsNl));

        return parent::setInfographicsNl($infographicsNl);
    }

    /**
     * {@inheritDoc}
     */
    public function getGalleries()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGalleries', array());

        return parent::getGalleries();
    }

    /**
     * {@inheritDoc}
     */
    public function setGalleries($galleries)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGalleries', array($galleries));

        return parent::setGalleries($galleries);
    }

    /**
     * {@inheritDoc}
     */
    public function getVideos()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVideos', array());

        return parent::getVideos();
    }

    /**
     * {@inheritDoc}
     */
    public function setVideos($videos)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVideos', array($videos));

        return parent::setVideos($videos);
    }

    /**
     * {@inheritDoc}
     */
    public function getDocuments()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDocuments', array());

        return parent::getDocuments();
    }

    /**
     * {@inheritDoc}
     */
    public function setDocuments($documents)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDocuments', array($documents));

        return parent::setDocuments($documents);
    }

    /**
     * {@inheritDoc}
     */
    public function addPost($pn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addPost', array($pn));

        return parent::addPost($pn);
    }

    /**
     * {@inheritDoc}
     */
    public function removePost($pn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removePost', array($pn));

        return parent::removePost($pn);
    }

    /**
     * {@inheritDoc}
     */
    public function addGallery($gn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addGallery', array($gn));

        return parent::addGallery($gn);
    }

    /**
     * {@inheritDoc}
     */
    public function removeGallery($gn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeGallery', array($gn));

        return parent::removeGallery($gn);
    }

    /**
     * {@inheritDoc}
     */
    public function addVideo($vn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addVideo', array($vn));

        return parent::addVideo($vn);
    }

    /**
     * {@inheritDoc}
     */
    public function removeVideo($vn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeVideo', array($vn));

        return parent::removeVideo($vn);
    }

    /**
     * {@inheritDoc}
     */
    public function getQuote()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getQuote', array());

        return parent::getQuote();
    }

    /**
     * {@inheritDoc}
     */
    public function setQuote($quote)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setQuote', array($quote));

        return parent::setQuote($quote);
    }

    /**
     * {@inheritDoc}
     */
    public function getHighlight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHighlight', array());

        return parent::getHighlight();
    }

    /**
     * {@inheritDoc}
     */
    public function setHighlight($highlight)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHighlight', array($highlight));

        return parent::setHighlight($highlight);
    }

    /**
     * {@inheritDoc}
     */
    public function addInfographicsNl($in)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addInfographicsNl', array($in));

        return parent::addInfographicsNl($in);
    }

    /**
     * {@inheritDoc}
     */
    public function removeInfographicsNl($in)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeInfographicsNl', array($in));

        return parent::removeInfographicsNl($in);
    }

    /**
     * {@inheritDoc}
     */
    public function getSubject()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSubject', array());

        return parent::getSubject();
    }

    /**
     * {@inheritDoc}
     */
    public function setSubject($subject)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSubject', array($subject));

        return parent::setSubject($subject);
    }

    /**
     * {@inheritDoc}
     */
    public function getGalleryWallpaper()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGalleryWallpaper', array());

        return parent::getGalleryWallpaper();
    }

    /**
     * {@inheritDoc}
     */
    public function setGalleryWallpaper($galleryWallpaper)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGalleryWallpaper', array($galleryWallpaper));

        return parent::setGalleryWallpaper($galleryWallpaper);
    }

    /**
     * {@inheritDoc}
     */
    public function getSpotlightItemWallpaper()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSpotlightItemWallpaper', array());

        return parent::getSpotlightItemWallpaper();
    }

    /**
     * {@inheritDoc}
     */
    public function setSpotlightItemWallpaper($spotlightItemWallpaper)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSpotlightItemWallpaper', array($spotlightItemWallpaper));

        return parent::setSpotlightItemWallpaper($spotlightItemWallpaper);
    }

    /**
     * {@inheritDoc}
     */
    public function getGalleryWallpaperType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGalleryWallpaperType', array());

        return parent::getGalleryWallpaperType();
    }

    /**
     * {@inheritDoc}
     */
    public function setGalleryWallpaperType($galleryWallpaperType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGalleryWallpaperType', array($galleryWallpaperType));

        return parent::setGalleryWallpaperType($galleryWallpaperType);
    }

    /**
     * {@inheritDoc}
     */
    public function personaliseFor(\AppBundle\Entity\EmailSubscription $subscription)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'personaliseFor', array($subscription));

        return parent::personaliseFor($subscription);
    }

    /**
     * {@inheritDoc}
     */
    public function personaliseByGeneralPosts()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'personaliseByGeneralPosts', array());

        return parent::personaliseByGeneralPosts();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
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
    public function setUpdatedAt(\DateTime $updatedAt)
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
    public function setCreatedBy($user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedBy', array($user));

        return parent::setCreatedBy($user);
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedBy($user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedBy', array($user));

        return parent::setUpdatedBy($user);
    }

    /**
     * {@inheritDoc}
     */
    public function setDeletedBy($user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDeletedBy', array($user));

        return parent::setDeletedBy($user);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedBy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedBy', array());

        return parent::getCreatedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedBy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedBy', array());

        return parent::getUpdatedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function getDeletedBy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDeletedBy', array());

        return parent::getDeletedBy();
    }

    /**
     * {@inheritDoc}
     */
    public function isBlameable()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isBlameable', array());

        return parent::isBlameable();
    }

}
