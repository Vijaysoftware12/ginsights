<?php

namespace Analytics\Gaddon\Widgets\Gtagta;

use Statamic\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class Gtagta extends Widget
{
    /**
     * The HTML that should be shown in the widget.
     *
     * @return string|\Illuminate\View\View
     */
    public function html()
    {
        $feedUrl = $this->config('url');
        $limit = $this->config('limit') ?? 5;

        if (! $feedUrl) {
            return "Error: Missing feed URL.";
        }

        $key = 'sortarad-rss-'.md5($feedUrl.$limit);

        $data = Cache::rememberWithExpiration($key, function() use ($feedUrl, $limit) {
            $feed = $this->getFeed($feedUrl );

            $data = [
                'title'     => $feed->get_title(),
                'permalink' => $feed->get_permalink(),
                'items'     => $feed->get_items(0, $limit),
            ];

            return [60 => $data];
        });

        return view('sortarad::widgets.extraextra', $data);
    }

    /**
     * Return the feed object.
     *
     * @param string $url
     * @return \SimplePie
     */
    public function getFeed($url)
    {
        $simplePie = new \SimplePie();
        $simplePie->enable_cache(false);
        $simplePie->set_feed_url($url);
        $simplePie->init();

        return $simplePie;
    }
}
