<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function royal_elementor_presets() {
    return [
        'royalheadingscrolltrigger' => [  // Presets for Widget 1
            'preset_random' => [
                'title' => 'Random Characters',
                'settings' => [
                    'staggerfrom' => 'random',
                ],
            ],
            'preset_slanted_rotate' => [
                'title' => 'Slanted Rotate',
                'settings' => [
                    'staggerfrom' => 'start',
                    'from_rotatex' => [
                        'size' => 360,
                    ],
                    'from_opacity' => [
                        'size' => 0,
                    ],
                    'from_xposition' => [
                        'size' => 100,
                    ],
                    'duration' => [
                        'size' => .1,
                    ],
                ],
            ],
            'preset_blurry' => [
                'title' => 'Blurry Text',
                'settings' => [
                    'staggeramount' => [
                        'size' => 0.07,
                    ],
                    'from_filter_blur' => [
                        'size' => 15,
                    ],
                    'from_opacity' => [
                        'size' => .1,
                    ],
                    'from_scaley' => [
                        'size' => .1,
                    ],
                    'duration' => [
                        'size' => .1,
                    ],
                    'staggerfrom'       => 'start',
                    'scrolltriggerease' => 'power4.out',
                ],
            ],
        ],

        'my_widget_2' => [  // Presets for Widget 2
            'preset_1' => [
                'title' => 'Minimal Style',
                'settings' => [
                    'text_size' => '16px',
                    'font_weight' => '400',
                    'text_color' => '#111',
                ],
            ],
            'preset_2' => [
                'title' => 'Bold Typography',
                'settings' => [
                    'text_size' => '20px',
                    'font_weight' => '700',
                    'text_color' => '#ff5733',
                ],
            ],
        ],







    ];
}
