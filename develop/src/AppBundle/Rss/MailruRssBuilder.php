<?php
namespace AppBundle\Rss;

use AppBundle\Entity\Post;

class MailruRssBuilder extends RssBuilder
{
    protected function buildItem(Post $post)
    {
        $item = $this->createItem();

        $item
            ->appendTo($this->channel)
            ->title($post->getTitle())
            ->description($post->getContent())
            ->pubDate($post->getPublishStartDate()->getTimestamp())
            ->url($this->entityUrlGenerator->generate($post, [],  true));

        return $item;
    }
}
