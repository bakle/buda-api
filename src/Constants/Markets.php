<?php

namespace Bakle\Buda\Constants;

class Markets
{
    public const  BTC_CLP = 'btc-clp';
    public const  BTC_COP = 'btc-cop';
    public const  ETH_CLP = 'eth-clp';
    public const  ETH_BTC = 'eth-btc';
    public const  BTC_PEN = 'btc-pen';
    public const  ETH_PEN = 'eth-pen';
    public const  ETH_COP = 'eth-cop';
    public const  BCH_BTC = 'bch-btc';
    public const  BCH_CLP = 'bch-cl';
    public const  BCH_COP = 'bch-cop';
    public const  BCH_PEN = 'bch-pen';
    public const  BTC_ARS = 'btc-ars';
    public const  ETH_ARS = 'eth-ars';
    public const  BCH_ARS = 'bch-ars';
    public const  LTC_BTC = 'ltc-btc';
    public const  LTC_CLP = 'ltc-clp';
    public const  LTC_COP = 'ltc-cop';
    public const  LTC_PEN = 'ltc-pen';
    public const  LTC_ARS = 'ltc-ars';

    public static function toArray(): array
    {
        return (new \ReflectionClass(self::class))->getConstants();
    }
}
