<?php

/**
 * Verilen bir isme göre baş harfleri ve rastgele bir renk sınıfı döndürür.
 * @param string $name Ad Soyad
 * @return array ['initials' => 'AS', 'color_class' => 'bg-primary']
 */
function get_avatar_data($name) {
    $words = explode(' ', trim($name));
    $initials = '';

    if (isset($words[0])) {
        $initials .= mb_substr($words[0], 0, 1, 'UTF-8');
    }
    if (count($words) > 1) {
        $initials .= mb_substr(end($words), 0, 1, 'UTF-8');
    }
    elseif (isset($words[0])) {
        $initials .= mb_substr($words[0], 1, 1, 'UTF-8');
    }

    $initials = mb_strtoupper($initials, 'UTF-8');

    $colors = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger', 'bg-dark'];
    $color_index = crc32($name) % count($colors);
    $avatar_color = $colors[$color_index];

    return [
        'initials' => $initials,
        'color_class' => $avatar_color
    ];
}

?>