<?php
function filterPostsByGenre(array $posts, string $genre): array {
    return array_filter($posts, fn($post) => $post['genere'] === $genre);
}

