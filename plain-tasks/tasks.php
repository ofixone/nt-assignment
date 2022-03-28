<?php
/*
 * |---------------------------------------------------------------------------
 * | Task 1
 * |---------------------------------------------------------------------------
 */

namespace Task1
{
    function validateUsername(string $username): bool
    {
        return (bool)preg_match(
            '/^(?=.{4})[a-z][a-z0-9]*_?(?<!_)+$/i',
            $username
        );
    }
}

/*
 * |---------------------------------------------------------------------------
 * | Task 2
 * |---------------------------------------------------------------------------
 */

namespace Task2
{
    const SQL
    = <<<SQL
        UPDATE recipes INNER JOIN ingredients i
        ON recipes.id = i.recipeId AND i.name = 'tuna'
        SET recipes.cost = recipes.cost + 2;
    SQL;
}

/*
 * |---------------------------------------------------------------------------
 * | Task 3
 * |---------------------------------------------------------------------------
 */

namespace Task3
{
    const SQL
    = <<<SQL
        UPDATE menu
        SET price = price * 1.1
        WHERE category in ('Soups', 'Salads');
    SQL;
}

/*
 * |---------------------------------------------------------------------------
 * | Task 4
 * |---------------------------------------------------------------------------
 */

namespace Task4
{
    function transformDateFormat(array $dates): array
    {
        $convertedDates = [];
        foreach ($dates as $date) {
            foreach (['Y/m/d', 'd/m/Y', 'm-d-Y'] as $format) {
                $convertedDateObject = date_create_from_format($format, $date);
                if ($convertedDateObject) {
                    $convertedDates[] = date_format(
                        $convertedDateObject,
                        'Ymd'
                    );
                }
            }
        }

        return $convertedDates;
    }
}

/*
 * |---------------------------------------------------------------------------
 * | Task 5
 * |---------------------------------------------------------------------------
 */

namespace Task5
{
    function calculateMinCratesCountHoldItems(
        int $countItems, int $countLarge, int $countSmall
    ): int
    {
        if ($countItems <= 0 || ($countLarge < 0 && $countSmall < 0)) {
            return 0;
        }

        $leftItems = $countItems;

        $usedLargePackages = $countLarge > 0 ?
            min([floor($countItems / 5), $countLarge]) : 0;
        $leftItems -= $usedLargePackages * 5;

        $usedSmallPackages = $countSmall > 0 ? min($leftItems, $countSmall) : 0;
        $leftItems -= $usedSmallPackages;

        return $leftItems > 0 ? -1 : $usedLargePackages + $usedSmallPackages;
    }
}

/*
 * |---------------------------------------------------------------------------
 * | Task 6
 * |---------------------------------------------------------------------------
 */

namespace Task6
{
    function getViewCount(string $json): int
    {
        $json = json_decode($json, true);
        if (!isset($json['videos']) || !is_array($json['videos'])) {
            //TODO: Better throw an exception, but I dont wanna use any classes
            return 0;
        }
        $totalViews = 0;
        array_walk(
            $json['videos'],
            static function (array $content) use (&$totalViews) {
                if (!isset($content['viewCount'])) {
                    return;
                }
                $totalViews += $content['viewCount'];
            }
        );

        return $totalViews;
    }
}

