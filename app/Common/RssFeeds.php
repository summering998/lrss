<?php
/**
 * User: yemeishu
 * Date: 2018/4/7
 * Time: 下午2:41
 */

namespace App\Common;

use App\Xpath;
use Carbon\Carbon;

class RssFeeds {
    public static function feeds(Xpath $xpath, $titles = [], $desces = [], $urls = []) {
        if (count($titles) === 0) {
            return false;
        }

        if (count($titles) !== count($urls)) {
            return false;
        }

        if (!empty($xpath->preurl)) {
            $preurl = $xpath->preurl;
            $urlss = collect($urls)->map(function ($url, $key) use ($preurl) {
                return $preurl.trim($url);
            });
            info($urlss);
        } else {
            $urlss = collect($urls);
        }
        return response()
            ->view('rss',
            [
                'xpath' => $xpath,
                'titles' => $titles,
                'desces' => $desces,
                'urls' => $urlss->toArray(),
                'pubDate' => Carbon::now()
            ])
            ->header('Content-Type', 'text/xml');
    }
}