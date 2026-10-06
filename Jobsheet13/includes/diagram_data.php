<?php
function diagram_file(): string
{
    return __DIR__ . '/../data/diagram.json';
}

function baca_data(string $nama): array
{
    if ($nama !== 'diagram') {
        return [];
    }

    $file = diagram_file();
    if (!file_exists($file)) {
        return [];
    }

    $data = json_decode(file_get_contents($file), true);
    return is_array($data) ? $data : [];
}

function simpan_data(string $nama, array $data): bool
{
    if ($nama !== 'diagram') {
        return false;
    }

    return file_put_contents(
        diagram_file(),
        json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        LOCK_EX
    ) !== false;
}

function id_baru(array $data): int
{
    $ids = array_map(static fn($row) => (int)($row['id'] ?? 0), $data);
    return empty($ids) ? 1 : max($ids) + 1;
}
