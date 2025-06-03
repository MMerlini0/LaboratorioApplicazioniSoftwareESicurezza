<?php

declare(strict_types=1);


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

final class LoginCest
{

        public function testLoginAdmin(AcceptanceTester $I)
        {
            $I->amOnPage('/loginadmin.php');
            $I->fillField('InputEmail', 'admin@admin.it');
            $I->fillField('InputPassword', 'admin');
            $I->click('#cerca');
            $I->seeInCurrentUrl('/Admin.php');
        }

        public function viewSpotifyUserData(AcceptanceTester $I)
        {
            $I->amOnPage('/test-session.php'); 
            $I->seeInCurrentUrl('profilo.php');

            $I->see('Weresky');
            $I->see('weresky1@gmail.com');
            $I->see('Top 3 Canzoni');

            $c1 = $I->grabFromDatabase('utente', 'canzone1', ['email' => 'weresky1@gmail.com']);
            $c2 = $I->grabFromDatabase('utente', 'canzone2', ['email' => 'weresky1@gmail.com']);
            $c3 = $I->grabFromDatabase('utente', 'canzone3', ['email' => 'weresky1@gmail.com']);

            $c4 = $I->grabFromDatabase('utente', 'artista1', ['email' => 'weresky1@gmail.com']);
            $c5 = $I->grabFromDatabase('utente', 'artista2', ['email' => 'weresky1@gmail.com']);
            $c6 = $I->grabFromDatabase('utente', 'artista3', ['email' => 'weresky1@gmail.com']);

            codecept_debug("Canzoni salvate nel database:");
            codecept_debug([$c1, $c2, $c3]);
            codecept_debug("Artisti salvati nel database:");
            codecept_debug([$c4, $c5, $c6]);

        }

}