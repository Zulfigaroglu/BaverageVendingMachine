<?php


namespace App\Enumerations;


class Actions
{
    const OpenDoor = 1;
    const CloseDoor = 2;
    const PushShelf = 3;
    const PopShelf = 4;
    const PushCan = 5;
    const PopCan = 6;

    static $list = [
        "Kapak Aç",
        "Kapak Kapat",
        "Raf Ekle",
        "Raf Çıkar",
        "İçecek Ekle",
        "İçecek Al"
    ];
}