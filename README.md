# nippon-colors-crawler

This PHP script crawls color hex codes from [nipponcolors.com](http://nipponcolors.com/) and save the result as a JSON file.

## How to Run
1. Git clone this repo.
2. `composer install`
3. `php run.php`
4. Get the JSON file from `output/nippon_colors.json`

## JSON Sample
```json
[
  {
    "id": "col001",
    "title": "撫子",
    "code": "NADESHIKO",
    "hex": "#DC9FB4"
  },
  {
    "id": "col148",
    "title": "柳鼠",
    "code": "YANAGINEZUMI",
    "hex": "#808F7C"
  },
  {
    "id": "col149",
    "title": "常磐",
    "code": "TOKIWA",
    "hex": "#1B813E"
  }
]
```
