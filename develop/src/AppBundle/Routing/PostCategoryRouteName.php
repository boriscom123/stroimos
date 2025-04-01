<?php
namespace AppBundle\Routing;

class PostCategoryRouteName
{
    const TYPE_LIST = 'list';
    const TYPE_LIST_POPULAR = 'list_popular';
    const TYPE_SHOW = 'show';

    const COMMON_POST_LIST = 'app_post_list';
    const COMMON_POST_SHOW = 'app_post_show';

    public static function generate($alias, $type)
    {
        return sprintf('app_%s_%s', $alias, $type);
    }
}