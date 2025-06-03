<?php

declare(strict_types=1);


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

final class LoginCest
{

        public function tryToLoginWithSpotify(AcceptanceTester $I)
        {
            $I->amOnPage('/loginadmin.php');
            $I->fillField('InputEmail', 'admin@admin.it');
            $I->fillField('InputPassword', 'admin');
            $I->click('#cerca');
            $I->seeInCurrentUrl('/Admin.php');
        }

}