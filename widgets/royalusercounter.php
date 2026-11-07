<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RoyalUserCounter extends Widget_Base{

	public function get_name() {
		return 'royalusercounter';
	}


	public function get_title() {
		return esc_html__( 'User Counter', 'royal-addons-for-elementor' );
	}


	public function get_icon() { return 'eicon-number-field rtbranding'; }


	public function get_categories() {
		return [ 'royaltech' ];
	}


	public function get_keywords() {
		return [ 'user', 'counter', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}


	public function get_style_depends() {
		return [
			'',
		];
	}


	public function get_script_depends() {
		return [
			'royalusercounter',
		];
	}


	protected function register_controls() {
		$this->start_controls_section(
			'uc_content',
			[
				'label' => esc_html__( 'User Counter', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'roles',
			[
				'label' => esc_html__( 'Select Roles', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options'     => \RoyalAddons\Elementor\RoyalClass::royal_get_user_roles(),
			]
		);
		$this->add_control(
			'prefix',
			[
				'label' => esc_html__( 'Prefix Text', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter prefix text', 'royal-addons-for-elementor' ),
				'description' => esc_html__( 'You can use HTML.', 'royal-addons-for-elementor' ),
				'default' => 'Already registered',
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_control(
			'suffix',
			[
				'label' => esc_html__( 'Suffix Text', 'royal-addons-for-elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter suffix text', 'royal-addons-for-elementor' ),
				'description' => esc_html__( 'You can use HTML.', 'royal-addons-for-elementor' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$this->add_responsive_control(
			'display',
			[
				'label' => esc_html__( 'Display', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'block' => esc_html__( 'Block', 'royal-addons-for-elementor' ),
					'inline-block' => esc_html__( 'Inline', 'royal-addons-for-elementor' ),
				],
				'default' => 'block',
				'selectors' => [
					'{{WRAPPER}} .royal-uc-number, {{WRAPPER}} .royal-uc-text' => 'display: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'alignment',
			[
				'label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'royal-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .royalusercounter' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'text_style',
			[
				'label' => esc_html__( 'Text', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1085e4',
				'selectors' => [
					'{{WRAPPER}} .royal-uc-text' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'fields_options' => [
					'typography' => [ 
						'default' =>'custom', 
					],
					'font_weight' => [
						'default' => '600',
					],
					'font_size'   => [
						'default' => [
							'size' => '24',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '32',
						],
					],
				],
				'selector' => '{{WRAPPER}} .royal-uc-text',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .royal-uc-text',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'number_style',
			[
				'label' => esc_html__( 'Number', 'royal-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'number_color',
			[
				'label' => esc_html__( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1085e4',
				'selectors' => [
					'{{WRAPPER}} .royal-uc-number' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'number_typography',
				'fields_options' => [
					'typography' => [ 
						'default' =>'custom', 
					],
					'font_weight' => [
						'default' => '600',
					],
					'font_size'   => [
						'default' => [
							'size' => '24',
						],
					],
					'line_height'   => [
						'default' => [
							'size' => '32',
						],
					],
				],
				'selector' => '{{WRAPPER}} .royal-uc-number',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'number_shadow',
				'selector' => '{{WRAPPER}} .royal-uc-number',
			]
		);
		$this->add_responsive_control(
			'number_margin',
			[
				'label' => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '10',
					'right' => '10',
					'bottom' => '10',
					'left' => '10',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .royal-uc-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// End Number Style
		// ===========================
	}


	protected function render() {
		$data = $this->get_settings_for_display();
		$roles = count_users();
		$roles = $roles['avail_roles'];
		$data_roles = '';

		$count = 0;

		if ( !empty($data['roles']) ) {
			foreach ($data['roles'] as $role) {
				$count += isset($roles[$role]) ? $roles[$role] : 0;
			}
			$data_roles = implode(',', $data['roles']);
		}

		$this->add_render_attribute( 'prefix', 'class', 'royal-uc-text' );
		$this->add_inline_editing_attributes( 'prefix' );

		$this->add_render_attribute( 'suffix', 'class', 'royal-uc-text' );
		$this->add_inline_editing_attributes( 'suffix' );
		?>
		<div class="royalusercounter"
		data-roles="<?php echo esc_attr( $data_roles ); ?>">
			<?php wp_nonce_field( 'royal_user_counter', 'royal_user_counter_nonce' ); ?>
			<?php if ( $data['prefix'] ): ?>
				<h3 <?php echo $this->get_render_attribute_string( 'prefix' ); ?>><?php printf( $data['prefix'] ); ?></h3>
			<?php endif; ?>
			<span class="royal-uc-number"><?php printf( '%s', $count ); ?></span>
			<?php if ( $data['suffix'] ): ?>
				<h3 <?php echo $this->get_render_attribute_string( 'suffix' ); ?>><?php printf( $data['suffix'] ); ?></h3>
			<?php endif; ?>
		</div><!-- .royalusercounter -->
		<?php
	}


	protected function content_template() {

	}
}