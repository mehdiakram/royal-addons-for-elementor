<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

defined('ABSPATH') || die();

class RoyalOrganogram extends Widget_Base {

    public function get_name() {
        return 'royalorganogram';
    }

    public function get_title() {
        return esc_html__( 'Organogram', 'royal-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-sitemap rtbranding';
    }

    public function get_keywords() {
        return [ 'organogram', 'org chart', 'tree', 'hierarchy', 'structure', 'team', 'department', 'matrix', 'royal' ];
    }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_style_depends() {
        return [ 'royalorganogram' ];
    }

    public function get_script_depends() {
        return [ 'royalorganogram' ];
    }

    /* ==========================================================================
       CONTROLS REGISTRATION
       ========================================================================== */
    protected function register_controls() {
        $this->register_layout_controls();
        $this->register_toolbar_controls();
        $this->register_custom_data_controls();
        $this->register_manpower_controls();

        $this->register_style_nodes_controls();
        $this->register_style_tiers_controls();
        $this->register_style_manpower_controls();
    }

    /* ── Content Section: Layout & Style Preset ────────────────────────── */
    protected function register_layout_controls() {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__( 'Layout & Preset Style', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'organogram_style',
            [
                'label'       => esc_html__( 'Style / Layout', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'matrix',
                'options'     => [
                    'matrix'     => esc_html__( '1. Executive Matrix Flow (Unnayan)', 'royal-addons-for-elementor' ),
                    'bento'      => esc_html__( '2. Neo-Modern Bento Glassmorphism', 'royal-addons-for-elementor' ),
                    'tree'       => esc_html__( '3. Branching Hierarchy Tree', 'royal-addons-for-elementor' ),
                    'pipeline'   => esc_html__( '4. Stepper Department Pipeline', 'royal-addons-for-elementor' ),
                    'minimal'    => esc_html__( '5. Minimalist Corporate Directory', 'royal-addons-for-elementor' ),
                    'cardgrid'   => esc_html__( '6. Executive Team Cards Grid', 'royal-addons-for-elementor' ),
                    'horizontal' => esc_html__( '7. Horizontal Hierarchy Flow (Roadmap)', 'royal-addons-for-elementor' ),
                    'circular'   => esc_html__( '8. Hub & Spoke Radial Cluster (Command Center)', 'royal-addons-for-elementor' ),
                    'table'      => esc_html__( '9. Corporate Executive Data Matrix', 'royal-addons-for-elementor' ),
                    'neumorphic' => esc_html__( '10. Cyber Neumorphic 3D Floating', 'royal-addons-for-elementor' ),
                ],
                'description' => esc_html__( 'Choose from 10 modern, fully responsive organogram presentation styles.', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'full_width',
            [
                'label'        => esc_html__( 'Force 100% Full Width', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
                'description'  => esc_html__( 'Stretches the organogram to 100% full width with no side gaps.', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'data_source',
            [
                'label'   => esc_html__( 'Data Mode', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'preset',
                'options' => [
                    'preset' => esc_html__( 'Default Unnayan (14 Grades & 7 Depts)', 'royal-addons-for-elementor' ),
                    'custom' => esc_html__( 'Custom Data (Repeaters)', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'data_mode_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw'  => '<div style="background:#f0fdf4; border-left:4px solid #16a34a; padding:10px 14px; border-radius:6px; font-size:12px; line-height:1.6; color:#14532d; margin-top:8px;">' .
                          '<strong>' . esc_html__( 'Data Input Guide:', 'royal-addons-for-elementor' ) . '</strong><br>' .
                          '• <strong>' . esc_html__( 'Default Preset:', 'royal-addons-for-elementor' ) . '</strong> ' . esc_html__( 'Loads complete 14 grades and 7 departments structure of Unnayan automatically.', 'royal-addons-for-elementor' ) . '<br>' .
                          '• <strong>' . esc_html__( 'Custom Data (Repeaters):', 'royal-addons-for-elementor' ) . '</strong> ' . esc_html__( 'Displays Custom Top Leadership, Custom Departments, and Custom Roles & Positions repeater sections below to customize your organization hierarchy.', 'royal-addons-for-elementor' ) .
                          '</div>',
            ]
        );

        $this->end_controls_section();
    }

    /* ── Content Section: Toolbar & Actions ────────────────────────────── */
    protected function register_toolbar_controls() {
        $this->start_controls_section(
            'section_toolbar',
            [
                'label' => esc_html__( 'Toolbar, Legend & Actions', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_toolbar',
            [
                'label'        => esc_html__( 'Show Toolbar', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'show_legend',
            [
                'label'        => esc_html__( 'Show Legend Badges', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [ 'show_toolbar' => 'yes' ],
            ]
        );

        $this->add_control(
            'legend_lead_label',
            [
                'label'     => esc_html__( 'Tier 1 Label', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Directorate',
                'condition' => [ 'show_legend' => 'yes', 'show_toolbar' => 'yes' ],
            ]
        );
        $this->add_control(
            'legend_lead_sub',
            [
                'label'     => esc_html__( 'Tier 1 Subtitle', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Grades 3–5',
                'condition' => [ 'show_legend' => 'yes', 'show_toolbar' => 'yes' ],
            ]
        );

        $this->add_control(
            'legend_mgmt_label',
            [
                'label'     => esc_html__( 'Tier 2 Label', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Management',
                'condition' => [ 'show_legend' => 'yes', 'show_toolbar' => 'yes' ],
            ]
        );
        $this->add_control(
            'legend_mgmt_sub',
            [
                'label'     => esc_html__( 'Tier 2 Subtitle', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Grades 6–10',
                'condition' => [ 'show_legend' => 'yes', 'show_toolbar' => 'yes' ],
            ]
        );

        $this->add_control(
            'legend_field_label',
            [
                'label'     => esc_html__( 'Tier 3 Label', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Field & Support',
                'condition' => [ 'show_legend' => 'yes', 'show_toolbar' => 'yes' ],
            ]
        );
        $this->add_control(
            'legend_field_sub',
            [
                'label'     => esc_html__( 'Tier 3 Subtitle', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Grades 11–14',
                'condition' => [ 'show_legend' => 'yes', 'show_toolbar' => 'yes' ],
            ]
        );

        $this->add_control(
            'show_download',
            [
                'label'        => esc_html__( 'Show Download / Export Button', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [ 'show_toolbar' => 'yes' ],
            ]
        );

        $this->add_control(
            'download_text',
            [
                'label'     => esc_html__( 'Download Button Text', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Download Original Chart',
                'condition' => [ 'show_download' => 'yes', 'show_toolbar' => 'yes' ],
            ]
        );

        $this->add_control(
            'download_action',
            [
                'label'     => esc_html__( 'Action Type', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'print',
                'options'   => [
                    'print' => esc_html__( 'Print / Save as PDF', 'royal-addons-for-elementor' ),
                    'link'  => esc_html__( 'Custom Download URL', 'royal-addons-for-elementor' ),
                ],
                'condition' => [ 'show_download' => 'yes', 'show_toolbar' => 'yes' ],
            ]
        );

        $this->add_control(
            'download_url',
            [
                'label'     => esc_html__( 'Download URL', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::URL,
                'default'   => [ 'url' => '#' ],
                'condition' => [ 'download_action' => 'link', 'show_download' => 'yes', 'show_toolbar' => 'yes' ],
            ]
        );

        $this->add_control(
            'show_search',
            [
                'label'        => esc_html__( 'Show Search Filter', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [ 'show_toolbar' => 'yes' ],
            ]
        );

        $this->add_control(
            'show_tip',
            [
                'label'        => esc_html__( 'Show Interaction Tip', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'tip_text',
            [
                'label'     => esc_html__( 'Tip Text', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Tip: click a department name to highlight its column',
                'condition' => [ 'show_tip' => 'yes' ],
            ]
        );

        $this->end_controls_section();
    }

    /* ── Content Section: Custom Repeaters ─────────────────────────────── */
    protected function register_custom_data_controls() {
        $this->start_controls_section(
            'section_custom_leadership',
            [
                'label'     => esc_html__( 'Custom Top Leadership', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'data_source' => 'custom' ],
            ]
        );

        $lead_repeater = new Repeater();

        $lead_repeater->add_control(
            'role_title',
            [
                'label'   => esc_html__( 'Role Title', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Leadership Role',
            ]
        );

        $lead_repeater->add_control(
            'role_subtitle',
            [
                'label'   => esc_html__( 'Subtitle / Members', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Members',
            ]
        );

        $lead_repeater->add_control(
            'grade_label',
            [
                'label'   => esc_html__( 'Grade / Tag (optional)', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $lead_repeater->add_control(
            'icon_name',
            [
                'label'   => esc_html__( 'Icon Name', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'users',
                'options' => [
                    'users'       => 'Users / Members',
                    'shield'      => 'Shield / Committee',
                    'user-tie'    => 'Executive Director',
                    'user-check'  => 'Deputy Director',
                    'user-circle' => 'Person / Admin',
                ],
            ]
        );

        $lead_repeater->add_control(
            'accent_color',
            [
                'label'   => esc_html__( 'Accent Color', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::COLOR,
                'default' => '#157a3e',
            ]
        );

        $this->add_control(
            'custom_leadership_items',
            [
                'label'       => esc_html__( 'Top Leadership Nodes', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $lead_repeater->get_controls(),
                'title_field' => '{{{ role_title }}}',
                'default'     => [
                    [ 'role_title' => 'General Body', 'role_subtitle' => '25 Members', 'grade_label' => '', 'icon_name' => 'users', 'accent_color' => '#157a3e' ],
                    [ 'role_title' => 'Executive Committee', 'role_subtitle' => '07 Members', 'grade_label' => '', 'icon_name' => 'shield', 'accent_color' => '#157a3e' ],
                    [ 'role_title' => 'Executive Director', 'role_subtitle' => '', 'grade_label' => 'Grade 01', 'icon_name' => 'user-tie', 'accent_color' => '#157a3e' ],
                    [ 'role_title' => 'Deputy Executive Director', 'role_subtitle' => '', 'grade_label' => 'Grade 02', 'icon_name' => 'user-check', 'accent_color' => '#157a3e' ],
                ],
            ]
        );

        $this->end_controls_section();

        // Custom Departments
        $this->start_controls_section(
            'section_custom_departments',
            [
                'label'     => esc_html__( 'Custom Departments', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'data_source' => 'custom' ],
            ]
        );

        $dept_repeater = new Repeater();

        $dept_repeater->add_control(
            'dept_name',
            [
                'label'   => esc_html__( 'Department Name', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Department Name',
            ]
        );

        $dept_repeater->add_control(
            'dept_key',
            [
                'label'   => esc_html__( 'Identifier Key (unique, lowercase)', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'dept1',
            ]
        );

        $dept_repeater->add_control(
            'dept_color',
            [
                'label'   => esc_html__( 'Department Color', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::COLOR,
                'default' => '#0891b2',
            ]
        );

        $dept_repeater->add_control(
            'dept_icon',
            [
                'label'   => esc_html__( 'Icon', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'sitemap',
                'options' => [
                    'user-circle' => 'Person / Admin',
                    'money-bill'  => 'Microfinance / Cash',
                    'sitemap'     => 'Program / Diagram',
                    'university'  => 'Finance / Bank',
                    'store'       => 'Enterprise / Shop',
                    'bullhorn'    => 'Advocacy / Megaphone',
                    'chart-bar'   => 'Audit / Statistics',
                ],
            ]
        );

        $dept_repeater->add_control(
            'dept_levels_info',
            [
                'label'   => esc_html__( 'Levels Subtitle', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '8 levels',
            ]
        );

        $this->add_control(
            'custom_dept_items',
            [
                'label'       => esc_html__( 'Departments', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $dept_repeater->get_controls(),
                'title_field' => '{{{ dept_name }}} ({{{ dept_key }}})',
                'default'     => [
                    [ 'dept_name' => 'HR & Admin', 'dept_key' => 'hr', 'dept_color' => '#e11d48', 'dept_icon' => 'user-circle', 'dept_levels_info' => '10 levels' ],
                    [ 'dept_name' => 'Microfinance', 'dept_key' => 'mf', 'dept_color' => '#0891b2', 'dept_icon' => 'money-bill', 'dept_levels_info' => '12 levels' ],
                    [ 'dept_name' => 'Program', 'dept_key' => 'pg', 'dept_color' => '#7c3aed', 'dept_icon' => 'sitemap', 'dept_levels_info' => '11 levels' ],
                    [ 'dept_name' => 'Finance', 'dept_key' => 'fn', 'dept_color' => '#d97706', 'dept_icon' => 'university', 'dept_levels_info' => '9 levels' ],
                ],
            ]
        );

        $this->end_controls_section();

        // Custom Positions / Roles
        $this->start_controls_section(
            'section_custom_positions',
            [
                'label'     => esc_html__( 'Custom Roles & Positions', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_CONTENT,
                'condition' => [ 'data_source' => 'custom' ],
            ]
        );

        $pos_repeater = new Repeater();

        $pos_repeater->add_control(
            'position_grade',
            [
                'label'       => esc_html__( 'Grade / Level', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Grade 03',
                'description' => esc_html__( 'e.g. Grade 01, Level 1, Executive', 'royal-addons-for-elementor' ),
            ]
        );

        $pos_repeater->add_control(
            'position_dept',
            [
                'label'       => esc_html__( 'Department Key', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'hr',
                'description' => esc_html__( 'Enter the matching Department Key from above (e.g. hr, mf, pg, fn)', 'royal-addons-for-elementor' ),
            ]
        );

        $pos_repeater->add_control(
            'cell_type',
            [
                'label'   => esc_html__( 'Cell Type', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'node',
                'options' => [
                    'node'  => esc_html__( 'Position Card (Node)', 'royal-addons-for-elementor' ),
                    'line'  => esc_html__( 'Connector Line (Pass-through)', 'royal-addons-for-elementor' ),
                    'empty' => esc_html__( 'Empty Space', 'royal-addons-for-elementor' ),
                ],
            ]
        );

        $pos_repeater->add_control(
            'position_title',
            [
                'label'     => esc_html__( 'Position Title', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Director',
                'condition' => [ 'cell_type' => 'node' ],
            ]
        );

        $pos_repeater->add_control(
            'position_subtitle',
            [
                'label'     => esc_html__( 'Subtitle / Specialization (optional)', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => '',
                'condition' => [ 'cell_type' => 'node' ],
            ]
        );

        $pos_repeater->add_control(
            'position_tier',
            [
                'label'     => esc_html__( 'Tier Category', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 't-lead',
                'options'   => [
                    't-lead'  => esc_html__( 'Directorate / Top Tier (Green)', 'royal-addons-for-elementor' ),
                    't-mgmt'  => esc_html__( 'Management (Blue)', 'royal-addons-for-elementor' ),
                    't-field' => esc_html__( 'Field & Support (Orange)', 'royal-addons-for-elementor' ),
                ],
                'condition' => [ 'cell_type' => 'node' ],
            ]
        );

        $this->add_control(
            'custom_position_items',
            [
                'label'       => esc_html__( 'Roles & Positions', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $pos_repeater->get_controls(),
                'title_field' => '{{{ position_grade }}} - {{{ position_title }}} ({{{ position_dept }}})',
                'default'     => [
                    [ 'position_grade' => 'Grade 03', 'position_dept' => 'hr', 'cell_type' => 'node', 'position_title' => 'Director', 'position_subtitle' => '', 'position_tier' => 't-lead' ],
                    [ 'position_grade' => 'Grade 03', 'position_dept' => 'mf', 'cell_type' => 'node', 'position_title' => 'Director', 'position_subtitle' => '', 'position_tier' => 't-lead' ],
                    [ 'position_grade' => 'Grade 03', 'position_dept' => 'pg', 'cell_type' => 'node', 'position_title' => 'Director', 'position_subtitle' => '', 'position_tier' => 't-lead' ],
                    [ 'position_grade' => 'Grade 03', 'position_dept' => 'fn', 'cell_type' => 'node', 'position_title' => 'Director', 'position_subtitle' => '', 'position_tier' => 't-lead' ],
                    [ 'position_grade' => 'Grade 04', 'position_dept' => 'hr', 'cell_type' => 'node', 'position_title' => 'Deputy Director', 'position_subtitle' => '', 'position_tier' => 't-lead' ],
                    [ 'position_grade' => 'Grade 04', 'position_dept' => 'mf', 'cell_type' => 'node', 'position_title' => 'Deputy Director', 'position_subtitle' => '', 'position_tier' => 't-lead' ],
                    [ 'position_grade' => 'Grade 04', 'position_dept' => 'pg', 'cell_type' => 'node', 'position_title' => 'Deputy Director', 'position_subtitle' => '', 'position_tier' => 't-lead' ],
                    [ 'position_grade' => 'Grade 04', 'position_dept' => 'fn', 'cell_type' => 'node', 'position_title' => 'Deputy Director', 'position_subtitle' => '', 'position_tier' => 't-lead' ],
                    [ 'position_grade' => 'Grade 05', 'position_dept' => 'hr', 'cell_type' => 'node', 'position_title' => 'Coordinator', 'position_subtitle' => 'HR / Admin / IT', 'position_tier' => 't-mgmt' ],
                    [ 'position_grade' => 'Grade 05', 'position_dept' => 'mf', 'cell_type' => 'node', 'position_title' => 'Zonal Manager', 'position_subtitle' => '', 'position_tier' => 't-mgmt' ],
                    [ 'position_grade' => 'Grade 05', 'position_dept' => 'pg', 'cell_type' => 'node', 'position_title' => 'Coordinator', 'position_subtitle' => '', 'position_tier' => 't-mgmt' ],
                    [ 'position_grade' => 'Grade 05', 'position_dept' => 'fn', 'cell_type' => 'node', 'position_title' => 'Senior Accountant', 'position_subtitle' => '', 'position_tier' => 't-mgmt' ],
                ],
            ]
        );

        $this->end_controls_section();
    }

    /* ── Content Section: Manpower & Statistics ────────────────────────── */
    protected function register_manpower_controls() {
        $this->start_controls_section(
            'section_manpower',
            [
                'label' => esc_html__( 'Approved Manpower & Stats', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_manpower',
            [
                'label'        => esc_html__( 'Show Approved Manpower Section', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'manpower_title',
            [
                'label'     => esc_html__( 'Section Title', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Approved Manpower',
                'condition' => [ 'show_manpower' => 'yes' ],
            ]
        );

        $this->add_control(
            'manpower_subtitle',
            [
                'label'     => esc_html__( 'Section Subtitle', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Approved number of positions at each level',
                'condition' => [ 'show_manpower' => 'yes' ],
            ]
        );

        $this->add_control(
            'stat1_num',
            [
                'label'     => esc_html__( 'Stat 1 Value', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => '25',
                'condition' => [ 'show_manpower' => 'yes' ],
            ]
        );
        $this->add_control(
            'stat1_label',
            [
                'label'     => esc_html__( 'Stat 1 Label', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'General Body',
                'condition' => [ 'show_manpower' => 'yes' ],
            ]
        );

        $this->add_control(
            'stat2_num',
            [
                'label'     => esc_html__( 'Stat 2 Value', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => '07',
                'condition' => [ 'show_manpower' => 'yes' ],
            ]
        );
        $this->add_control(
            'stat2_label',
            [
                'label'     => esc_html__( 'Stat 2 Label', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'Executive Committee',
                'condition' => [ 'show_manpower' => 'yes' ],
            ]
        );

        $this->add_control(
            'show_manpower_bars',
            [
                'label'        => esc_html__( 'Show Grade Distribution Bars', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [ 'show_manpower' => 'yes' ],
            ]
        );

        $this->end_controls_section();
    }

    /* ── Style Section: Nodes & Cards ──────────────────────────────────── */
    protected function register_style_nodes_controls() {
        $this->start_controls_section(
            'section_style_nodes',
            [
                'label' => esc_html__( 'Nodes & Hierarchy Cards', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'node_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .og-node, {{WRAPPER}} .oc-card, {{WRAPPER}} .og-bento-card, {{WRAPPER}} .og-tree-root-node, {{WRAPPER}} .og-tree-dept-node, {{WRAPPER}} .og-tree-role-node' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'node_box_shadow',
                'selector' => '{{WRAPPER}} .og-node, {{WRAPPER}} .oc-card, {{WRAPPER}} .og-bento-card, {{WRAPPER}} .og-tree-root-node, {{WRAPPER}} .og-tree-dept-node, {{WRAPPER}} .og-tree-role-node',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'node_title_typography',
                'label'    => esc_html__( 'Role Title Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .og-node b, {{WRAPPER}} .oc-card b, {{WRAPPER}} .og-tree-root-node b, {{WRAPPER}} .og-tree-dept-node b, {{WRAPPER}} .og-tree-role-node b',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'node_sub_typography',
                'label'    => esc_html__( 'Role Subtitle Typography', 'royal-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .og-node small, {{WRAPPER}} .oc-card small, {{WRAPPER}} .og-tree-root-node small, {{WRAPPER}} .og-tree-dept-node small, {{WRAPPER}} .og-tree-role-node small',
            ]
        );

        $this->end_controls_section();
    }

    /* ── Style Section: Tiers & Accent Colors ──────────────────────────── */
    protected function register_style_tiers_controls() {
        $this->start_controls_section(
            'section_style_tiers',
            [
                'label' => esc_html__( 'Tiers & Category Colors', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'color_lead_tier',
            [
                'label'     => esc_html__( 'Directorate Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#15803d',
                'selectors' => [
                    '{{WRAPPER}} .og-cell.t-lead .og-node' => 'background: linear-gradient(135deg, {{VALUE}}, color-mix(in srgb, {{VALUE}} 75%, #ffffff));',
                    '{{WRAPPER}} .og-leg.t-lead i, {{WRAPPER}} .oc-item.t-lead .oc-bub' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'color_mgmt_tier',
            [
                'label'     => esc_html__( 'Management Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1d4ed8',
                'selectors' => [
                    '{{WRAPPER}} .og-cell.t-mgmt .og-node' => 'background: linear-gradient(135deg, {{VALUE}}, color-mix(in srgb, {{VALUE}} 75%, #ffffff));',
                    '{{WRAPPER}} .og-leg.t-mgmt i, {{WRAPPER}} .oc-item.t-mgmt .oc-bub' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'color_field_tier',
            [
                'label'     => esc_html__( 'Field & Support Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ea580c',
                'selectors' => [
                    '{{WRAPPER}} .og-cell.t-field .og-node' => 'background: linear-gradient(135deg, {{VALUE}}, color-mix(in srgb, {{VALUE}} 75%, #ffffff));',
                    '{{WRAPPER}} .og-leg.t-field i, {{WRAPPER}} .oc-item.t-field .oc-bub' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /* ── Style Section: Manpower & Statistics ──────────────────────────── */
    protected function register_style_manpower_controls() {
        $this->start_controls_section(
            'section_style_manpower',
            [
                'label'     => esc_html__( 'Manpower & Statistics Card', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_manpower' => 'yes' ],
            ]
        );

        $this->add_control(
            'manpower_card_bg',
            [
                'label'     => esc_html__( 'Card Background', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .og-man' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'manpower_card_radius',
            [
                'label'      => esc_html__( 'Card Border Radius', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .og-man' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /* ==========================================================================
       DEFAULT DATA PROVIDERS (UNNAYAN PRESET)
       ========================================================================== */
    protected function get_default_leadership() {
        return [
            [
                'title'    => 'General Body',
                'subtitle' => '25 Members',
                'grade'    => '',
                'icon'     => 'users',
                'color'    => '#157a3e',
                'has_prev' => false,
                'has_next' => true,
                'is_top_b' => false,
            ],
            [
                'title'    => 'Executive Committee',
                'subtitle' => '07 Members',
                'grade'    => '',
                'icon'     => 'shield',
                'color'    => '#157a3e',
                'has_prev' => true,
                'has_next' => true,
                'is_top_b' => false,
            ],
            [
                'title'    => 'Executive Director',
                'subtitle' => '',
                'grade'    => 'Grade 01',
                'icon'     => 'user-tie',
                'color'    => '#157a3e',
                'has_prev' => true,
                'has_next' => true,
                'is_top_b' => true,
            ],
            [
                'title'    => 'Deputy Executive Director',
                'subtitle' => '',
                'grade'    => 'Grade 02',
                'icon'     => 'user-check',
                'color'    => '#157a3e',
                'has_prev' => true,
                'has_next' => true,
                'is_top_b' => true,
            ],
        ];
    }

    protected function get_default_departments() {
        return [
            'hr' => [
                'name'   => 'HR & Admin',
                'color'  => '#e11d48',
                'icon'   => 'user-circle',
                'levels' => '10 levels · Grade 3 to Grade 14',
            ],
            'mf' => [
                'name'   => 'Microfinance',
                'color'  => '#0891b2',
                'icon'   => 'money-bill',
                'levels' => '12 levels · Grade 3 to Grade 14',
            ],
            'pg' => [
                'name'   => 'Program',
                'color'  => '#7c3aed',
                'icon'   => 'sitemap',
                'levels' => '11 levels · Grade 3 to Grade 13',
            ],
            'fn' => [
                'name'   => 'Finance',
                'color'  => '#d97706',
                'icon'   => 'university',
                'levels' => '9 levels · Grade 3 to Grade 12',
            ],
            'se' => [
                'name'   => 'Social Enterprise',
                'color'  => '#db2777',
                'icon'   => 'store',
                'levels' => '9 levels · Grade 3 to Grade 14',
            ],
            'ad' => [
                'name'   => 'Advocacy',
                'color'  => '#2563eb',
                'icon'   => 'bullhorn',
                'levels' => '6 levels · Grade 3 to Grade 8',
            ],
            'ma' => [
                'name'   => 'Monitoring & Audit',
                'color'  => '#475569',
                'icon'   => 'chart-bar',
                'levels' => '7 levels · Grade 3 to Grade 10',
            ],
        ];
    }

    protected function get_default_matrix_data() {
        return [
            'Grade 03' => [
                'tier'  => 't-lead',
                'cells' => [
                    'hr' => [ 'type' => 'node', 'title' => 'Director', 'sub' => '', 'has_prev' => false, 'has_next' => true ],
                    'mf' => [ 'type' => 'node', 'title' => 'Director', 'sub' => '', 'has_prev' => false, 'has_next' => true ],
                    'pg' => [ 'type' => 'node', 'title' => 'Director', 'sub' => '', 'has_prev' => false, 'has_next' => true ],
                    'fn' => [ 'type' => 'node', 'title' => 'Director', 'sub' => '', 'has_prev' => false, 'has_next' => true ],
                    'se' => [ 'type' => 'node', 'title' => 'Director', 'sub' => '', 'has_prev' => false, 'has_next' => true ],
                    'ad' => [ 'type' => 'node', 'title' => 'Director', 'sub' => '', 'has_prev' => false, 'has_next' => true ],
                    'ma' => [ 'type' => 'node', 'title' => 'Director', 'sub' => '', 'has_prev' => false, 'has_next' => true ],
                ],
            ],
            'Grade 04' => [
                'tier'  => 't-lead',
                'cells' => [
                    'hr' => [ 'type' => 'node', 'title' => 'Deputy Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'mf' => [ 'type' => 'node', 'title' => 'Deputy Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'pg' => [ 'type' => 'node', 'title' => 'Deputy Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'fn' => [ 'type' => 'node', 'title' => 'Deputy Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'se' => [ 'type' => 'node', 'title' => 'Deputy Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'ad' => [ 'type' => 'node', 'title' => 'Deputy Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'ma' => [ 'type' => 'node', 'title' => 'Deputy Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                ],
            ],
            'Grade 05' => [
                'tier'  => 't-lead',
                'cells' => [
                    'hr' => [ 'type' => 'node', 'title' => 'Assistant Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'mf' => [ 'type' => 'node', 'title' => 'Assistant Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'pg' => [ 'type' => 'node', 'title' => 'Assistant Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'fn' => [ 'type' => 'node', 'title' => 'Assistant Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'se' => [ 'type' => 'node', 'title' => 'Assistant Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'ad' => [ 'type' => 'node', 'title' => 'Assistant Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'ma' => [ 'type' => 'node', 'title' => 'Assistant Director', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                ],
            ],
            'Grade 06' => [
                'tier'  => 't-mgmt',
                'cells' => [
                    'hr' => [ 'type' => 'node', 'title' => 'Coordinator', 'sub' => 'HR / Admin / Training / IT', 'has_prev' => true, 'has_next' => true ],
                    'mf' => [ 'type' => 'node', 'title' => 'Zonal Manager', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'pg' => [ 'type' => 'node', 'title' => 'Coordinator', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'fn' => [ 'type' => 'node', 'title' => 'Coordinator', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'se' => [ 'type' => 'node', 'title' => 'Coordinator', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'ad' => [ 'type' => 'node', 'title' => 'Coordinator', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'ma' => [ 'type' => 'node', 'title' => 'Coordinator', 'sub' => 'Monitoring / Audit', 'has_prev' => true, 'has_next' => true ],
                ],
            ],
            'Grade 07' => [
                'tier'  => 't-mgmt',
                'cells' => [
                    'hr' => [ 'type' => 'node', 'title' => 'Assistant Coordinator', 'sub' => 'HR / Admin / Training / IT', 'has_prev' => true, 'has_next' => true ],
                    'mf' => [ 'type' => 'node', 'title' => 'Senior Area Manager', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'pg' => [ 'type' => 'node', 'title' => 'Senior Project Manager', 'sub' => 'Program Manager', 'has_prev' => true, 'has_next' => true ],
                    'fn' => [ 'type' => 'node', 'title' => 'Assistant Coordinator', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'se' => [ 'type' => 'node', 'title' => 'Assistant Coordinator', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'ad' => [ 'type' => 'node', 'title' => 'Senior Advocacy Officer', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'ma' => [ 'type' => 'node', 'title' => 'Senior Officer', 'sub' => 'Monitoring / Audit', 'has_prev' => true, 'has_next' => true ],
                ],
            ],
            'Grade 08' => [
                'tier'  => 't-mgmt',
                'cells' => [
                    'hr' => [ 'type' => 'node', 'title' => 'Project Manager', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'mf' => [ 'type' => 'node', 'title' => 'Area Manager', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'pg' => [ 'type' => 'node', 'title' => 'Project Manager', 'sub' => 'Senior Technical / Project Officer', 'has_prev' => true, 'has_next' => true ],
                    'fn' => [ 'type' => 'node', 'title' => 'Officer', 'sub' => 'MIS / Liability', 'has_prev' => true, 'has_next' => true ],
                    'se' => [ 'type' => 'node', 'title' => 'Manager', 'sub' => 'Production / Sales / Marketing', 'has_prev' => true, 'has_next' => true ],
                    'ad' => [ 'type' => 'node', 'title' => 'Advocacy Officer', 'sub' => '', 'has_prev' => true, 'has_next' => false ],
                    'ma' => [ 'type' => 'node', 'title' => 'Officer', 'sub' => 'Monitoring / Audit', 'has_prev' => true, 'has_next' => true ],
                ],
            ],
            'Grade 09' => [
                'tier'  => 't-mgmt',
                'cells' => [
                    'hr' => [ 'type' => 'node', 'title' => 'Officer', 'sub' => 'HR / Admin / Training / IT', 'has_prev' => true, 'has_next' => true ],
                    'mf' => [ 'type' => 'node', 'title' => 'Senior Branch Manager', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'pg' => [ 'type' => 'node', 'title' => 'Technical Officer', 'sub' => 'Project Officer', 'has_prev' => true, 'has_next' => true ],
                    'fn' => [ 'type' => 'line' ],
                    'se' => [ 'type' => 'line' ],
                    'ad' => [ 'type' => 'empty' ],
                    'ma' => [ 'type' => 'line' ],
                ],
            ],
            'Grade 10' => [
                'tier'  => 't-mgmt',
                'cells' => [
                    'hr' => [ 'type' => 'node', 'title' => 'Assistant Officer', 'sub' => 'HR / Admin / Training / IT', 'has_prev' => true, 'has_next' => true ],
                    'mf' => [ 'type' => 'node', 'title' => 'Branch Manager', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'pg' => [ 'type' => 'node', 'title' => 'Junior Project Officer', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'fn' => [ 'type' => 'node', 'title' => 'Senior Accountant', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'se' => [ 'type' => 'line' ],
                    'ad' => [ 'type' => 'empty' ],
                    'ma' => [ 'type' => 'node', 'title' => 'Junior Officer', 'sub' => 'Monitoring / Audit', 'has_prev' => true, 'has_next' => false ],
                ],
            ],
            'Grade 11' => [
                'tier'  => 't-field',
                'cells' => [
                    'hr' => [ 'type' => 'line' ],
                    'mf' => [ 'type' => 'node', 'title' => 'Assistant Branch Manager', 'sub' => 'Senior Loan Officer', 'has_prev' => true, 'has_next' => true ],
                    'pg' => [ 'type' => 'node', 'title' => 'Senior Assistant Technical Person', 'sub' => 'Senior Field Facilitator', 'has_prev' => true, 'has_next' => true ],
                    'fn' => [ 'type' => 'node', 'title' => 'Accountant', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'se' => [ 'type' => 'line' ],
                    'ad' => [ 'type' => 'empty' ],
                    'ma' => [ 'type' => 'empty' ],
                ],
            ],
            'Grade 12' => [
                'tier'  => 't-field',
                'cells' => [
                    'hr' => [ 'type' => 'line' ],
                    'mf' => [ 'type' => 'node', 'title' => 'Loan Officer', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'pg' => [ 'type' => 'node', 'title' => 'Field Facilitator', 'sub' => 'Technical Person', 'has_prev' => true, 'has_next' => true ],
                    'fn' => [ 'type' => 'node', 'title' => 'Junior Accountant', 'sub' => '', 'has_prev' => true, 'has_next' => false ],
                    'se' => [ 'type' => 'node', 'title' => 'Production Supervisor', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'ad' => [ 'type' => 'empty' ],
                    'ma' => [ 'type' => 'empty' ],
                ],
            ],
            'Grade 13' => [
                'tier'  => 't-field',
                'cells' => [
                    'hr' => [ 'type' => 'node', 'title' => 'Office Assistant', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'mf' => [ 'type' => 'node', 'title' => 'Junior Field Officer', 'sub' => '', 'has_prev' => true, 'has_next' => true ],
                    'pg' => [ 'type' => 'node', 'title' => 'Health Worker', 'sub' => '', 'has_prev' => true, 'has_next' => false ],
                    'fn' => [ 'type' => 'empty' ],
                    'se' => [ 'type' => 'node', 'title' => 'Machine Operator', 'sub' => 'Artisan', 'has_prev' => true, 'has_next' => true ],
                    'ad' => [ 'type' => 'empty' ],
                    'ma' => [ 'type' => 'empty' ],
                ],
            ],
            'Grade 14' => [
                'tier'  => 't-field',
                'cells' => [
                    'hr' => [ 'type' => 'node', 'title' => 'Office Helper', 'sub' => 'Sweeper / Cook / Guard / Driver', 'has_prev' => true, 'has_next' => false ],
                    'mf' => [ 'type' => 'node', 'title' => 'Office Helper', 'sub' => '', 'has_prev' => true, 'has_next' => false ],
                    'pg' => [ 'type' => 'empty' ],
                    'fn' => [ 'type' => 'empty' ],
                    'se' => [ 'type' => 'node', 'title' => 'Helper', 'sub' => 'Delivery Boy', 'has_prev' => true, 'has_next' => false ],
                    'ad' => [ 'type' => 'empty' ],
                    'ma' => [ 'type' => 'empty' ],
                ],
            ],
        ];
    }

    protected function get_default_manpower_bars() {
        return [
            [ 'grade' => 'Grade 01', 'tier' => 't-lead', 'count' => 1, 'target' => '1', 'width' => '0.3%', 'delay' => '0ms' ],
            [ 'grade' => 'Grade 02', 'tier' => 't-lead', 'count' => 1, 'target' => '1', 'width' => '0.3%', 'delay' => '60ms' ],
            [ 'grade' => 'Grade 03', 'tier' => 't-lead', 'count' => 7, 'target' => '7', 'width' => '1.8%', 'delay' => '120ms' ],
            [ 'grade' => 'Grade 04', 'tier' => 't-lead', 'count' => 7, 'target' => '7', 'width' => '1.8%', 'delay' => '180ms' ],
            [ 'grade' => 'Grade 05', 'tier' => 't-lead', 'count' => 7, 'target' => '7', 'width' => '1.8%', 'delay' => '240ms' ],
            [ 'grade' => 'Grade 06', 'tier' => 't-mgmt', 'count' => 14, 'target' => '14', 'width' => '3.7%', 'delay' => '300ms' ],
            [ 'grade' => 'Grade 07', 'tier' => 't-mgmt', 'count' => 19, 'target' => '19', 'width' => '5.0%', 'delay' => '360ms' ],
            [ 'grade' => 'Grade 08', 'tier' => 't-mgmt', 'count' => 51, 'target' => '51', 'width' => '13.4%', 'delay' => '420ms' ],
            [ 'grade' => 'Grade 09', 'tier' => 't-mgmt', 'count' => 74, 'target' => '74', 'width' => '19.5%', 'delay' => '480ms' ],
            [ 'grade' => 'Grade 10', 'tier' => 't-mgmt', 'count' => 162, 'target' => '162', 'width' => '42.6%', 'delay' => '540ms' ],
            [ 'grade' => 'Grade 11', 'tier' => 't-field', 'count' => 370, 'target' => '370', 'width' => '97.4%', 'delay' => '600ms' ],
            [ 'grade' => 'Grade 12', 'tier' => 't-field', 'count' => 380, 'target' => '380', 'width' => '100%', 'delay' => '660ms' ],
            [ 'grade' => 'Grade 13', 'tier' => 't-field', 'count' => 50, 'target' => '50', 'width' => '13.2%', 'delay' => '720ms' ],
            [ 'grade' => 'Grade 14', 'tier' => 't-field', 'count' => 130, 'target' => '130', 'width' => '34.2%', 'delay' => '780ms' ],
        ];
    }

    /* ── Inline Scalable SVG Icons ─────────────────────────────────────── */
    protected function render_svg_icon( $name ) {
        switch ( $name ) {
            case 'users':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/><path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg>';
            case 'shield':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/><path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/></svg>';
            case 'user-tie':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/><path d="M2 1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V1Zm2-.5a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5V1a.5.5 0 0 0-.5-.5H4Z"/></svg>';
            case 'user-check':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 1.499-.79-.743a.5.5 0 0 0-.686.729l1.1 1.036a.5.5 0 0 0 .708-.024l1.678-1.884a.5.5 0 1 0-.675-.615Z"/><path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/><path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/></svg>';
            case 'user-circle':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/></svg>';
            case 'money-bill':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/><circle cx="8" cy="9.5" r="1.5"/></svg>';
            case 'sitemap':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5v-1zM8.5 3a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/></svg>';
            case 'university':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.382l.5 2a.498.498 0 0 1-.485.618H.5a.5.5 0 0 1-.485-.618l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89L8 0ZM3.777 3h8.447L8 1 3.777 3ZM2 6v7h1V6H2Zm2 0v7h2.5V6H4Zm3.5 0v7h1V6h-1Zm2 0v7H12V6H9.5ZM13 6v7h1V6h-1Zm2-1V4H1v1h14Zm-.39 9H1.39l-.25 1h13.72l-.25-1Z"/></svg>';
            case 'store':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h12V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zm2 .5a.5.5 0 0 1 .5.5V13h8V9.5a.5.5 0 0 1 1 0V13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5a.5.5 0 0 1 .5-.5z"/></svg>';
            case 'bullhorn':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49a68.14 68.14 0 0 0-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 74.663 74.663 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199V2.5zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0zm-1 1.35c-2.344 1.205-5.209 1.843-8.11 2.002L3.84 5.92A1.011 1.011 0 0 0 3 6.94v2.072c.384.053.79.088 1.218.107l.38 2.557a1 1 0 0 0 .979.855h.547a1 1 0 0 0 .908-.592l1.374-2.585c2.476.195 4.908.775 7.104 1.956V3.85z"/></svg>';
            case 'chart-bar':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5h-2v12h2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z"/></svg>';
            case 'download':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg>';
            case 'hand-point':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M6.75 1a.75.75 0 0 1 .75.75V8a.5.5 0 0 0 1 0V5.467l.086-.004c.317-.012.637-.008.816.027.134.027.294.096.448.182.077.042.15.1.212.171a1.6 1.6 0 0 1 .281.464c.088.238.084.464.084.73v.5a.5.5 0 0 0 1 0V6.5c0-.188.006-.411.082-.647.078-.242.222-.442.427-.552.18-.097.382-.134.582-.134.227 0 .462.046.666.14.307.142.499.39.545.739.04.307.037.604.037.808v1.644a.5.5 0 0 0 1 0v-.644c0-.236.002-.51.09-.76.088-.25.26-.454.516-.547a1.44 1.44 0 0 1 .517-.09c.27 0 .524.075.73.224.282.203.435.534.463.92.028.384.028.756.028 1.014v2.5a5.5 5.5 0 0 1-5.5 5.5h-1a5.5 5.5 0 0 1-4.87-2.957L.416 11.39a.5.5 0 0 1 .753-.655l1.869 1.432A2.5 2.5 0 0 0 4.5 13H5a.5.5 0 0 0 .5-.5V1.75A.75.75 0 0 1 6.75 1z"/></svg>';
            case 'search':
                return '<svg viewBox="0 0 16 16" fill="currentColor"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>';
            default:
                return '';
        }
    }

    /* ==========================================================================
       RENDER OUTPUT
       ========================================================================== */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $style    = ! empty( $settings['organogram_style'] ) ? $settings['organogram_style'] : 'matrix';

        // Prepare Leadership Data
        if ( 'custom' === $settings['data_source'] && ! empty( $settings['custom_leadership_items'] ) ) {
            $leadership = [];
            foreach ( $settings['custom_leadership_items'] as $idx => $item ) {
                $leadership[] = [
                    'title'    => $item['role_title'],
                    'subtitle' => $item['role_subtitle'],
                    'grade'    => $item['grade_label'],
                    'icon'     => $item['icon_name'],
                    'color'    => ! empty( $item['accent_color'] ) ? $item['accent_color'] : '#157a3e',
                    'has_prev' => $idx > 0,
                    'has_next' => true,
                    'is_top_b' => $idx >= 2,
                ];
            }
        } else {
            $leadership = $this->get_default_leadership();
        }

        // Prepare Department Data
        if ( 'custom' === $settings['data_source'] && ! empty( $settings['custom_dept_items'] ) ) {
            $departments = [];
            foreach ( $settings['custom_dept_items'] as $item ) {
                $key = sanitize_key( $item['dept_key'] );
                $departments[ $key ] = [
                    'name'   => $item['dept_name'],
                    'color'  => ! empty( $item['dept_color'] ) ? $item['dept_color'] : '#157a3e',
                    'icon'   => $item['dept_icon'],
                    'levels' => $item['dept_levels_info'],
                ];
            }
        } else {
            $departments = $this->get_default_departments();
        }

        // Prepare Matrix / Roles Data
        if ( 'custom' === $settings['data_source'] && ! empty( $settings['custom_position_items'] ) ) {
            $matrix_data = [];
            foreach ( $settings['custom_position_items'] as $item ) {
                $grade     = ! empty( $item['position_grade'] ) ? trim( $item['position_grade'] ) : 'Grade 01';
                $dept_key  = ! empty( $item['position_dept'] ) ? sanitize_key( $item['position_dept'] ) : '';
                $tier      = ! empty( $item['position_tier'] ) ? $item['position_tier'] : 't-mgmt';
                $cell_type = ! empty( $item['cell_type'] ) ? $item['cell_type'] : 'node';

                if ( ! isset( $matrix_data[ $grade ] ) ) {
                    $matrix_data[ $grade ] = [
                        'tier'  => $tier,
                        'cells' => [],
                    ];
                }

                if ( ! empty( $dept_key ) ) {
                    if ( 'node' === $cell_type ) {
                        $matrix_data[ $grade ]['cells'][ $dept_key ] = [
                            'type'     => 'node',
                            'title'    => $item['position_title'],
                            'sub'      => ! empty( $item['position_subtitle'] ) ? $item['position_subtitle'] : '',
                            'has_prev' => true,
                            'has_next' => true,
                        ];
                    } elseif ( 'line' === $cell_type ) {
                        $matrix_data[ $grade ]['cells'][ $dept_key ] = [
                            'type' => 'line',
                        ];
                    } else {
                        $matrix_data[ $grade ]['cells'][ $dept_key ] = [
                            'type' => 'empty',
                        ];
                    }
                }
            }

            // Ensure all defined departments have a cell in each grade row
            foreach ( $matrix_data as $grade_name => &$row_data ) {
                foreach ( $departments as $dk => $d ) {
                    if ( ! isset( $row_data['cells'][ $dk ] ) ) {
                        $row_data['cells'][ $dk ] = [ 'type' => 'empty' ];
                    }
                }
            }
            unset( $row_data );
        } else {
            $matrix_data = $this->get_default_matrix_data();
        }

        $is_full_width = ( ! isset( $settings['full_width'] ) || 'yes' === $settings['full_width'] ) ? 'og-is-fullwidth' : '';
        ?>
        <div class="royal-organogram-wrapper og-style-<?php echo esc_attr( $style ); ?> <?php echo esc_attr( $is_full_width ); ?>" id="royalOrganogram-<?php echo esc_attr( $this->get_id() ); ?>">
            <!-- ================= MAIN CONTENT ================= -->
            <div class="og-main">
                <div class="og-container position-relative" style="z-index:2; width: 100%; margin: 0 auto;">

                    <?php
                    // 1. Toolbar
                    if ( 'yes' === $settings['show_toolbar'] ) {
                        $this->render_toolbar( $settings );
                    }

                    // 2. Render Chosen Organogram Style
                    switch ( $style ) {
                        case 'bento':
                            $this->render_style_bento( $leadership, $departments, $matrix_data );
                            break;
                        case 'tree':
                            $this->render_style_tree( $leadership, $departments, $matrix_data );
                            break;
                        case 'pipeline':
                            $this->render_style_pipeline( $leadership, $departments, $matrix_data );
                            break;
                        case 'minimal':
                            $this->render_style_minimal( $leadership, $departments, $matrix_data );
                            break;
                        case 'cardgrid':
                            $this->render_style_cardgrid( $leadership, $departments, $matrix_data );
                            break;
                        case 'horizontal':
                            $this->render_style_horizontal( $leadership, $departments, $matrix_data );
                            break;
                        case 'circular':
                            $this->render_style_circular( $leadership, $departments, $matrix_data );
                            break;
                        case 'table':
                            $this->render_style_table( $leadership, $departments, $matrix_data, $settings );
                            break;
                        case 'neumorphic':
                            $this->render_style_neumorphic( $leadership, $departments, $matrix_data );
                            break;
                        case 'matrix':
                        default:
                            $this->render_style_matrix( $leadership, $departments, $matrix_data, $settings );
                            break;
                    }

                    // 3. Approved Manpower Section
                    if ( 'yes' === $settings['show_manpower'] ) {
                        $this->render_manpower_section( $settings );
                    }
                    ?>

                </div>
            </div>
        </div>
        <?php
    }

    /* ── Render Toolbar ────────────────────────────────────────────────── */
    protected function render_toolbar( $settings ) {
        ?>
        <div class="og-toolbar og-reveal" style="--delay:0ms;">
            <?php if ( 'yes' === $settings['show_legend'] ) : ?>
                <div class="og-legend">
                    <span class="og-leg t-lead">
                        <i></i> <?php echo esc_html( $settings['legend_lead_label'] ); ?>
                        <?php if ( ! empty( $settings['legend_lead_sub'] ) ) : ?>
                            <small><?php echo esc_html( $settings['legend_lead_sub'] ); ?></small>
                        <?php endif; ?>
                    </span>
                    <span class="og-leg t-mgmt">
                        <i></i> <?php echo esc_html( $settings['legend_mgmt_label'] ); ?>
                        <?php if ( ! empty( $settings['legend_mgmt_sub'] ) ) : ?>
                            <small><?php echo esc_html( $settings['legend_mgmt_sub'] ); ?></small>
                        <?php endif; ?>
                    </span>
                    <span class="og-leg t-field">
                        <i></i> <?php echo esc_html( $settings['legend_field_label'] ); ?>
                        <?php if ( ! empty( $settings['legend_field_sub'] ) ) : ?>
                            <small><?php echo esc_html( $settings['legend_field_sub'] ); ?></small>
                        <?php endif; ?>
                    </span>
                </div>
            <?php endif; ?>

            <div class="og-toolbar-actions">
                <?php if ( 'yes' === $settings['show_search'] ) : ?>
                    <div class="og-search-wrap">
                        <span class="og-search-ico"><?php echo $this->render_svg_icon( 'search' ); ?></span>
                        <input type="text" class="og-search-input" placeholder="<?php echo esc_attr__( 'Search role / person...', 'royal-addons-for-elementor' ); ?>" aria-label="<?php echo esc_attr__( 'Search organogram', 'royal-addons-for-elementor' ); ?>">
                    </div>
                <?php endif; ?>

                <?php if ( 'yes' === $settings['show_download'] ) : ?>
                    <?php if ( 'print' === $settings['download_action'] ) : ?>
                        <button type="button" class="og-dl og-trigger-print">
                            <?php echo $this->render_svg_icon( 'download' ); ?>
                            <span><?php echo esc_html( $settings['download_text'] ); ?></span>
                        </button>
                    <?php else : ?>
                        <a href="<?php echo esc_url( $settings['download_url']['url'] ); ?>" class="og-dl" target="_blank" rel="noopener">
                            <?php echo $this->render_svg_icon( 'download' ); ?>
                            <span><?php echo esc_html( $settings['download_text'] ); ?></span>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    /* ── STYLE 1: Matrix Flow (Unnayan Classic) ──────────────────────── */
    protected function render_style_matrix( $leadership, $departments, $matrix_data, $settings ) {
        ?>
        <!-- ============ DESKTOP CHART (xl and up) ============ -->
        <div class="og-chart-card og-reveal" style="--delay:60ms;">
            <?php if ( 'yes' === $settings['show_tip'] ) : ?>
                <p class="og-hint">
                    <?php echo $this->render_svg_icon( 'hand-point' ); ?>
                    <span><?php echo esc_html( $settings['tip_text'] ); ?></span>
                </p>
            <?php endif; ?>

            <div class="og-chart" id="ogChart-<?php echo esc_attr( $this->get_id() ); ?>" style="--og-cols: <?php echo esc_attr( count( $departments ) ); ?>;">

                <!-- Top Leadership Rows -->
                <?php foreach ( $leadership as $node ) : ?>
                    <div class="og-row og-rowtop">
                        <div class="og-rail">
                            <?php if ( ! empty( $node['grade'] ) ) : ?>
                                <span class="og-grade"><?php echo esc_html( $node['grade'] ); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="og-span">
                            <div class="og-cell <?php echo $node['has_next'] ? 'has-next' : ''; ?> <?php echo $node['has_prev'] ? 'has-prev' : ''; ?>" style="--dc: <?php echo esc_attr( $node['color'] ); ?>;">
                                <div class="og-node og-node-top <?php echo $node['is_top_b'] ? 'og-top-b' : 'og-top-a'; ?>">
                                    <?php echo $this->render_svg_icon( $node['icon'] ); ?>
                                    <b><?php echo esc_html( $node['title'] ); ?></b>
                                    <?php if ( ! empty( $node['subtitle'] ) ) : ?>
                                        <small><?php echo esc_html( $node['subtitle'] ); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Branch Bar -->
                <div class="og-row og-branch">
                    <div class="og-rail"></div>
                    <?php foreach ( $departments as $k => $dept ) : ?>
                        <div class="og-drop" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;"></div>
                    <?php endforeach; ?>
                </div>

                <!-- Department Headers -->
                <div class="og-row og-heads">
                    <div class="og-rail"></div>
                    <?php foreach ( $departments as $k => $dept ) : ?>
                        <div class="og-cell has-next" data-dept="<?php echo esc_attr( $k ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                            <button type="button" class="og-head" data-dept="<?php echo esc_attr( $k ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                                <?php echo $this->render_svg_icon( $dept['icon'] ); ?>
                                <span><?php echo esc_html( $dept['name'] ); ?></span>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Grade Rows (Grades 03 - 14) -->
                <?php foreach ( $matrix_data as $grade_name => $row ) : ?>
                    <div class="og-row og-grade-row og-reveal" style="--delay:0ms;">
                        <div class="og-rail">
                            <span class="og-grade"><?php echo esc_html( $grade_name ); ?></span>
                        </div>

                        <?php foreach ( $departments as $k => $dept ) :
                            $cell = isset( $row['cells'][ $k ] ) ? $row['cells'][ $k ] : [ 'type' => 'empty' ];
                            $cell_type = $cell['type'];

                            if ( 'node' === $cell_type ) :
                                $has_next_class = ! empty( $cell['has_next'] ) ? 'has-next' : '';
                                $has_prev_class = ! empty( $cell['has_prev'] ) ? 'has-prev' : '';
                                ?>
                                <div class="og-cell is-node <?php echo esc_attr( $row['tier'] . ' ' . $has_next_class . ' ' . $has_prev_class ); ?>" data-dept="<?php echo esc_attr( $k ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                                    <div class="og-node">
                                        <b><?php echo esc_html( $cell['title'] ); ?></b>
                                        <?php if ( ! empty( $cell['sub'] ) ) : ?>
                                            <small><?php echo esc_html( $cell['sub'] ); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php elseif ( 'line' === $cell_type ) : ?>
                                <div class="og-cell is-line" data-dept="<?php echo esc_attr( $k ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;"></div>
                            <?php else : ?>
                                <div class="og-cell is-empty" data-dept="<?php echo esc_attr( $k ); ?>"></div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

        <!-- ============ COMPACT VIEW (Mobile / Tablet) ============ -->
        <div class="oc-wrap">
            <!-- Leadership Chain -->
            <div class="oc-lead og-reveal" style="--delay:0ms;">
                <?php foreach ( $leadership as $idx => $node ) : ?>
                    <?php if ( $idx > 0 ) : ?>
                        <span class="oc-link"></span>
                    <?php endif; ?>
                    <div class="oc-top <?php echo $node['is_top_b'] ? 'oc-top-b' : 'oc-top-a'; ?>">
                        <span class="oc-top-ico"><?php echo $this->render_svg_icon( $node['icon'] ); ?></span>
                        <div>
                            <b><?php echo esc_html( $node['title'] ); ?></b>
                            <?php if ( ! empty( $node['subtitle'] ) ) : ?>
                                <small><?php echo esc_html( $node['subtitle'] ); ?></small>
                            <?php elseif ( ! empty( $node['grade'] ) ) : ?>
                                <small><?php echo esc_html( $node['grade'] ); ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <span class="oc-link oc-link-long"></span>
                <div class="oc-branch-label">
                    <?php echo $this->render_svg_icon( 'sitemap' ); ?>
                    <span><?php printf( esc_html__( 'Branches into %d departments', 'royal-addons-for-elementor' ), count( $departments ) ); ?></span>
                </div>
            </div>

            <!-- Department Tabs -->
            <div class="oc-tabs og-reveal" style="--delay:0ms;" role="tablist" aria-label="<?php echo esc_attr__( 'Departments', 'royal-addons-for-elementor' ); ?>">
                <?php
                $first = true;
                foreach ( $departments as $k => $dept ) :
                    $is_active = $first ? 'is-active' : '';
                    $first     = false;
                    ?>
                    <button type="button" role="tab" class="oc-tab <?php echo esc_attr( $is_active ); ?>" data-target="<?php echo esc_attr( $k ); ?>" aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                        <?php echo $this->render_svg_icon( $dept['icon'] ); ?>
                        <span><?php echo esc_html( $dept['name'] ); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Department Panels -->
            <div class="oc-panels og-reveal" style="--delay:60ms;">
                <?php
                $first = true;
                foreach ( $departments as $k => $dept ) :
                    $is_active = $first ? 'is-active' : '';
                    $first     = false;
                    ?>
                    <div class="oc-panel <?php echo esc_attr( $is_active ); ?>" data-key="<?php echo esc_attr( $k ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                        <div class="oc-phead">
                            <span class="oc-pico"><?php echo $this->render_svg_icon( $dept['icon'] ); ?></span>
                            <div>
                                <h3><?php echo esc_html( $dept['name'] ); ?></h3>
                                <p><?php echo esc_html( $dept['levels'] ); ?></p>
                            </div>
                        </div>

                        <ol class="oc-chain">
                            <?php
                            $step_idx = 0;
                            foreach ( $matrix_data as $grade_name => $row ) :
                                if ( ! isset( $row['cells'][ $k ] ) || 'node' !== $row['cells'][ $k ]['type'] ) {
                                    continue;
                                }
                                $cell = $row['cells'][ $k ];
                                $grade_num = preg_replace( '/[^0-9]/', '', $grade_name );
                                ?>
                                <li class="oc-item <?php echo esc_attr( $row['tier'] ); ?>" style="--i: <?php echo esc_attr( $step_idx ); ?>;">
                                    <span class="oc-bub">
                                        <small>Grade</small>
                                        <b><?php echo esc_html( ltrim( $grade_num, '0' ) ); ?></b>
                                    </span>
                                    <div class="oc-card">
                                        <b><?php echo esc_html( $cell['title'] ); ?></b>
                                        <?php if ( ! empty( $cell['sub'] ) ) : ?>
                                            <small><?php echo esc_html( $cell['sub'] ); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </li>
                                <?php
                                $step_idx++;
                            endforeach;
                            ?>
                        </ol>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    /* ── STYLE 2: Neo-Modern Bento Glassmorphism ──────────────────────── */
    protected function render_style_bento( $leadership, $departments, $matrix_data ) {
        ?>
        <div class="og-bento-hero-chain og-reveal">
            <?php foreach ( $leadership as $node ) : ?>
                <div class="og-bento-card og-bento-lead-item" style="--dc: <?php echo esc_attr( $node['color'] ); ?>;">
                    <div class="og-bento-icon"><?php echo $this->render_svg_icon( $node['icon'] ); ?></div>
                    <div>
                        <h4 style="margin: 0; font-size: 1.15rem; font-weight: 800;"><?php echo esc_html( $node['title'] ); ?></h4>
                        <?php if ( ! empty( $node['subtitle'] ) ) : ?>
                            <small style="color: #6b7280; font-weight: 600;"><?php echo esc_html( $node['subtitle'] ); ?></small>
                        <?php elseif ( ! empty( $node['grade'] ) ) : ?>
                            <small style="color: #6b7280; font-weight: 700;"><?php echo esc_html( $node['grade'] ); ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="og-bento-grid og-reveal" style="--delay:80ms;">
            <?php foreach ( $departments as $k => $dept ) : ?>
                <div class="og-bento-dept-card" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;" data-dept="<?php echo esc_attr( $k ); ?>">
                    <div class="og-bento-dept-head">
                        <div class="og-bento-dept-title-wrap">
                            <span class="og-bento-dept-icon"><?php echo $this->render_svg_icon( $dept['icon'] ); ?></span>
                            <h4><?php echo esc_html( $dept['name'] ); ?></h4>
                        </div>
                        <span class="og-bento-badge"><?php echo esc_html( $dept['levels'] ); ?></span>
                    </div>

                    <div class="og-bento-role-list">
                        <?php foreach ( $matrix_data as $grade_name => $row ) :
                            if ( ! isset( $row['cells'][ $k ] ) || 'node' !== $row['cells'][ $k ]['type'] ) {
                                continue;
                            }
                            $cell = $row['cells'][ $k ];
                            ?>
                            <div class="og-bento-role-item">
                                <div>
                                    <b style="display: block; font-size: 0.96rem; color: #111827;"><?php echo esc_html( $cell['title'] ); ?></b>
                                    <?php if ( ! empty( $cell['sub'] ) ) : ?>
                                        <small style="display: block; font-size: 0.8rem; color: #6b7280;"><?php echo esc_html( $cell['sub'] ); ?></small>
                                    <?php endif; ?>
                                </div>
                                <span class="og-bento-role-grade"><?php echo esc_html( $grade_name ); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

    /* ── STYLE 3: Branching Hierarchy Tree ────────────────────────────── */
    protected function render_style_tree( $leadership, $departments, $matrix_data ) {
        ?>
        <div class="og-style-tree og-reveal">
            <div class="og-tree-wrap">
                <!-- Root Leadership Stack -->
                <div class="og-tree-root">
                    <?php foreach ( $leadership as $idx => $node ) :
                        $accent = ! empty( $node['color'] ) ? $node['color'] : '#157a3e';
                        ?>
                        <?php if ( $idx > 0 ) : ?>
                            <div class="og-tree-stem"></div>
                        <?php endif; ?>
                        <div class="og-tree-root-node" style="border-top: 4px solid <?php echo esc_attr( $accent ); ?>;">
                            <b><?php echo esc_html( $node['title'] ); ?></b>
                            <?php if ( ! empty( $node['subtitle'] ) ) : ?>
                                <small style="display: block; color: #64748b; margin-top: 2px;"><?php echo esc_html( $node['subtitle'] ); ?></small>
                            <?php elseif ( ! empty( $node['grade'] ) ) : ?>
                                <small style="display: block; color: #157a3e; font-weight: 700; margin-top: 2px;"><?php echo esc_html( $node['grade'] ); ?></small>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <div class="og-tree-trunk-stem"></div>
                </div>

                <!-- Departments Columns with Mathematical Connector Lines -->
                <div class="og-tree-branches" style="--og-cols: <?php echo esc_attr( count( $departments ) ); ?>;">
                    <?php foreach ( $departments as $k => $dept ) : ?>
                        <div class="og-tree-col" data-dept="<?php echo esc_attr( $k ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                            <div class="og-tree-dept-node" style="border-top: 4px solid <?php echo esc_attr( $dept['color'] ); ?>;">
                                <div class="og-tree-dept-head">
                                    <span style="color: <?php echo esc_attr( $dept['color'] ); ?>; width: 16px; height: 16px; display: inline-flex;"><?php echo $this->render_svg_icon( $dept['icon'] ); ?></span>
                                    <b><?php echo esc_html( $dept['name'] ); ?></b>
                                </div>
                                <small><?php echo esc_html( $dept['levels'] ); ?></small>
                            </div>

                            <!-- Roles Stack -->
                            <?php foreach ( $matrix_data as $grade_name => $row ) :
                                if ( ! isset( $row['cells'][ $k ] ) || 'node' !== $row['cells'][ $k ]['type'] ) {
                                    continue;
                                }
                                $cell = $row['cells'][ $k ];
                                ?>
                                <div class="og-tree-role-stem"></div>
                                <div class="og-tree-role-node">
                                    <b><?php echo esc_html( $cell['title'] ); ?></b>
                                    <small><?php echo esc_html( $grade_name ); ?></small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }

    /* ── STYLE 4: Stepper Department Pipeline ─────────────────────────── */
    protected function render_style_pipeline( $leadership, $departments, $matrix_data ) {
        ?>
        <div class="og-style-pipeline og-reveal">
            <!-- Leadership Milestones -->
            <div class="og-pipeline-leads">
                <?php foreach ( $leadership as $node ) : ?>
                    <div style="background: #ffffff; border-radius: 18px; padding: 18px 22px; border-left: 5px solid <?php echo esc_attr( $node['color'] ); ?>; box-shadow: 0 4px 16px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 14px;">
                        <span style="width: 40px; height: 40px; border-radius: 12px; background: color-mix(in srgb, <?php echo esc_attr( $node['color'] ); ?> 15%, transparent); display: grid; place-items: center; color: <?php echo esc_attr( $node['color'] ); ?>;">
                            <?php echo $this->render_svg_icon( $node['icon'] ); ?>
                        </span>
                        <div>
                            <b style="display: block; font-size: 1.05rem;"><?php echo esc_html( $node['title'] ); ?></b>
                            <small style="color: #6b7280;"><?php echo esc_html( ! empty( $node['subtitle'] ) ? $node['subtitle'] : $node['grade'] ); ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Accordion Department Pipelines -->
            <div class="og-pipeline-dept-list">
                <?php
                $first = true;
                foreach ( $departments as $k => $dept ) :
                    $is_open = $first ? 'is-open' : '';
                    $first   = false;
                    ?>
                    <div class="og-pipeline-dept <?php echo esc_attr( $is_open ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                        <div class="og-pipeline-summary">
                            <h4>
                                <span style="width: 20px; height: 20px; color: <?php echo esc_attr( $dept['color'] ); ?>;"><?php echo $this->render_svg_icon( $dept['icon'] ); ?></span>
                                <span><?php echo esc_html( $dept['name'] ); ?></span>
                            </h4>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span style="font-size: 0.82rem; font-weight: 700; color: #64748b;"><?php echo esc_html( $dept['levels'] ); ?></span>
                                <span class="og-pipeline-chevron">
                                    <svg viewBox="0 0 16 16" width="16" height="16" fill="currentColor"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/></svg>
                                </span>
                            </div>
                        </div>

                        <div class="og-pipeline-content">
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 12px;">
                                <?php foreach ( $matrix_data as $grade_name => $row ) :
                                    if ( ! isset( $row['cells'][ $k ] ) || 'node' !== $row['cells'][ $k ]['type'] ) {
                                        continue;
                                    }
                                    $cell = $row['cells'][ $k ];
                                    ?>
                                    <div style="background: #ffffff; padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                                        <div>
                                            <b style="font-size: 0.92rem; display: block; color: #0f172a;"><?php echo esc_html( $cell['title'] ); ?></b>
                                            <?php if ( ! empty( $cell['sub'] ) ) : ?>
                                                <small style="font-size: 0.78rem; color: #64748b;"><?php echo esc_html( $cell['sub'] ); ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <span style="font-size: 0.74rem; font-weight: 800; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; color: #475569;"><?php echo esc_html( $grade_name ); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    /* ── STYLE 5: Minimalist Corporate Directory ──────────────────────── */
    protected function render_style_minimal( $leadership, $departments, $matrix_data ) {
        ?>
        <div class="og-style-minimal og-reveal">
            <!-- Filter Pills -->
            <div class="og-dir-filters">
                <button type="button" class="og-dir-filter-btn is-active" data-filter="all"><?php echo esc_html__( 'All Departments', 'royal-addons-for-elementor' ); ?></button>
                <?php foreach ( $departments as $k => $dept ) : ?>
                    <button type="button" class="og-dir-filter-btn" data-filter="<?php echo esc_attr( $k ); ?>"><?php echo esc_html( $dept['name'] ); ?></button>
                <?php endforeach; ?>
            </div>

            <!-- Cards Grid -->
            <div class="og-dir-grid">
                <?php foreach ( $departments as $k => $dept ) : ?>
                    <?php foreach ( $matrix_data as $grade_name => $row ) :
                        if ( ! isset( $row['cells'][ $k ] ) || 'node' !== $row['cells'][ $k ]['type'] ) {
                            continue;
                        }
                        $cell = $row['cells'][ $k ];
                        ?>
                        <div class="og-dir-card" data-dept="<?php echo esc_attr( $k ); ?>" style="border-left: 4px solid <?php echo esc_attr( $dept['color'] ); ?>;">
                            <div>
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-size: 0.76rem; font-weight: 800; color: <?php echo esc_attr( $dept['color'] ); ?>; text-transform: uppercase;"><?php echo esc_html( $dept['name'] ); ?></span>
                                    <span style="font-size: 0.74rem; font-weight: 700; background: #f1f5f9; padding: 2px 7px; border-radius: 6px; color: #475569;"><?php echo esc_html( $grade_name ); ?></span>
                                </div>
                                <h4 style="margin: 0 0 4px; font-size: 1.05rem; font-weight: 800; color: #0f172a;"><?php echo esc_html( $cell['title'] ); ?></h4>
                                <?php if ( ! empty( $cell['sub'] ) ) : ?>
                                    <p style="margin: 0; font-size: 0.82rem; color: #64748b;"><?php echo esc_html( $cell['sub'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    /* ── STYLE 6: Executive Team Cards Grid ───────────────────────────── */
    protected function render_style_cardgrid( $leadership, $departments, $matrix_data ) {
        ?>
        <div class="og-style-cardgrid og-reveal">
            <!-- Leadership Executive Banner -->
            <div class="og-cardgrid-leads">
                <?php foreach ( $leadership as $node ) : ?>
                    <div class="og-cardgrid-lead-card" style="--dc: <?php echo esc_attr( $node['color'] ); ?>;">
                        <div class="og-cardgrid-avatar">
                            <?php echo $this->render_svg_icon( $node['icon'] ); ?>
                        </div>
                        <div class="og-cardgrid-lead-info">
                            <span class="og-cardgrid-pill"><?php echo esc_html( ! empty( $node['grade'] ) ? $node['grade'] : 'Leadership' ); ?></span>
                            <h4><?php echo esc_html( $node['title'] ); ?></h4>
                            <?php if ( ! empty( $node['subtitle'] ) ) : ?>
                                <p><?php echo esc_html( $node['subtitle'] ); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Departments Grid of Cards -->
            <div class="og-cardgrid-depts">
                <?php foreach ( $departments as $k => $dept ) : ?>
                    <div class="og-cardgrid-dept-card" data-dept="<?php echo esc_attr( $k ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                        <div class="og-cardgrid-dept-header">
                            <span class="og-cardgrid-dept-ico"><?php echo $this->render_svg_icon( $dept['icon'] ); ?></span>
                            <div class="og-cardgrid-dept-meta">
                                <h3><?php echo esc_html( $dept['name'] ); ?></h3>
                                <small><?php echo esc_html( $dept['levels'] ); ?></small>
                            </div>
                        </div>

                        <div class="og-cardgrid-roles">
                            <?php foreach ( $matrix_data as $grade_name => $row ) :
                                if ( ! isset( $row['cells'][ $k ] ) || 'node' !== $row['cells'][ $k ]['type'] ) {
                                    continue;
                                }
                                $cell = $row['cells'][ $k ];
                                ?>
                                <div class="og-cardgrid-role-item">
                                    <div class="og-cardgrid-role-icon">
                                        <svg viewBox="0 0 16 16" width="14" height="14" fill="currentColor"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
                                    </div>
                                    <div class="og-cardgrid-role-text">
                                        <b><?php echo esc_html( $cell['title'] ); ?></b>
                                        <?php if ( ! empty( $cell['sub'] ) ) : ?>
                                            <small><?php echo esc_html( $cell['sub'] ); ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <span class="og-cardgrid-grade-badge"><?php echo esc_html( $grade_name ); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    /* ── STYLE 7: Horizontal Hierarchy Flow (Roadmap) ─────────────────── */
    protected function render_style_horizontal( $leadership, $departments, $matrix_data ) {
        ?>
        <div class="og-style-horizontal og-reveal">
            <div class="og-horiz-scroll-wrapper">
                <div class="og-horiz-stage og-stage-leadership">
                    <div class="og-horiz-stage-header">
                        <span class="og-horiz-stage-badge"><?php echo esc_html__( 'Tier 01', 'royal-addons-for-elementor' ); ?></span>
                        <h4><?php echo esc_html__( 'Executive Governance', 'royal-addons-for-elementor' ); ?></h4>
                    </div>
                    <div class="og-horiz-nodes-stack">
                        <?php foreach ( $leadership as $node ) : ?>
                            <div class="og-horiz-card is-lead" style="--dc: <?php echo esc_attr( $node['color'] ); ?>;">
                                <div class="og-horiz-card-icon"><?php echo $this->render_svg_icon( $node['icon'] ); ?></div>
                                <div class="og-horiz-card-body">
                                    <b><?php echo esc_html( $node['title'] ); ?></b>
                                    <?php if ( ! empty( $node['subtitle'] ) ) : ?>
                                        <small><?php echo esc_html( $node['subtitle'] ); ?></small>
                                    <?php elseif ( ! empty( $node['grade'] ) ) : ?>
                                        <small><?php echo esc_html( $node['grade'] ); ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="og-horiz-connector-beam">
                    <div class="og-horiz-beam-line"></div>
                </div>

                <div class="og-horiz-stage og-stage-departments">
                    <div class="og-horiz-stage-header">
                        <span class="og-horiz-stage-badge"><?php echo esc_html__( 'Tier 02', 'royal-addons-for-elementor' ); ?></span>
                        <h4><?php echo esc_html__( 'Departments & Operational Units', 'royal-addons-for-elementor' ); ?></h4>
                    </div>
                    <div class="og-horiz-dept-cards">
                        <?php foreach ( $departments as $k => $dept ) : ?>
                            <div class="og-horiz-dept-col" data-dept="<?php echo esc_attr( $k ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                                <div class="og-horiz-dept-top">
                                    <span class="og-horiz-icon-box"><?php echo $this->render_svg_icon( $dept['icon'] ); ?></span>
                                    <h5><?php echo esc_html( $dept['name'] ); ?></h5>
                                    <span class="og-horiz-subpill"><?php echo esc_html( $dept['levels'] ); ?></span>
                                </div>
                                <div class="og-horiz-flow-items">
                                    <?php foreach ( $matrix_data as $grade_name => $row ) :
                                        if ( ! isset( $row['cells'][ $k ] ) || 'node' !== $row['cells'][ $k ]['type'] ) {
                                            continue;
                                        }
                                        $cell = $row['cells'][ $k ];
                                        ?>
                                        <div class="og-horiz-node">
                                            <span class="og-horiz-node-grade"><?php echo esc_html( $grade_name ); ?></span>
                                            <b><?php echo esc_html( $cell['title'] ); ?></b>
                                            <?php if ( ! empty( $cell['sub'] ) ) : ?>
                                                <small><?php echo esc_html( $cell['sub'] ); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /* ── STYLE 8: Hub & Spoke Radial Cluster (Command Center) ─────────── */
    protected function render_style_circular( $leadership, $departments, $matrix_data ) {
        ?>
        <div class="og-style-circular og-reveal">
            <!-- Central Command Hub -->
            <div class="og-radial-hub-wrap">
                <div class="og-radial-radar-ring"></div>
                <div class="og-radial-hub-card">
                    <span class="og-radial-pulse-dot"></span>
                    <div class="og-radial-hub-icon">
                        <?php echo $this->render_svg_icon( 'shield' ); ?>
                    </div>
                    <h3><?php echo esc_html__( 'Executive Command Directorate', 'royal-addons-for-elementor' ); ?></h3>
                    <div class="og-radial-hub-leaders">
                        <?php foreach ( $leadership as $node ) : ?>
                            <span class="og-radial-lead-pill" style="--dc: <?php echo esc_attr( $node['color'] ); ?>;">
                                <?php echo esc_html( $node['title'] ); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Radiating Department Satellite Clusters -->
            <div class="og-radial-spokes-grid">
                <?php foreach ( $departments as $k => $dept ) : ?>
                    <div class="og-radial-pod" data-dept="<?php echo esc_attr( $k ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                        <div class="og-radial-pod-header">
                            <span class="og-radial-pod-ico"><?php echo $this->render_svg_icon( $dept['icon'] ); ?></span>
                            <div>
                                <h4><?php echo esc_html( $dept['name'] ); ?></h4>
                                <small><?php echo esc_html( $dept['levels'] ); ?></small>
                            </div>
                        </div>

                        <div class="og-radial-pod-roles">
                            <?php foreach ( $matrix_data as $grade_name => $row ) :
                                if ( ! isset( $row['cells'][ $k ] ) || 'node' !== $row['cells'][ $k ]['type'] ) {
                                    continue;
                                }
                                $cell = $row['cells'][ $k ];
                                ?>
                                <div class="og-radial-role">
                                    <span class="og-radial-grade-chip"><?php echo esc_html( $grade_name ); ?></span>
                                    <div class="og-radial-role-info">
                                        <b><?php echo esc_html( $cell['title'] ); ?></b>
                                        <?php if ( ! empty( $cell['sub'] ) ) : ?>
                                            <small><?php echo esc_html( $cell['sub'] ); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    /* ── STYLE 9: Corporate Executive Data Matrix Table ───────────────── */
    protected function render_style_table( $leadership, $departments, $matrix_data, $settings ) {
        ?>
        <div class="og-style-table og-reveal">
            <!-- Leadership Row Cards -->
            <div class="og-table-leads-strip">
                <?php foreach ( $leadership as $node ) : ?>
                    <div class="og-table-lead-badge" style="--dc: <?php echo esc_attr( $node['color'] ); ?>;">
                        <?php echo $this->render_svg_icon( $node['icon'] ); ?>
                        <div class="og-table-lead-text">
                            <strong><?php echo esc_html( $node['title'] ); ?></strong>
                            <?php if ( ! empty( $node['subtitle'] ) ) : ?>
                                <span><?php echo esc_html( $node['subtitle'] ); ?></span>
                            <?php elseif ( ! empty( $node['grade'] ) ) : ?>
                                <span><?php echo esc_html( $node['grade'] ); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Full-Width Data Table -->
            <div class="og-table-container">
                <table class="og-matrix-table" style="--og-cols: <?php echo esc_attr( count( $departments ) ); ?>;">
                    <thead>
                        <tr>
                            <th class="og-th-grade"><?php echo esc_html__( 'Grade / Tier', 'royal-addons-for-elementor' ); ?></th>
                            <?php foreach ( $departments as $k => $dept ) : ?>
                                <th class="og-th-dept" data-dept="<?php echo esc_attr( $k ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                                    <span class="og-th-icon"><?php echo $this->render_svg_icon( $dept['icon'] ); ?></span>
                                    <span class="og-th-name"><?php echo esc_html( $dept['name'] ); ?></span>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $matrix_data as $grade_name => $row ) :
                            $tier = ! empty( $row['tier'] ) ? $row['tier'] : 't-mgmt';
                            ?>
                            <tr class="og-tr-grade <?php echo esc_attr( $tier ); ?>">
                                <td class="og-td-grade">
                                    <span class="og-grade-badge"><?php echo esc_html( $grade_name ); ?></span>
                                </td>
                                <?php foreach ( $departments as $k => $dept ) :
                                    $cell = $row['cells'][ $k ] ?? [ 'type' => 'empty' ];
                                    ?>
                                    <td class="og-td-cell og-dept-col-<?php echo esc_attr( $k ); ?>" data-dept="<?php echo esc_attr( $k ); ?>">
                                        <?php if ( 'node' === $cell['type'] ) : ?>
                                            <div class="og-table-role-node <?php echo esc_attr( $tier ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                                                <b class="og-table-role-title"><?php echo esc_html( $cell['title'] ); ?></b>
                                                <?php if ( ! empty( $cell['sub'] ) ) : ?>
                                                    <small class="og-table-role-sub"><?php echo esc_html( $cell['sub'] ); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        <?php elseif ( 'line' === $cell['type'] ) : ?>
                                            <div class="og-table-flow-line" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;"></div>
                                        <?php else : ?>
                                            <span class="og-table-empty">—</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

    /* ── STYLE 10: Cyber Neumorphic 3D Floating ───────────────────────── */
    protected function render_style_neumorphic( $leadership, $departments, $matrix_data ) {
        ?>
        <div class="og-style-neumorphic og-reveal">
            <!-- Neumorphic Leadership Platform -->
            <div class="og-neu-bridge">
                <?php foreach ( $leadership as $node ) : ?>
                    <div class="og-neu-lead-card" style="--dc: <?php echo esc_attr( $node['color'] ); ?>;">
                        <span class="og-neu-led"></span>
                        <div class="og-neu-lead-ico"><?php echo $this->render_svg_icon( $node['icon'] ); ?></div>
                        <div class="og-neu-lead-meta">
                            <h4><?php echo esc_html( $node['title'] ); ?></h4>
                            <?php if ( ! empty( $node['subtitle'] ) ) : ?>
                                <small><?php echo esc_html( $node['subtitle'] ); ?></small>
                            <?php elseif ( ! empty( $node['grade'] ) ) : ?>
                                <small><?php echo esc_html( $node['grade'] ); ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Neumorphic Department Panels -->
            <div class="og-neu-grid">
                <?php foreach ( $departments as $k => $dept ) : ?>
                    <div class="og-neu-panel" data-dept="<?php echo esc_attr( $k ); ?>" style="--dc: <?php echo esc_attr( $dept['color'] ); ?>;">
                        <div class="og-neu-panel-head">
                            <span class="og-neu-icon-bubble"><?php echo $this->render_svg_icon( $dept['icon'] ); ?></span>
                            <div class="og-neu-head-text">
                                <h3><?php echo esc_html( $dept['name'] ); ?></h3>
                                <span><?php echo esc_html( $dept['levels'] ); ?></span>
                            </div>
                        </div>

                        <div class="og-neu-roles-stack">
                            <?php foreach ( $matrix_data as $grade_name => $row ) :
                                if ( ! isset( $row['cells'][ $k ] ) || 'node' !== $row['cells'][ $k ]['type'] ) {
                                    continue;
                                }
                                $cell = $row['cells'][ $k ];
                                ?>
                                <div class="og-neu-role-tile">
                                    <span class="og-neu-status-indicator"></span>
                                    <div class="og-neu-tile-info">
                                        <b><?php echo esc_html( $cell['title'] ); ?></b>
                                        <?php if ( ! empty( $cell['sub'] ) ) : ?>
                                            <small><?php echo esc_html( $cell['sub'] ); ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <span class="og-neu-grade-inset"><?php echo esc_html( $grade_name ); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    /* ── Render Approved Manpower Section ──────────────────────────────── */
    protected function render_manpower_section( $settings ) {
        $bars = $this->get_default_manpower_bars();
        ?>
        <div class="og-man og-reveal" style="--delay:0ms;">
            <div class="og-man-head">
                <span class="og-man-ico"><?php echo $this->render_svg_icon( 'chart-bar' ); ?></span>
                <div>
                    <h2><?php echo esc_html( $settings['manpower_title'] ); ?></h2>
                    <p><?php echo esc_html( $settings['manpower_subtitle'] ); ?></p>
                </div>
            </div>

            <div class="og-man-top">
                <div class="og-stat">
                    <span class="og-stat-ico"><?php echo $this->render_svg_icon( 'users' ); ?></span>
                    <div>
                        <b class="og-num" data-target="<?php echo esc_attr( $settings['stat1_num'] ); ?>" data-pad="2">00</b>
                        <small><?php echo esc_html( $settings['stat1_label'] ); ?></small>
                    </div>
                </div>
                <div class="og-stat">
                    <span class="og-stat-ico og-stat-ico-2"><?php echo $this->render_svg_icon( 'shield' ); ?></span>
                    <div>
                        <b class="og-num" data-target="<?php echo esc_attr( $settings['stat2_num'] ); ?>" data-pad="2">00</b>
                        <small><?php echo esc_html( $settings['stat2_label'] ); ?></small>
                    </div>
                </div>
            </div>

            <?php if ( 'yes' === $settings['show_manpower_bars'] ) : ?>
                <ul class="og-bars">
                    <?php foreach ( $bars as $b ) : ?>
                        <li class="<?php echo esc_attr( $b['tier'] ); ?>">
                            <span class="og-bar-label"><?php echo esc_html( $b['grade'] ); ?></span>
                            <span class="og-bar">
                                <i style="--w: <?php echo esc_attr( $b['width'] ); ?>; --d: <?php echo esc_attr( $b['delay'] ); ?>;"></i>
                            </span>
                            <b class="og-num og-bar-val" data-target="<?php echo esc_attr( $b['target'] ); ?>" data-pad="2">00</b>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <?php
    }
}
