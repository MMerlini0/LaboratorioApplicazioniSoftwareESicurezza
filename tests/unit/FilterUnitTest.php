<?php
// Test unitario che verifica la corretta funzionalità della funzione di filtro
// dato un array di post, filtra per genere 'Pop' e controlla che il risultato sia corretto.

use PHPUnit\Framework\TestCase;
require_once dirname(__DIR__, 2) . '/_inc/filter_functions.php';

class FilterUnitTest extends TestCase
{
    public function testFilterByGenre()
    {
        $posts = [
            ['titolo' => 'Song 1', 'genere' => 'Pop'],
            ['titolo' => 'Song 2', 'genere' => 'Rock'],
        ];

        $filtered = filterPostsByGenre($posts, 'Pop');
        $this->assertCount(1, $filtered);
        $this->assertEquals('Song 1', array_values($filtered)[0]['titolo']);
    }
}