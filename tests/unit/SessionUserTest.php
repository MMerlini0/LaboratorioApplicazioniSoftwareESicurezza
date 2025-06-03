<?php
// Test unitario semplice che verifica che i dati di sessione utente siano correttamente impostati
// e accessibili durante l'esecuzione del codice.
use PHPUnit\Framework\TestCase;

class SessionUserTest extends TestCase
{
    public function testUserSessionData()
    {
        $_SESSION = [
            'name' => 'Mario Rossi',
            'email' => 'mario@example.com'
        ];

        $this->assertEquals('Mario Rossi', $_SESSION['name']);
        $this->assertEquals('mario@example.com', $_SESSION['email']);
    }
}
