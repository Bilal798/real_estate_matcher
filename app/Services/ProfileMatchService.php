<?php

namespace App\Services;

class ProfileMatchService
{
    /**
     * @param $propertyFields
     * @param $potentialProfiles
     * @return mixed
     */
    public function matchProfiles($propertyFields, $potentialProfiles): mixed
    {
        $response = [];

        $response = $potentialProfiles->map(function ($profile) use ($propertyFields) {

            $strictMatchCount = 0;
            $looseMatchCount = 0;

            foreach ($profile->searchFields->toArray() as $searchProfileKey => $searchProfileValue) {
                if (isset($propertyFields[$searchProfileKey])) {
                    if ($this->strictMatch($propertyFields[$searchProfileKey], $searchProfileValue)) {
                        $strictMatchCount++;
                        continue;
                    }

                    if ($this->looseMatch($propertyFields[$searchProfileKey], $searchProfileValue)) {
                        $looseMatchCount++;
                        continue;
                    }

                    return false;
                }
            }

            return [
                'searchProfileId' => $profile->id,
                'score' => $strictMatchCount + $looseMatchCount,
                'strictMatchesCount' => $strictMatchCount,
                'looseMatchesCount' => $looseMatchCount
            ];
        });

        return $response->filter()->sortBy([
            ['score', 'desc'],
            ['strictMatchesCount', 'desc'],
        ])->toArray();
    }

    /**
     * @param $propertyValue
     * @param $searchProfileValue
     * @return bool
     */
    public function strictMatch($propertyValue, $searchProfileValue): bool
    {
        $response = false;
        if (!is_array($searchProfileValue)) {
            if ($searchProfileValue === null) {
                $response = true;
            } else {
                $response = $propertyValue === $searchProfileValue;
            }
        } else {
            list($min, $max) = $searchProfileValue;
            $response = (is_null($min) || $propertyValue >= (int) $min) && (is_null($max) || $propertyValue <= (int) $max);
        }
        return $response;
    }

    /**
     * @param $propertyValue
     * @param $searchProfileValue
     * @return bool
     */
    public function looseMatch($propertyValue, $searchProfileValue): bool
    {
        if (!is_array($searchProfileValue)) {
            return false;
        }

        list($min, $max) = $searchProfileValue;

        return (is_null($min) || $propertyValue >= $this->getDeviatedNumber((int)$min)) && (is_null($max) || $propertyValue <= $this->getDeviatedNumber((int)$max, true));
    }

    /**
     * @param $num
     * @param false $upperLimit
     * @return int
     */
    public function getDeviatedNumber($num, bool $upperLimit = false): int
    {
        $percent = 0.25 * (int) $num;

        return $upperLimit ? (int)($percent + $num) : (int)($num - $percent);
    }
}
