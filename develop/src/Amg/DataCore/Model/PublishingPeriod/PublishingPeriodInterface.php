<?php

namespace Amg\DataCore\Model\PublishingPeriod;


interface PublishingPeriodInterface
{
    /**
     * Return the date from which the content should be published.
     *
     * A NULL value is interpreted as a date in the past, meaning the content
     * is publishable unless publish end date is set and in the past.
     *
     * @return \DateTime|null
     */
    public function getPublishStartDate();

    /**
     * Return the date at which the content should stop being published.
     *
     * A NULL value is interpreted as saying that the document will
     * never end being publishable.
     *
     * @return \DateTime|null
     */
    public function getPublishEndDate();

    /**
     * Set the date from which the content should
     * be considered publishable.
     *
     * Setting a NULL value asserts that the content
     * has always been publishable.
     *
     * @param \DateTime|null $publishDate
     */
    public function setPublishStartDate(\DateTime $publishDate = null);

    /**
     * Set the date at which the content should
     * stop being published.
     *
     * Setting a NULL value asserts that the
     * content will always be publishable.
     *
     * @param \DateTime|null $publishDate
     */
    public function setPublishEndDate(\DateTime $publishDate = null);
}
