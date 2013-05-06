<?php

class TimeUtil {

    public static function calRelativeTime($ts) {

        if (!ctype_digit($ts))
            $ts = strtotime($ts);

        $diff = time() - $ts;
        if ($diff == 0)
            return 'now';
        elseif ($diff > 0) {
            $day_diff = floor($diff / 86400);
            if ($day_diff == 0) {
                if ($diff < 60)
                    return 'vừa mới đăng';
                if ($diff < 120)
                    return 'cách đây 1 phút';
                if ($diff < 3600)
                    return "cách đây ".floor($diff / 60)." phút";
                if ($diff < 7200)
                    return 'một giờ trước';
                if ($diff < 86400)
                    return "cách đây ".floor($diff / 3600) . ' giờ';
            }
            if ($day_diff == 1)
                return 'hôm qua';
            if ($day_diff < 7)
                return "cách đây ".$day_diff . ' ngày';
            
            //else return date
            return $ts;
//            
//            if ($day_diff < 31)
//                return "cách đây ". ceil($day_diff / 7) . ' tuần';
//            if ($day_diff < 60)
//                return 'tháng trước';
//            return date('F Y', $ts);
        }
        else {
            $diff = abs($diff);
            $day_diff = floor($diff / 86400);
            if ($day_diff == 0) {
                if ($diff < 120)
                    return 'trong một phút';
                if ($diff < 3600)
                    return 'khoảng ' . floor($diff / 60) . ' phút';
                if ($diff < 7200)
                    return 'trong khoảng 1 giờ';
                if ($diff < 86400)
                    return 'trong khoảng ' . floor($diff / 3600) . ' giờ';
            }
            if ($day_diff == 1)
                return 'Ngày mai';
            if ($day_diff < 4)
                return date('l', $ts);
            if ($day_diff < 7 + (7 - date('w')))
                return 'Tuần tới';
            if (ceil($day_diff / 7) < 4)
                return 'Trong khoảng ' . ceil($day_diff / 7) . ' tuần';
            if (date('n', $ts) == date('n') + 1)
                return 'tháng tới';
            return date('F Y', $ts);
        }
    }

}