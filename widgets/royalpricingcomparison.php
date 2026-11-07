<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RoyalPricingComparison extends Widget_Base {

    public function get_name() {
        return 'royalpricingcomparison';
    }

    public function get_title() {
        return __('Pricing Comparison', 'royal-addons-for-elementor');
    }

    public function get_icon() { 
        return 'eicon-price-table rtbranding'; 
    }

    public function get_keywords() {
        return ['pric', 'pricing', 'compair', 'comparison', 'table', 'matrix', 'package', 'royal'];
    }

    public function get_categories() {
        return ['royaltech'];
    }

    protected function register_controls() {
        
        // =======================
        // Packages Configuration
        // =======================
        $this->start_controls_section(
            'section_packages',
            [
                'label' => __('Packages', 'royal-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'num_packages',
            [
                'label' => __('Number of Packages', 'royal-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => '2',
                'options' => [
                    '1' => '1 Package',
                    '2' => '2 Packages',
                    '3' => '3 Packages',
                ]
            ]
        );

        // --- Package 1 ---
        $this->add_control('heading_pkg_1', [
            'label' => __('Package 1', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $this->add_control('pkg_1_title', [
            'label' => __('Title', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Regal Doctor', 'royal-addons-for-elementor'),
        ]);
        $this->add_control('pkg_1_subtitle', [
            'label' => __('Subtitle', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Web / Local', 'royal-addons-for-elementor'),
        ]);
        $this->add_control('pkg_1_price', [
            'label' => __('Price', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('$500', 'royal-addons-for-elementor'),
        ]);
        $this->add_control('pkg_1_period', [
            'label' => __('Period', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('One-time', 'royal-addons-for-elementor'),
        ]);
        $this->add_control('pkg_1_btn_text', [
            'label' => __('Button Text', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Learn More', 'royal-addons-for-elementor'),
        ]);
        $this->add_control('pkg_1_btn_link', [
            'label' => __('Button Link', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::URL,
            'default' => ['url' => '#'],
        ]);

        // --- Package 2 ---
        $this->add_control('heading_pkg_2', [
            'label' => __('Package 2', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => ['num_packages' => ['2', '3']],
        ]);
        $this->add_control('pkg_2_title', [
            'label' => __('Title', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Royal Doctors', 'royal-addons-for-elementor'),
            'condition' => ['num_packages' => ['2', '3']],
        ]);
        $this->add_control('pkg_2_subtitle', [
            'label' => __('Subtitle', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Online / Cloud', 'royal-addons-for-elementor'),
            'condition' => ['num_packages' => ['2', '3']],
        ]);
        $this->add_control('pkg_2_price', [
            'label' => __('Price', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('$10', 'royal-addons-for-elementor'),
            'condition' => ['num_packages' => ['2', '3']],
        ]);
        $this->add_control('pkg_2_period', [
            'label' => __('Period', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('month', 'royal-addons-for-elementor'),
            'condition' => ['num_packages' => ['2', '3']],
        ]);
        $this->add_control('pkg_2_btn_text', [
            'label' => __('Button Text', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Subscribe', 'royal-addons-for-elementor'),
            'condition' => ['num_packages' => ['2', '3']],
        ]);
        $this->add_control('pkg_2_btn_link', [
            'label' => __('Button Link', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::URL,
            'default' => ['url' => '#'],
            'condition' => ['num_packages' => ['2', '3']],
        ]);

        // --- Package 3 ---
        $this->add_control('heading_pkg_3', [
            'label' => __('Package 3', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => ['num_packages' => '3'],
        ]);
        $this->add_control('pkg_3_title', [
            'label' => __('Title', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Premium Doctors', 'royal-addons-for-elementor'),
            'condition' => ['num_packages' => '3'],
        ]);
        $this->add_control('pkg_3_subtitle', [
            'label' => __('Subtitle', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Premium', 'royal-addons-for-elementor'),
            'condition' => ['num_packages' => '3'],
        ]);
        $this->add_control('pkg_3_price', [
            'label' => __('Price', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('$30', 'royal-addons-for-elementor'),
            'condition' => ['num_packages' => '3'],
        ]);
        $this->add_control('pkg_3_period', [
            'label' => __('Period', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('month', 'royal-addons-for-elementor'),
            'condition' => ['num_packages' => '3'],
        ]);
        $this->add_control('pkg_3_btn_text', [
            'label' => __('Button Text', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Subscribe', 'royal-addons-for-elementor'),
            'condition' => ['num_packages' => '3'],
        ]);
        $this->add_control('pkg_3_btn_link', [
            'label' => __('Button Link', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::URL,
            'default' => ['url' => '#'],
            'condition' => ['num_packages' => '3'],
        ]);

        $this->end_controls_section();

        // =======================
        // Features (Rows)
        // =======================
        $this->start_controls_section(
            'section_features',
            [
                'label' => __('Features (Rows)', 'royal-addons-for-elementor'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control('feature_title', [
            'label' => __('Feature Name', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Feature Title', 'royal-addons-for-elementor'),
            'label_block' => true,
        ]);
        $repeater->add_control('feature_subtitle', [
            'label' => __('Feature Subtitle', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
        ]);

        // Pkg 1 Value
        $repeater->add_control('heading_p1_val', [
            'label' => __('Package 1 Value', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $repeater->add_control('p1_type', [
            'label' => __('Type', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'text',
            'options' => [
                'text' => __('Text', 'royal-addons-for-elementor'),
                'icon' => __('Icon', 'royal-addons-for-elementor'),
            ],
        ]);
        $repeater->add_control('p1_text', [
            'label' => __('Text Value', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Text goes here', 'royal-addons-for-elementor'),
            'condition' => ['p1_type' => 'text'],
        ]);
        $repeater->add_control('p1_icon', [
            'label' => __('Icon Value', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-check',
                'library' => 'fa-solid',
            ],
            'condition' => ['p1_type' => 'icon'],
        ]);
        $repeater->add_control('p1_subtext', [
            'label' => __('Subtext (optional)', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
        ]);

        // Pkg 2 Value
        $repeater->add_control('heading_p2_val', [
            'label' => __('Package 2 Value', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $repeater->add_control('p2_type', [
            'label' => __('Type', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'text',
            'options' => [
                'text' => __('Text', 'royal-addons-for-elementor'),
                'icon' => __('Icon', 'royal-addons-for-elementor'),
            ],
        ]);
        $repeater->add_control('p2_text', [
            'label' => __('Text Value', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Text goes here', 'royal-addons-for-elementor'),
            'condition' => ['p2_type' => 'text'],
        ]);
        $repeater->add_control('p2_icon', [
            'label' => __('Icon Value', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-check',
                'library' => 'fa-solid',
            ],
            'condition' => ['p2_type' => 'icon'],
        ]);
        $repeater->add_control('p2_subtext', [
            'label' => __('Subtext (optional)', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
        ]);

        // Pkg 3 Value
        $repeater->add_control('heading_p3_val', [
            'label' => __('Package 3 Value', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);
        $repeater->add_control('p3_type', [
            'label' => __('Type', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::SELECT,
            'default' => 'text',
            'options' => [
                'text' => __('Text', 'royal-addons-for-elementor'),
                'icon' => __('Icon', 'royal-addons-for-elementor'),
            ],
        ]);
        $repeater->add_control('p3_text', [
            'label' => __('Text Value', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Text goes here', 'royal-addons-for-elementor'),
            'condition' => ['p3_type' => 'text'],
        ]);
        $repeater->add_control('p3_icon', [
            'label' => __('Icon Value', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-check',
                'library' => 'fa-solid',
            ],
            'condition' => ['p3_type' => 'icon'],
        ]);
        $repeater->add_control('p3_subtext', [
            'label' => __('Subtext (optional)', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::TEXT,
        ]);

        $this->add_control('features_list', [
            'label' => __('Features Items', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'feature_title' => 'Platform',
                    'feature_subtitle' => '(Environment)',
                    'p1_type' => 'text',
                    'p1_text' => 'Local PC or Server',
                    'p2_type' => 'text',
                    'p2_text' => 'Any Device (Cloud)',
                ],
                [
                    'feature_title' => 'Internet Required',
                    'feature_subtitle' => '(Connectivity)',
                    'p1_type' => 'text',
                    'p1_text' => 'Works without internet',
                    'p1_subtext' => '(If Local)',
                    'p2_type' => 'text',
                    'p2_text' => 'Always Required',
                ],
                [
                    'feature_title' => 'Multiple Locations',
                    'feature_subtitle' => '',
                    'p1_type' => 'icon',
                    'p1_icon' => ['value' => 'fas fa-check', 'library' => 'fa-solid'],
                    'p1_subtext' => '(Need to carry laptop)',
                    'p2_type' => 'icon',
                    'p2_icon' => ['value' => 'fas fa-check', 'library' => 'fa-solid'],
                    'p2_subtext' => '(Manage from anywhere)',
                ],
                [
                    'feature_title' => 'Client Portal',
                    'feature_subtitle' => '(Access)',
                    'p1_type' => 'icon',
                    'p1_icon' => ['value' => 'fas fa-times', 'library' => 'fa-solid'],
                    'p2_type' => 'icon',
                    'p2_icon' => ['value' => 'fas fa-check', 'library' => 'fa-solid'],
                    'p2_subtext' => '(Included in package)',
                ],
            ],
            'title_field' => '{{{ feature_title }}}',
        ]);

        $this->end_controls_section();

        // =======================
        // Styling Section
        // =======================
        $this->start_controls_section('section_style_table', [
            'label' => __('Table Styling', 'royal-addons-for-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('header_bg_color', [
            'label' => __('Header Background', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f9fbff',
            'selectors' => ['{{WRAPPER}} .royal-comparison-table th' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('row_odd_bg', [
            'label' => __('Odd Row Background', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .royal-comparison-table tbody tr:nth-child(odd) td' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}} .royal-comparison-table tbody tr:nth-child(odd) th' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('row_even_bg', [
            'label' => __('Even Row Background', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f5f7fc',
            'selectors' => ['{{WRAPPER}} .royal-comparison-table tbody tr:nth-child(even) td' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}} .royal-comparison-table tbody tr:nth-child(even) th' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('border_color', [
            'label' => __('Border Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#eaeff7',
            'selectors' => ['{{WRAPPER}} .royal-comparison-table th, {{WRAPPER}} .royal-comparison-table td' => 'border-color: {{VALUE}};'],
        ]);
        
        $this->add_control('pkg_title_color', [
            'label' => __('Package Title Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#141b38',
            'selectors' => ['{{WRAPPER}} .royal-pkg-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('feature_title_color', [
            'label' => __('Feature Title Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#333333',
            'selectors' => ['{{WRAPPER}} .royal-feat-title' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('val_text_color', [
            'label' => __('Value Text Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#555555',
            'selectors' => ['{{WRAPPER}} .royal-val-text' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('check_icon_color', [
            'label' => __('Check Icon Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#059669',
            'selectors' => ['{{WRAPPER}} .royal-val-icon.fa-check' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('times_icon_color', [
            'label' => __('Times Icon Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ef4444',
            'selectors' => ['{{WRAPPER}} .royal-val-icon.fa-times' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('footer_bg_color', [
            'label' => __('Footer Background Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .royal-comparison-table tfoot td' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}} .royal-comparison-table tfoot tr td:first-child' => 'background-color: transparent;'],
        ]);

        $this->add_control('heading_btn_outline', [
            'label' => __('Outline Button', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_control('btn_outline_color', [
            'label' => __('Text Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#111111',
            'selectors' => ['{{WRAPPER}} .royal-btn-outline' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('btn_outline_bg', [
            'label' => __('Background Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .royal-btn-outline' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('btn_outline_border', [
            'label' => __('Border Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#d1d5db',
            'selectors' => ['{{WRAPPER}} .royal-btn-outline' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('btn_outline_hover_color', [
            'label' => __('Hover Text Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-btn-outline:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('btn_outline_hover_bg', [
            'label' => __('Hover Background Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#f3f4f6',
            'selectors' => ['{{WRAPPER}} .royal-btn-outline:hover' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_control('heading_btn_solid', [
            'label' => __('Solid Button', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_control('btn_solid_color', [
            'label' => __('Text Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => ['{{WRAPPER}} .royal-btn-solid' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('btn_solid_bg', [
            'label' => __('Background Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#5a5ce0',
            'selectors' => ['{{WRAPPER}} .royal-btn-solid' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}} .royal-btn-solid' => 'border-color: {{VALUE}};'],
        ]);

        $this->add_control('btn_solid_hover_color', [
            'label' => __('Hover Text Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => ['{{WRAPPER}} .royal-btn-solid:hover' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('btn_solid_hover_bg', [
            'label' => __('Hover Background Color', 'royal-addons-for-elementor'),
            'type' => Controls_Manager::COLOR,
            'default' => '#4749cc',
            'selectors' => ['{{WRAPPER}} .royal-btn-solid:hover' => 'background-color: {{VALUE}};',
                            '{{WRAPPER}} .royal-btn-solid:hover' => 'border-color: {{VALUE}};'],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $num = intval($settings['num_packages']);
        
        $col_width = (100 / ($num + 1)) . '%';
        
        // Inline CSS for the table specifically so we don't strictly need a new stylesheet immediately
        ?>
        <style>
            .royal-pricing-comparison-wrapper { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .royal-comparison-table { width: 100%; border-collapse: separate; border-spacing: 0; text-align: center; font-family: inherit; min-width: 600px; }
            .royal-comparison-table th, .royal-comparison-table td { border-bottom: 1px solid #eaeff7; border-right: 1px solid #eaeff7; padding: 20px 15px; vertical-align: middle; }
            .royal-comparison-table tr th:first-child, .royal-comparison-table tr td:first-child { border-left: 1px solid #eaeff7; }
            .royal-comparison-table thead tr th { border-top: 1px solid #eaeff7; }
            
            /* Sticky First Column for Mobile Responsiveness */
            .royal-comparison-table th.royal-feat-col { text-align: left; width: <?php echo esc_attr($col_width); ?>; position: sticky; left: 0; z-index: 2; }
            
            .royal-comparison-table th.royal-pkg-col { width: <?php echo esc_attr($col_width); ?>; }
            
            .royal-pkg-title { font-size: 22px; font-weight: 700; margin-bottom: 5px; color: #141b38; }
            .royal-pkg-subtitle { font-size: 14px; color: #666; margin-bottom: 5px; }
            .royal-pkg-price { font-size: 18px; font-weight: 700; color: #141b38; }
            .royal-pkg-period { font-size: 13px; color: #666; font-weight: normal; }
            
            .royal-feat-title { font-size: 16px; font-weight: 600; color: #333; display: inline-block; }
            .royal-feat-subtitle { font-size: 13px; color: #666; font-weight: normal; margin-left: 5px; }
            
            .royal-val-text { font-size: 15px; color: #555; }
            .royal-val-icon { font-size: 18px; margin-bottom: 5px; }
            .royal-val-icon.fa-check { color: #059669; }
            .royal-val-icon.fa-times { color: #ef4444; }
            .royal-val-subtext { font-size: 13px; color: #777; display: block; margin-top: 5px; }
            
            .royal-btn { display: inline-block; padding: 12px 25px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 15px; transition: 0.3s; }
            .royal-btn-outline { border: 1px solid #d1d5db; color: #111; background-color: #fff; }
            .royal-btn-outline:hover { background-color: #f3f4f6; }
            .royal-btn-solid { background-color: #5a5ce0; color: #fff; border: 1px solid #5a5ce0; }
            .royal-btn-solid:hover { background-color: #4749cc; color: #fff; border-color: #4749cc; }

            .royal-comparison-table tfoot td { background-color: #fff; border-bottom-color: transparent; }
            .royal-comparison-table tfoot tr td:first-child { background-color: transparent; border-left-color: transparent; }

            /* Add shadow to sticky column on scroll/small screens */
            @media (max-width: 767px) {
                .royal-comparison-table th.royal-feat-col {
                    box-shadow: 3px 0 6px -2px rgba(0,0,0,0.1);
                }
            }
        </style>

        <div class="royal-pricing-comparison-wrapper">
            <table class="royal-comparison-table">
                <thead>
                    <tr>
                        <th class="royal-feat-col" style="background: #fff; border-top-color: transparent; border-left-color: transparent;"></th>
                        
                        <!-- Package 1 -->
                        <th class="royal-pkg-col">
                            <div class="royal-pkg-title"><?php echo esc_html($settings['pkg_1_title']); ?></div>
                            <div class="royal-pkg-subtitle"><?php echo esc_html($settings['pkg_1_subtitle']); ?></div>
                            <div class="royal-pkg-price"><?php echo esc_html($settings['pkg_1_price']); ?> <span class="royal-pkg-period">/ <?php echo esc_html($settings['pkg_1_period']); ?></span></div>
                        </th>
                        
                        <!-- Package 2 -->
                        <?php if ($num >= 2): ?>
                        <th class="royal-pkg-col">
                            <div class="royal-pkg-title"><?php echo esc_html($settings['pkg_2_title']); ?></div>
                            <div class="royal-pkg-subtitle"><?php echo esc_html($settings['pkg_2_subtitle']); ?></div>
                            <div class="royal-pkg-price"><?php echo esc_html($settings['pkg_2_price']); ?> <span class="royal-pkg-period">/ <?php echo esc_html($settings['pkg_2_period']); ?></span></div>
                        </th>
                        <?php endif; ?>
                        
                        <!-- Package 3 -->
                        <?php if ($num == 3): ?>
                        <th class="royal-pkg-col">
                            <div class="royal-pkg-title"><?php echo esc_html($settings['pkg_3_title']); ?></div>
                            <div class="royal-pkg-subtitle"><?php echo esc_html($settings['pkg_3_subtitle']); ?></div>
                            <div class="royal-pkg-price"><?php echo esc_html($settings['pkg_3_price']); ?> <span class="royal-pkg-period">/ <?php echo esc_html($settings['pkg_3_period']); ?></span></div>
                        </th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($settings['features_list'] as $item): ?>
                    <tr>
                        <th class="royal-feat-col">
                            <span class="royal-feat-title"><?php echo esc_html($item['feature_title']); ?></span>
                            <?php if (!empty($item['feature_subtitle'])): ?>
                                <span class="royal-feat-subtitle"><?php echo esc_html($item['feature_subtitle']); ?></span>
                            <?php endif; ?>
                        </th>
                        
                        <!-- P1 Value -->
                        <td>
                            <?php if ($item['p1_type'] == 'text'): ?>
                                <div class="royal-val-text"><?php echo wp_kses_post($item['p1_text']); ?></div>
                            <?php else: ?>
                                <div class="royal-val-icon"><i class="<?php echo esc_attr($item['p1_icon']['value']); ?>"></i></div>
                            <?php endif; ?>
                            
                            <?php if (!empty($item['p1_subtext'])): ?>
                                <div class="royal-val-subtext"><?php echo esc_html($item['p1_subtext']); ?></div>
                            <?php endif; ?>
                        </td>

                        <!-- P2 Value -->
                        <?php if ($num >= 2): ?>
                        <td>
                            <?php if ($item['p2_type'] == 'text'): ?>
                                <div class="royal-val-text"><?php echo wp_kses_post($item['p2_text']); ?></div>
                            <?php else: ?>
                                <div class="royal-val-icon"><i class="<?php echo esc_attr($item['p2_icon']['value']); ?>"></i></div>
                            <?php endif; ?>
                            
                            <?php if (!empty($item['p2_subtext'])): ?>
                                <div class="royal-val-subtext"><?php echo esc_html($item['p2_subtext']); ?></div>
                            <?php endif; ?>
                        </td>
                        <?php endif; ?>

                        <!-- P3 Value -->
                        <?php if ($num == 3): ?>
                        <td>
                            <?php if ($item['p3_type'] == 'text'): ?>
                                <div class="royal-val-text"><?php echo wp_kses_post($item['p3_text']); ?></div>
                            <?php else: ?>
                                <div class="royal-val-icon"><i class="<?php echo esc_attr($item['p3_icon']['value']); ?>"></i></div>
                            <?php endif; ?>
                            
                            <?php if (!empty($item['p3_subtext'])): ?>
                                <div class="royal-val-subtext"><?php echo esc_html($item['p3_subtext']); ?></div>
                            <?php endif; ?>
                        </td>
                        <?php endif; ?>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td>
                            <a href="<?php echo esc_url($settings['pkg_1_btn_link']['url']); ?>" class="royal-btn royal-btn-outline"><?php echo esc_html($settings['pkg_1_btn_text']); ?></a>
                        </td>
                        <?php if ($num >= 2): ?>
                        <td>
                            <a href="<?php echo esc_url($settings['pkg_2_btn_link']['url']); ?>" class="royal-btn royal-btn-solid"><?php echo esc_html($settings['pkg_2_btn_text']); ?></a>
                        </td>
                        <?php endif; ?>
                        <?php if ($num == 3): ?>
                        <td>
                            <a href="<?php echo esc_url($settings['pkg_3_btn_link']['url']); ?>" class="royal-btn royal-btn-solid"><?php echo esc_html($settings['pkg_3_btn_text']); ?></a>
                        </td>
                        <?php endif; ?>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php
    }
}
