<?php


//**************************************************************

function marcdown($text_md)
{
    $pattern = [
        '/\*\*(.*?)\*\*/',
        '/\*(.*?)\*/',
        '/ht.*/'
    ];

    $text = [
        "<i>$1<i>",
        "<b>$1<b>",
        "<a href='$1'>$1</a>"
    ];

    return preg_replace(
        $pattern,
        $text,
        $text_md
    );
}

//**************************************************************

function url($link)
{
    $pattern = [
        '/https\:\/\/.{1,}\.png/',
    ];

    $text = [
        "<img src='$0'>",
    ];

    return preg_replace(
        $pattern,
        $text,
        $link
    );
}


//**************************************************************


function smile($smile) {
    $pattern = [
        "/(\:\-\))|(\:\))/",
        "/(\:\-\()|(\:\()/",
    ];

    $smile_img = [
        "<img src='good_smile.png'>",
        "<img src='bad_smile.png'>",
    ];

    return preg_replace($pattern,$smile_img,$smile);
}

//**************************************************************


function bb_code($text) {

    $pattern = [
        "/\[b\](.*)\[\/b\]/",
        "/\[i\](.*)\[\/i\]/",
        "/\[u\](.*)\[\/u\]/"
    ];

    $text_tags = [
        "<b>$1</b>",
        "<i>$1</i>",
        "<u>$1</u>",
    ];

    return preg_replace(
        $pattern,
        $text_tags,
        $text);
}


function censor($text)
{
    return preg_match('/(дурак|редиска)/i', $text) ? false: true;
}





