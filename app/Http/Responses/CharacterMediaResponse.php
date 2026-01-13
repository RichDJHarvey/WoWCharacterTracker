<?php

namespace App\Http\Responses;

class CharacterMediaResponse
{
    /**
     * @param array|object $data
     * @return array
     */
    public static function one($data): array
    {
        return [
            'character' => $data['character'] ?? null,
            'assets'    => self::extractAssets($data),
            'raw'       => $data,
        ];
    }

    /**
     * @param array $collection
     * @return array
     */
    public static function many(array $collection): array
    {
        return array_map(fn($item) => self::one($item), $collection);
    }

    /**
     * @param array $data
     * @return array
     */
    protected static function extractAssets(array $data): array
    {
        $assets = [];
        if (isset($data['assets']) && is_array($data['assets'])) {
            foreach ($data['assets'] as $asset) {
                $assets[$asset['key']] = $asset['value'];
            }
        }
        return $assets;
    }
}
