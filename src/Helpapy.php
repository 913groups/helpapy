<?php

namespace Groups913\Helpapy;

use Groups913\Helpapy\helper\DateTrait;
use Groups913\Helpapy\helper\GeneratorTrait;
use Groups913\Helpapy\helper\MoneyTrait;
use Groups913\Helpapy\helper\SecurityTrait;

/**
 * Cette classe rassemble tous les traits en un seul point d'entrée
 */
class Helpapy
{
    use DateTrait;
    use MoneyTrait;
    use SecurityTrait;
    use GeneratorTrait;
}