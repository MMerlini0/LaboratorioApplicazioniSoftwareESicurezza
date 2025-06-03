<?php
// Test di integrazione che verifica il funzionamento del filtro per genere musicale
// Inserisce dati di test nel database, simula la richiesta del filtro 'Pop', include la pagina index.php
// e controlla che l'output HTML contenga solo post con genere 'Pop'.

use PHPUnit\Framework\TestCase;

class FilterLogicTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        // Connessione al database di test (modifica le credenziali!)
        $this->pdo = new PDO('pgsql:host=localhost;dbname=untuned_test', 'postgres', 'biar');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Pulisce i post precedenti
        $this->pdo->exec("DELETE FROM post");

        // Inserisce 1 post Pop e 1 Rock
        $stmt = $this->pdo->prepare("INSERT INTO post (titolo, contenuto, genere, email) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Test Pop', 'Contenuto Pop', 'Pop', 'pop@example.com']);
        $stmt->execute(params: ['Test Rock', 'Contenuto Rock', 'Rock', 'rock@example.com']);
    }

    public function testFilterReturnsOnlyPopPosts(): void
    {
        // Simula l'invio del filtro Pop
        $_POST['inputgenerefiltro'] = 'Pop';

        // Cattura l'output di index.php
        ob_start();
        include __DIR__ . '/../../index.php';
        $output = ob_get_clean();

        // Estrae tutti i generi presenti nei post HTML
        preg_match_all('/<span class="genre">(.*?)<\/span>/', $output, $matches);
        $generiNeiPost = $matches[1];

        // Verifica che ci siano post
        $this->assertNotEmpty($generiNeiPost, 'Nessun post trovato nel contenuto HTML');

        // Verifica che tutti i post siano di genere Pop
        foreach ($generiNeiPost as $genere) {
            $this->assertEquals('Pop', trim($genere));
        }
    }
}
