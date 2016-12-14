<?php

/**
 * This code is deleberately left without error handlings for the simple purpose of demonstrating
 * how to crawl color title and hex from HTML and CSS file.
 */

require __DIR__ . '/vendor/autoload.php';

const HTML_URL = 'http://nipponcolors.com/';
const CSS_URL  = 'http://nipponcolors.com/min/g=nipponcolors_css';

$opts = array(
    'http' => array(
        'method' => 'GET',
        'header' => 'Accept-language: zh-CN,zh;q=0.8,en-US;q=0.6,en;q=0.4,zh-TW;q=0.2',
    )
);
$context           = stream_context_create($opts);
$html_content      = file_get_contents(HTML_URL, false, $context);
$crawler           = new Symfony\Component\DomCrawler\Crawler($html_content);
$color_list        = $crawler->filter('ul#colors')->children()->extract(array('id', '_text'));
$color_id_name_map = array_column($color_list, 1, 0);

$css_content   = file_get_contents(CSS_URL);
$pattern       = '/#(col[0-9]{3}) a:hover{background-color:(#([0-9a-f]{3}){1,2})}/i';
$matches_count = preg_match_all($pattern, $css_content, $matches, PREG_SET_ORDER);

$result = array_map(
    function ($match) use ($color_id_name_map) {
        list($title, $code) = explode(',', $color_id_name_map[$match[1]]);

        return array(
            'id'    => $match[1],
            'title' => trim($title),
            'code'  => trim($code),
            'hex'   => $match[2],
        );
    },
    array_values($matches)
);

$file_path = __DIR__ . '/output/nippon_colors.json';
file_put_contents($file_path, json_encode($result, JSON_UNESCAPED_UNICODE));

echo 'JSON file: ' . $file_path . PHP_EOL;