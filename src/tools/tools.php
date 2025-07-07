<?php 

function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $difference = time() - $timestamp;

    if ($difference < 60) {
        return $difference . " secs ago";
    } elseif ($difference < 3600) {
        return floor($difference / 60) . " mins ago";
    } elseif ($difference < 86400) {
        return floor($difference / 3600) . " hours ago";
    } elseif ($difference < 2592000) {
        return floor($difference / 86400) . " days ago";
    } elseif ($difference < 31536000) {
        return floor($difference / 2592000) . " months ago";
    } else {
        return floor($difference / 31536000) . " years ago";
    }
}


?>