<?php

namespace Dpeuscher\Util\Date;

use DateInterval;

/**
 * @category  util
 * @copyright Copyright (c) 2018 Dominik Peuscher
 */
class DateHelper
{
    /**
     * @param $fromMonth
     * @param $toMonth
     * @param string $defaultInterval
     * @return \DateTime[]
     * @throws \Exception
     */
    public function buildDateTimeRangeFromTwoInputs($fromMonth, $toMonth = null, $defaultInterval = 'P1M'): array
    {
        if (preg_match('/^([0-9]{1,2})\.([0-9]{1,2})\.?$/', $fromMonth, $matches)) {
            $fromDateTime = new \DateTime(date('Y-') . $matches[2] . '-' . $matches[1]);
            if (!isset($toMonth)) {
                $toDateTime = clone $fromDateTime;
                $toDateTime->add(new DateInterval($defaultInterval));
            }
            if (isset($toDateTime)) {
                return [$fromDateTime, $toDateTime];
            }
            if (preg_match('/^([0-9]{1,2})\.([0-9]{1,2})\.?$/', $toMonth, $matches2)) {
                return [
                    $fromDateTime,
                    new \DateTime(($matches2[2] < $matches[2] ? 1 + date('Y') : date('Y')) . '-' . $matches2[2] . '-' . $matches2[1]),
                ];
            }
            return [$fromDateTime, new \DateTime($toMonth)];
        }
        if (preg_match('/^([0-9]{1,2})-[0-9]{1,2}$/', $fromMonth, $matches)) {
            $fromDateTime = new \DateTime(date('Y-') . $fromMonth);
            if (!isset($toMonth)) {
                $toDateTime = clone $fromDateTime;
                $toDateTime->add(new DateInterval($defaultInterval));
            }
            if (isset($toDateTime)) {
                return [$fromDateTime, $toDateTime];
            }
            if (preg_match('/^([0-9]{1,2})-[0-9]{1,2}$/', $toMonth, $matches2)) {
                return [
                    $fromDateTime,
                    new \DateTime(($matches2[1] < $matches[1] ? 1 + date('Y') : date('Y')) . '-' . $toMonth),
                ];
            }
            if (preg_match('/^([0-9]{1,2})\.([0-9]{1,2})\.?$/', $toMonth, $matches2)) {
                return [
                    $fromDateTime,
                    new \DateTime(($matches2[2] < $matches[1] ? 1 + date('Y') : date('Y')) . '-' . $matches2[2] . '-' . $matches2[1]),
                ];
            }
            return [$fromDateTime, new \DateTime($toMonth)];
        }
        if (preg_match('/^([0-9]{1,2})$/', $fromMonth, $matches)) {
            if (!isset($toMonth)) {
                $toMonth = (string)($fromMonth >= 12 ? 1 : $fromMonth + 1);
            }
            $fromYear = date('Y');
            $fromDateTime = new \DateTime($fromYear . '-' . str_pad($fromMonth, 2, 0, STR_PAD_LEFT) . '-01');
            if (preg_match('/^[0-9]{1,2}$/', $toMonth)) {
                $toYear = $fromYear;
                if ((int)$toMonth < (int)$fromMonth) {
                    $toYear += 1;
                }
                $toDateTime = new \DateTime($toYear . '-' . str_pad($toMonth, 2, 0, STR_PAD_LEFT) . '-01');
                return [$fromDateTime, $toDateTime];
            }
            if (preg_match('/^([0-9]{1,2})-[0-9]{1,2}$/', $toMonth, $matches2)) {
                return [
                    $fromDateTime,
                    new \DateTime(($matches2[1] < $matches[1] ? 1 + date('Y') : date('Y')) . '-' . $toMonth),
                ];
            }
            if (preg_match('/^([0-9]{1,2})\.([0-9]{1,2})\.?$/', $toMonth, $matches2)) {
                return [
                    $fromDateTime,
                    new \DateTime(($matches2[2] < $matches[1] ? 1 + date('Y') : date('Y')) . '-' . $matches2[2] . '-' . $matches2[1]),
                ];
            }
            return [$fromDateTime, new \DateTime($toMonth)];
        }
        $fromDateTime = new \DateTime($fromMonth);
        if (!isset($toMonth)) {
            $toDateTime = clone $fromDateTime;
            $toDateTime->add(new DateInterval($defaultInterval));
        }
        if (isset($toDateTime)) {
            return [$fromDateTime, $toDateTime];
        }
        return [$fromDateTime, new \DateTime($toMonth)];
    }

    public function buildDateTimeSince(string $sinceString = 'P7D'): \DateTime
    {
        try {
            $dateInterval = new DateInterval($sinceString);
        } catch (\Exception $e) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $dateInterval = new DateInterval('P1D');
        }
        $dateTime = new \DateTime();
        $dateTime->sub($dateInterval);
        return $dateTime;
    }

    public function diffToText(DateInterval $diff): string
    {
        $text = [];
        if ($diff->days) {
            $text[] = $diff->days . 'd';
        } elseif ($diff->days === false) {
            $now = new \DateTime();
            $then = clone $now;
            $now->add($diff);
            $interval = $now->diff($then);
            if ($interval->days) {
                $text[] = $interval->days . 'd';
            }
        }
        if ($diff->h) {
            $text[] = $diff->h . 'h';
        }
        if ($diff->i) {
            $text[] = $diff->i . 'm';
        }
        if ($diff->s) {
            $text[] = $diff->s . 's';
        }
        return implode(' ', $text);
    }
}
