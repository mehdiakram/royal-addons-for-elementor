<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class RoyalFeedViewer extends Widget_Base {

    public function get_name() {
        return 'royalfeedviewer';
    }

    public function get_title() {
        return esc_html__( 'Feed Viewer', 'royal-addons-for-elementor' );
    }

    public function get_icon() { return 'eicon-library-cloud-connect rtbranding'; }

    public function get_categories() {
        return [ 'royaltech' ];
    }

    public function get_keywords() {
        return [ 'rss', 'feed', 'atom', 'posts', 'articles', 'viewer', 'tech', 'technologies', 'royal', 'mehdi', 'akram' ];
    }

    public function get_style_depends() {
        return [ 'royalfeedviewer' ];
    }

    public function get_script_depends() {
        return [ 'royalfeedviewer' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_feed_content',
            [
                'label' => esc_html__( 'Feed Settings', 'royal-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'feed_url',
            [
                'label'       => esc_html__( 'RSS Feed URL', 'royal-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'https://wordpress.org/news/feed/', 'royal-addons-for-elementor' ),
                'label_block' => true,
                'default'     => 'https://wordpress.org/news/feed/',
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'items_to_show',
            [
                'label'   => esc_html__( 'Items to Show', 'royal-addons-for-elementor' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 1,
                'max'     => 30,
                'step'    => 1,
                'default' => 5,
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label'        => esc_html__( 'Show Featured Image', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label'        => esc_html__( 'Show Excerpt', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'     => esc_html__( 'Excerpt Length (Words)', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 5,
                'max'       => 200,
                'step'      => 1,
                'default'   => 20,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label'        => esc_html__( 'Show Read More Link', 'royal-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'royal-addons-for-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'royal-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'     => esc_html__( 'Read More Text', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Read More »', 'royal-addons-for-elementor' ),
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

		$this->add_control(
			'feed_validator_info',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => sprintf(
					__( 'Validate your RSS or Atom feed using the %1$sW3C Feed Validator%2$s.', 'royal-addons-for-elementor' ),
					'<a href="https://validator.w3.org/feed/" target="_blank">',
					'</a>'
				),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'feedburner_info',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => sprintf(
					__( 'Optimize and distribute your feed via %1$sGoogle FeedBurner%2$s.', 'royal-addons-for-elementor' ),
					'<a href="https://feedburner.google.com/" target="_blank">',
					'</a>'
				),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);




        $this->end_controls_section();

        // All other style controls remain unchanged
        $this->start_controls_section(
            'section_item_style',
            [
                'label' => esc_html__( 'Item', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors'  => [
                    '{{WRAPPER}} .rt-feed-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__( 'Padding', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .rt-feed-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_margin_bottom',
            [
                'label'      => esc_html__( 'Space Between Items', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
				'default' 	=> [
					'size' => 10,
					'unit' => 'px',
				],
                'selectors'  => [
                    '{{WRAPPER}} .rt-feed-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'item_border',
                'selector' => '{{WRAPPER}} .rt-feed-item',
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .rt-feed-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_box_shadow',
                'selector' => '{{WRAPPER}} .rt-feed-item',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_image_style',
            [
                'label'     => esc_html__( 'Image', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_image' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label'      => esc_html__( 'Width', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
				'range'      => [ 
					'px' => [ 
						'min' => 0, 
						'max' => 250 
					],
					'%' => [ 
						'min' => 0, 
						'max' => 100 
					]
				],
				'default' 	=> [
					'size' => 100,
					'unit' => 'px',
				],
                'selectors'  => [ '{{WRAPPER}} .rt-feed-item-thumbnail img' => 'width: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [ '{{WRAPPER}} .rt-feed-item-thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [ '{{WRAPPER}} .rt-feed-item-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Title', 'royal-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .rt-feed-item-title a' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .rt-feed-item-title a:hover' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .rt-feed-item-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [ '{{WRAPPER}} .rt-feed-item-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_excerpt_style',
            [
                'label'     => esc_html__( 'Excerpt', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_excerpt' => 'yes' ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'     => esc_html__( 'Color', 'royal-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .rt-feed-item-excerpt' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .rt-feed-item-excerpt',
            ]
        );

        $this->add_responsive_control(
            'excerpt_margin',
            [
                'label'      => esc_html__( 'Margin', 'royal-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [ '{{WRAPPER}} .rt-feed-item-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_read_more_style',
            [
                'label'     => esc_html__( 'Read More Link', 'royal-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_read_more' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'read_more_typography',
                'selector' => '{{WRAPPER}} .rt-feed-read-more',
            ]
        );

        $this->start_controls_tabs( 'read_more_tabs' );
        $this->start_controls_tab( 'read_more_normal_tab', [ 'label' => esc_html__( 'Normal', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'read_more_color', [ 'label' => esc_html__( 'Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .rt-feed-read-more' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'read_more_bg_color', [ 'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .rt-feed-read-more' => 'background-color: {{VALUE}};' ] ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'read_more_hover_tab', [ 'label' => esc_html__( 'Hover', 'royal-addons-for-elementor' ) ] );
        $this->add_control( 'read_more_hover_color', [ 'label' => esc_html__( 'Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .rt-feed-read-more:hover' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'read_more_hover_bg_color', [ 'label' => esc_html__( 'Background Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .rt-feed-read-more:hover' => 'background-color: {{VALUE}};' ] ] );
        $this->add_control( 'read_more_hover_border_color', [ 'label' => esc_html__( 'Border Color', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .rt-feed-read-more:hover' => 'border-color: {{VALUE}};' ] ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'read_more_border', 'selector' => '{{WRAPPER}} .rt-feed-read-more', 'separator' => 'before' ] );
        $this->add_control( 'read_more_border_radius', [ 'label' => esc_html__( 'Border Radius', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', '%' ], 'selectors' => [ '{{WRAPPER}} .rt-feed-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
        $this->add_responsive_control( 'read_more_padding', [ 'label' => esc_html__( 'Padding', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em', '%' ], 'selectors' => [ '{{WRAPPER}} .rt-feed-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );
        $this->add_responsive_control( 'read_more_margin', [ 'label' => esc_html__( 'Margin', 'royal-addons-for-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => [ 'px', 'em', '%' ], 'selectors' => [ '{{WRAPPER}} .rt-feed-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );

        $this->end_controls_section();
    }

    /**
     * The new, robust render method.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $feed_url = $settings['feed_url'];

        if ( ! is_string( $feed_url ) || empty( trim( $feed_url ) ) ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div class="elementor-alert elementor-alert-warning">' . esc_html__( 'Please enter a valid RSS feed URL.', 'royal-addons-for-elementor' ) . '</div>';
            }
            return;
        }

        $transient_key = 'rt_feed_arr_' . md5( $feed_url . $settings['items_to_show'] . $settings['excerpt_length'] );
        $feed_items = get_transient( $transient_key );

        if ( false === $feed_items ) {
            include_once( ABSPATH . WPINC . '/feed.php' );
            $rss = fetch_feed( esc_url_raw( $feed_url ) );

            if ( is_wp_error( $rss ) ) {
                if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                    echo '<div class="elementor-alert elementor-alert-danger">' . esc_html__( 'Error: Feed could not be loaded. Please check the URL.', 'royal-addons-for-elementor' ) . ' (' . $rss->get_error_message() . ')</div>';
                }
                return;
            }

            if ( ! $rss->get_item_quantity() ) {
                // Cache an empty result to avoid re-fetching a known empty feed
                set_transient( $transient_key, [], HOUR_IN_SECONDS );
                if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                     echo '<div class="elementor-alert elementor-alert-info">' . esc_html__( 'This feed has no items.', 'royal-addons-for-elementor' ) . '</div>';
                }
                return;
            }
            
            $max_items = $rss->get_item_quantity( $settings['items_to_show'] );
            $rss_items = $rss->get_items( 0, $max_items );
            $feed_items = [];

            foreach ( $rss_items as $rss_item ) {
                $thumbnail = '';
                if ( 'yes' === $settings['show_image'] ) {
                    $enclosure = $rss_item->get_enclosure();
                    if ( $enclosure && strpos( $enclosure->get_type(), 'image' ) !== false ) {
                        $thumbnail = $enclosure->get_link();
                    } else {
                        $content = $rss_item->get_content();
                        if ( preg_match( '/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $content, $matches ) ) {
                            $thumbnail = $matches['src'];
                        }
                    }
                }

                $feed_items[] = [
                    'title'       => $rss_item->get_title(),
                    'link'        => $rss_item->get_permalink(),
                    'description' => wp_trim_words( strip_tags( $rss_item->get_description() ), absint( $settings['excerpt_length'] ), '...' ),
                    'thumbnail'   => $thumbnail,
                ];
            }

            set_transient( $transient_key, $feed_items, HOUR_IN_SECONDS );

            if ( method_exists( $rss, '__destruct' ) ) {
                $rss->__destruct();
            }
            unset($rss);
        }

        if ( empty( $feed_items ) ) {
             if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div class="elementor-alert elementor-alert-info">' . esc_html__( 'This feed has no items or could not be processed.', 'royal-addons-for-elementor' ) . '</div>';
            }
            return;
        }

        echo '<div class="rt-feed-container">';

        foreach ( $feed_items as $item ) {
            ?>
            <article class="rt-feed-item">
                <?php if ( 'yes' === $settings['show_image'] && ! empty( $item['thumbnail'] ) ) : ?>
                    <div class="rt-feed-item-thumbnail">
                        <a href="<?php echo esc_url( $item['link'] ); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url( $item['thumbnail'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>">
                        </a>
                    </div>
                <?php endif; ?>

                <div class="rt-feed-item-content">
                    <h3 class="rt-feed-item-title">
                        <a href="<?php echo esc_url( $item['link'] ); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo esc_html( $item['title'] ); ?>
                        </a>
                    </h3>

                    <?php if ( 'yes' === $settings['show_excerpt'] && ! empty( $item['description'] ) ) : ?>
                        <div class="rt-feed-item-excerpt">
                            <?php echo wp_kses_post( $item['description'] ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( 'yes' === $settings['show_read_more'] && ! empty( $settings['read_more_text'] ) ) : ?>
                        <a href="<?php echo esc_url( $item['link'] ); ?>" class="rt-feed-read-more" target="_blank" rel="noopener noreferrer">
                            <?php echo esc_html( $settings['read_more_text'] ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </article>
            <?php
        }

        echo '</div>';
    }

    protected function content_template() {
        ?>
        <div class="rt-feed-container">
            <#
            var placeholder_items = 3;
            for ( var i = 0; i < placeholder_items; i++ ) {
            #>
            <article class="rt-feed-item">
                <# if ( 'yes' === settings.show_image ) { #>
                    <div class="rt-feed-item-thumbnail">
                        <a href="#" onclick="return false;">
                            <img src="https://via.placeholder.com/800x450.png?text=Feed+Image" alt="Placeholder Image">
                        </a>
                    </div>
                <# } #>

                <div class="rt-feed-item-content">
                    <h3 class="rt-feed-item-title">
                        <a href="#" onclick="return false;">
                            <?php esc_html_e( 'This is a Sample Feed Title', 'royal-addons-for-elementor' ); ?>
                        </a>
                    </h3>

                    <# if ( 'yes' === settings.show_excerpt ) { #>
                        <div class="rt-feed-item-excerpt">
                            <?php esc_html_e( 'This is a sample excerpt text. You can style the color, font, and spacing of this content. The actual content will be loaded from the live feed on your website.', 'royal-addons-for-elementor' ); ?>
                        </div>
                    <# } #>

                    <# if ( 'yes' === settings.show_read_more && settings.read_more_text ) { #>
                        <a href="#" class="rt-feed-read-more" onclick="return false;">
                            {{{ settings.read_more_text }}}
                        </a>
                    <# } #>
                </div>
            </article>
            <#
            } // end for loop
            #>
        </div>
        <?php
    }
}