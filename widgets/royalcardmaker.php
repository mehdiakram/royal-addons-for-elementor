<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RoyalCardMaker extends Widget_Base {

	public function get_name() {
		return 'royalcardmaker';
	}

	public function get_title() {
		return esc_html__( 'Royal Card Maker', 'royal-addons-for-elementor' );
	}

	public function get_icon() { return 'rtbranding eicon-image-box'; }

	public function get_categories() {
		return [ 'royaltech' ];
	}

	public function get_keywords() {
		return [ 'card', 'maker', 'image', 'generator', 'customizer', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ];
	}

	public function get_style_depends() {
		return [ 'royalcardmaker' ];
	}

	public function get_script_depends() {
		return [ 'royalcardmaker' ];
	}

	protected function register_controls() {
        // Section: Card Maker Settings
		$this->start_controls_section( 'section_backend_settings', [ 'label' => esc_html__( 'Card Maker Settings', 'royal-addons-for-elementor' ), 'tab' => Controls_Manager::TAB_CONTENT, ] );
		$this->add_control('masking_image', [ 'label' => esc_html__( 'Upload Masking Image (PNG)', 'royal-addons-for-elementor' ),'type' => Controls_Manager::MEDIA,'default' => ['url' => \Elementor\Utils::get_placeholder_image_src(),],'description' => esc_html__( 'Upload the frame or background image. Use a transparent PNG where the visitor\'s image will appear.', 'royal-addons-for-elementor' ),]);
		$this->add_responsive_control('output_width', ['label' => esc_html__( 'Output Image Width (px)', 'royal-addons-for-elementor' ),'type' => Controls_Manager::NUMBER,'default' => 800,]);
		$this->add_responsive_control('output_height', ['label' => esc_html__( 'Output Image Height (px)', 'royal-addons-for-elementor' ),'type' => Controls_Manager::NUMBER,'default' => 600,]);
        $this->add_control('visitor_image_heading', ['label' => esc_html__( 'Visitor Image Initial Position', 'royal-addons-for-elementor' ),'type' => Controls_Manager::HEADING,'separator' => 'before',]);
		$this->add_control('visitor_image_pos_x', ['label' => esc_html__( 'Position X (%)', 'royal-addons-for-elementor' ),'type' => Controls_Manager::SLIDER,'range' => ['%' => ['min' => 0, 'max' => 100]],'default' => ['unit' => '%', 'size' => 50],]);
        $this->add_control('visitor_image_pos_y', ['label' => esc_html__( 'Position Y (%)', 'royal-addons-for-elementor' ),'type' => Controls_Manager::SLIDER,'range' => ['%' => ['min' => 0, 'max' => 100]],'default' => ['unit' => '%', 'size' => 50],]);
		$this->end_controls_section();
        // Section: Input Field 1
		$this->start_controls_section('section_input_one_settings', ['label' => esc_html__( 'Input Field 1', 'royal-addons-for-elementor' ),'tab' => Controls_Manager::TAB_CONTENT,]);
        $this->add_control('show_input_one', ['label' => esc_html__( 'Show Input Field 1', 'royal-addons-for-elementor' ),'type' => Controls_Manager::SWITCHER,'return_value' => 'yes','default' => 'yes',]);
        $this->add_control('input_one_placeholder', ['label' => esc_html__( 'Placeholder Text', 'royal-addons-for-elementor' ),'type' => Controls_Manager::TEXT,'default' => esc_html__( 'Enter First Text', 'royal-addons-for-elementor' ),'condition' => ['show_input_one' => 'yes'],]);
		$this->add_control('input_one_limit', ['label' => esc_html__( 'Character Limit', 'royal-addons-for-elementor' ),'type' => Controls_Manager::NUMBER,'min' => 1,'max' => 500,'step' => 1,'default' => 30,'condition' => ['show_input_one' => 'yes'],'description' => esc_html__( 'Set the maximum number of characters allowed.', 'royal-addons-for-elementor' ),]);
        $this->add_control('input_one_pos_x', ['label' => esc_html__( 'Position X (%)', 'royal-addons-for-elementor' ),'type' => Controls_Manager::SLIDER,'range' => ['%' => ['min' => 0, 'max' => 100]],'default' => ['unit' => '%', 'size' => 50],'condition' => ['show_input_one' => 'yes'],]);
        $this->add_control('input_one_pos_y', ['label' => esc_html__( 'Position Y (%)', 'royal-addons-for-elementor' ),'type' => Controls_Manager::SLIDER,'range' => ['%' => ['min' => 0, 'max' => 100]],'default' => ['unit' => '%', 'size' => 20],'condition' => ['show_input_one' => 'yes'],]);
		$this->add_responsive_control('input_one_align', ['label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),'type' => Controls_Manager::CHOOSE,'options' => ['left' => ['title' => esc_html__( 'Left', 'royal-addons-for-elementor' ), 'icon' => 'eicon-text-align-left'],'center' => ['title' => esc_html__( 'Center', 'royal-addons-for-elementor' ), 'icon' => 'eicon-text-align-center'],'right' => ['title' => esc_html__( 'Right', 'royal-addons-for-elementor' ), 'icon' => 'eicon-text-align-right'],],'default' => 'center','toggle' => true,'condition' => ['show_input_one' => 'yes'],]);
        $this->add_responsive_control('input_one_box_width', ['label' => esc_html__( 'Text Box Width (px)', 'royal-addons-for-elementor' ),'type' => Controls_Manager::SLIDER,'size_units' => [ 'px' ],'range' => ['px' => ['min' => 50,'max' => 1000,'step' => 5,],],'default' => ['unit' => 'px','size' => 300,],'condition' => ['show_input_one' => 'yes'],'description' => esc_html__('The width of the invisible box for the text to wrap within.', 'royal-addons-for-elementor'),]);
        $this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'input_one_typography','selector' => '{{WRAPPER}} .rt-editor-preview-text-1','condition' => ['show_input_one' => 'yes'],]);
        $this->add_control('input_one_color', ['label' => esc_html__('Text Color', 'royal-addons-for-elementor'),'type' => Controls_Manager::COLOR,'default' => '#000000','condition' => ['show_input_one' => 'yes'],]);
        $this->end_controls_section();
        // Section: Input Field 2
		$this->start_controls_section('section_input_two_settings', ['label' => esc_html__( 'Input Field 2', 'royal-addons-for-elementor' ),'tab' => Controls_Manager::TAB_CONTENT,]);
        $this->add_control('show_input_two', ['label' => esc_html__( 'Show Input Field 2', 'royal-addons-for-elementor' ),'type' => Controls_Manager::SWITCHER,'return_value' => 'yes','default' => 'yes',]);
        $this->add_control('input_two_placeholder', ['label' => esc_html__( 'Placeholder Text', 'royal-addons-for-elementor' ),'type' => Controls_Manager::TEXT,'default' => esc_html__( 'Enter Second Text', 'royal-addons-for-elementor' ),'condition' => ['show_input_two' => 'yes'],]);
		$this->add_control('input_two_limit', ['label' => esc_html__( 'Character Limit', 'royal-addons-for-elementor' ),'type' => Controls_Manager::NUMBER,'min' => 1,'max' => 500,'step' => 1,'default' => 30,'condition' => ['show_input_two' => 'yes'],'description' => esc_html__( 'Set the maximum number of characters allowed.', 'royal-addons-for-elementor' ),]);
        $this->add_control('input_two_pos_x', ['label' => esc_html__( 'Position X (%)', 'royal-addons-for-elementor' ),'type' => Controls_Manager::SLIDER,'range' => ['%' => ['min' => 0, 'max' => 100]],'default' => ['unit' => '%', 'size' => 50],'condition' => ['show_input_two' => 'yes'],]);
        $this->add_control('input_two_pos_y', ['label' => esc_html__( 'Position Y (%)', 'royal-addons-for-elementor' ),'type' => Controls_Manager::SLIDER,'range' => ['%' => ['min' => 0, 'max' => 100]],'default' => ['unit' => '%', 'size' => 80],'condition' => ['show_input_two' => 'yes'],]);
		$this->add_responsive_control('input_two_align', ['label' => esc_html__( 'Alignment', 'royal-addons-for-elementor' ),'type' => Controls_Manager::CHOOSE,'options' => ['left' => ['title' => esc_html__( 'Left', 'royal-addons-for-elementor' ), 'icon' => 'eicon-text-align-left'],'center' => ['title' => esc_html__( 'Center', 'royal-addons-for-elementor' ), 'icon' => 'eicon-text-align-center'],'right' => ['title' => esc_html__( 'Right', 'royal-addons-for-elementor' ), 'icon' => 'eicon-text-align-right'],],'default' => 'center','toggle' => true,'condition' => ['show_input_two' => 'yes'],]);
        $this->add_responsive_control('input_two_box_width', ['label' => esc_html__( 'Text Box Width (px)', 'royal-addons-for-elementor' ),'type' => Controls_Manager::SLIDER,'size_units' => [ 'px' ],'range' => ['px' => ['min' => 50,'max' => 1000,'step' => 5,],],'default' => ['unit' => 'px','size' => 300,],'condition' => ['show_input_two' => 'yes'],'description' => esc_html__('The width of the invisible box for the text to wrap within.', 'royal-addons-for-elementor'),]);
        $this->add_group_control(Group_Control_Typography::get_type(), ['name' => 'input_two_typography','selector' => '{{WRAPPER}} .rt-editor-preview-text-2','condition' => ['show_input_two' => 'yes'],]);
        $this->add_control('input_two_color', ['label' => esc_html__('Text Color', 'royal-addons-for-elementor'),'type' => Controls_Manager::COLOR,'default' => '#000000','condition' => ['show_input_two' => 'yes'],]);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$js_settings = [
			'mask_url'      => esc_url($settings['masking_image']['url'] ?? ''),
			'width'         => esc_attr($settings['output_width'] ?? 800),
			'height'        => esc_attr($settings['output_height'] ?? 600),
			'visitor_img_x' => esc_attr($settings['visitor_image_pos_x']['size'] ?? 50),
			'visitor_img_y' => esc_attr($settings['visitor_image_pos_y']['size'] ?? 50),
			'input1' => [
				'show'        => ($settings['show_input_one'] ?? 'yes') === 'yes',
				'x'           => esc_attr($settings['input_one_pos_x']['size'] ?? 50),
				'y'           => esc_attr($settings['input_one_pos_y']['size'] ?? 20),
				'align'       => esc_attr($settings['input_one_align'] ?? 'center'),
				'box_width'   => esc_attr($settings['input_one_box_width']['size'] ?? 300),
				'color'       => esc_attr($settings['input_one_color'] ?? '#000000'),
				'font_size'   => esc_attr($settings['input_one_typography_font_size']['size'] ?? 30),
				'font_family' => esc_attr($settings['input_one_typography_font_family'] ?? 'Arial'),
				'font_weight' => esc_attr($settings['input_one_typography_font_weight'] ?? 'normal'),
			],
			'input2' => [
				'show'        => ($settings['show_input_two'] ?? 'yes') === 'yes',
				'x'           => esc_attr($settings['input_two_pos_x']['size'] ?? 50),
				'y'           => esc_attr($settings['input_two_pos_y']['size'] ?? 80),
				'align'       => esc_attr($settings['input_two_align'] ?? 'center'),
				'box_width'   => esc_attr($settings['input_two_box_width']['size'] ?? 300),
				'color'       => esc_attr($settings['input_two_color'] ?? '#000000'),
				'font_size'   => esc_attr($settings['input_two_typography_font_size']['size'] ?? 30),
				'font_family' => esc_attr($settings['input_two_typography_font_family'] ?? 'Arial'),
				'font_weight' => esc_attr($settings['input_two_typography_font_weight'] ?? 'normal'),
			]
		];
		?>
		<div class="rt-card-maker-wrapper" data-settings='<?php echo wp_json_encode($js_settings); ?>'>
			<div class="rt-card-maker-container" style="position: relative; overflow: hidden;">
				<canvas id="rt-card-canvas-<?php echo esc_attr($this->get_id()); ?>" class="rt-card-maker-canvas"></canvas>
			</div>
			<div class="rt-card-maker-controls">
				<div class="rt-control-group">
					<label for="rt-image-uploader-<?php echo esc_attr($this->get_id()); ?>"><?php esc_html_e( 'Upload Your Photo', 'royal-addons-for-elementor' ); ?></label>
					<input type="file" id="rt-image-uploader-<?php echo esc_attr($this->get_id()); ?>" class="rt-image-uploader" accept="image/*">
				</div>
				<?php if ( ($settings['show_input_one'] ?? 'yes') === 'yes' ) : ?>
				<div class="rt-control-group">
					<label for="rt-input-one-<?php echo esc_attr($this->get_id()); ?>"><?php echo esc_html($settings['input_one_placeholder']); ?></label>
					<input type="text" id="rt-input-one-<?php echo esc_attr($this->get_id()); ?>" class="rt-card-maker-input-one" placeholder="<?php echo esc_attr($settings['input_one_placeholder']); ?>" maxlength="<?php echo esc_attr($settings['input_one_limit'] ?? 30); ?>">
				</div>
				<?php endif; ?>
				<?php if ( ($settings['show_input_two'] ?? 'yes') === 'yes' ) : ?>
				<div class="rt-control-group">
					<label for="rt-input-two-<?php echo esc_attr($this->get_id()); ?>"><?php echo esc_html($settings['input_two_placeholder']); ?></label>
					<input type="text" id="rt-input-two-<?php echo esc_attr($this->get_id()); ?>" class="rt-card-maker-input-two" placeholder="<?php echo esc_attr($settings['input_two_placeholder']); ?>" maxlength="<?php echo esc_attr($settings['input_two_limit'] ?? 30); ?>">
				</div>
				<?php endif; ?>
				<button class="rt-card-maker-download-btn"><?php esc_html_e( 'Download Image', 'royal-addons-for-elementor' ); ?></button>
			</div>
		</div>
		<?php
	}

    protected function content_template() {
        ?>
        <#
        const js_settings = {
			mask_url: settings.masking_image.url,
			width: settings.output_width,
			height: settings.output_height,
			visitor_img_x: settings.visitor_image_pos_x.size,
			visitor_img_y: settings.visitor_image_pos_y.size,
			input1: { show: 'yes' === settings.show_input_one, x: settings.input_one_pos_x.size, y: settings.input_one_pos_y.size, align: settings.input_one_align, box_width: settings.input_one_box_width.size, color: settings.input_one_color, font_size: settings.input_one_typography_font_size.size, font_family: settings.input_one_typography_font_family, font_weight: settings.input_one_typography_font_weight, },
			input2: { show: 'yes' === settings.show_input_two, x: settings.input_two_pos_x.size, y: settings.input_two_pos_y.size, align: settings.input_two_align, box_width: settings.input_two_box_width.size, color: settings.input_two_color, font_size: settings.input_two_typography_font_size.size, font_family: settings.input_two_typography_font_family, font_weight: settings.input_two_typography_font_weight, }
		};

        view.addRenderAttribute( 'wrapper', 'class', 'rt-card-maker-wrapper' );
        view.addRenderAttribute( 'wrapper', 'data-settings', JSON.stringify( js_settings ) );

        let containerStyle = `position: relative; overflow: hidden; aspect-ratio: ${(settings.output_width || 4)}/${(settings.output_height || 3)};`;
        if ( settings.masking_image.url ) {
            containerStyle += ` background-image: url(${settings.masking_image.url}); background-size: 100% 100%; background-repeat: no-repeat; background-position: center;`;
        }
        #>
        <div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
			<div class="rt-card-maker-container" style="{{{ containerStyle }}}">
				<canvas id="rt-card-canvas-{{ view.getID() }}" class="rt-card-maker-canvas"></canvas>
                <# if ( 'yes' === settings.show_input_one ) { #>
                    <div class="rt-editor-preview-text rt-editor-preview-text-1" style="position: absolute; top: {{{ settings.input_one_pos_y.size }}}%; left: {{{ settings.input_one_pos_x.size }}}%; width: {{{ settings.input_one_box_width.size }}}px; border: 1px dashed rgba(255,255,255,0.7); padding: 2px; word-wrap: break-word; text-align: {{{ settings.input_one_align }}}; color: {{{ settings.input_one_color }}}; font-family: '{{{ settings.input_one_typography_font_family }}}'; font-weight: {{{ settings.input_one_typography_font_weight }}}; font-size: {{{ settings.input_one_typography_font_size.size }}}px; line-height: 1.2; transform: none; text-shadow: 0 0 3px rgba(0,0,0,0.7);">
                        {{{ settings.input_one_placeholder }}}
                    </div>
                <# } #>
                <# if ( 'yes' === settings.show_input_two ) { #>
                    <div class="rt-editor-preview-text rt-editor-preview-text-2" style="position: absolute; top: {{{ settings.input_two_pos_y.size }}}%; left: {{{ settings.input_two_pos_x.size }}}%; width: {{{ settings.input_two_box_width.size }}}px; border: 1px dashed rgba(255,255,255,0.7); padding: 2px; word-wrap: break-word; text-align: {{{ settings.input_two_align }}}; color: {{{ settings.input_two_color }}}; font-family: '{{{ settings.input_two_typography_font_family }}}'; font-weight: {{{ settings.input_two_typography_font_weight }}}; font-size: {{{ settings.input_two_typography_font_size.size }}}px; line-height: 1.2; transform: none; text-shadow: 0 0 3px rgba(0,0,0,0.7);">
                        {{{ settings.input_two_placeholder }}}
                    </div>
                <# } #>
			</div>
		</div>
        <?php
    }
}