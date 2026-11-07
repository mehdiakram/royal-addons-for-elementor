<?php
namespace RoyalAddons\Elementor;

class RoyalClass {


	public static function royaltravel_type( $post_type ) {
		$options = array();
		$taxonomy = 'royaltravel_type';
		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}
		return $options;
	}


	public static function royaltravel_country( $post_type ) {
		$options = array();
		$taxonomy = 'royaltravel_country';
		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}
		return $options;
	}


	public static function royalproperty_type( $post_type ) {
		$options = array();
		$taxonomy = 'royalproperty_type';
		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}
		return $options;
	}


	public static function royalproperty_location( $post_type ) {
		$options = array();
		$taxonomy = 'royalproperty_location';
		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}
		return $options;
	}



	public static function royalproperty_status( $post_type ) {
		$options = array();
		$taxonomy = 'royalproperty_status';
		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}
		return $options;
	}



	public static function royalauto_country( $post_type ) {
		$options = array();
		$taxonomy = 'royalauto_country';
		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}
		return $options;
	}



	public static function royalauto_type( $post_type ) {
		$options = array();
		$taxonomy = 'royalauto_type';
		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}
		return $options;
	}


	public static function royalauto_brand( $post_type ) {
		$options = array();
		$taxonomy = 'royalauto_brand';
		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}
		return $options;
	}


	public static function royaljob_categories( $post_type ) {
		$options = array();
		$taxonomy = 'royaljob_categories';
		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}
		return $options;
	}


	public static function royal_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'royal-addons-for-elementor' ),
			'sm' => __( 'Small', 'royal-addons-for-elementor' ),
			'md' => __( 'Medium', 'royal-addons-for-elementor' ),
			'lg' => __( 'Large', 'royal-addons-for-elementor' ),
			'xl' => __( 'Extra Large', 'royal-addons-for-elementor' ),
		];
	}




	public static function royal_post_types ( $args = array(), $output = 'names', $operator = 'and' ) {
		global $wp_post_types;
		$args = array(
			'public'   => true,
		 );
		 
		$field = ('names' == $output) ? 'name' : false;
		
		$array1 = array("any" => "Any");
		$array2 = wp_filter_object_list($wp_post_types, $args, $operator, $field);
		$result = array_merge($array1, $array2);

		return $result;
	}



	
	public static function get_terms_options( $taxonomy = 'category' ) {
		$terms = konte_addons_get_terms_hierarchy( $taxonomy, '&#8212;' );

		if ( empty( $terms ) ) {
			return [];
		}

		$options = wp_list_pluck( $terms, 'name', 'slug' );

		return $options;
	}




	public static function royalpostexcerpt($limit = 100, $echo = true) {
		$excerpt = get_the_excerpt();
		$excerpt = is_string($excerpt) ? $excerpt : '';
		$excerpt = (string) $excerpt;
		$excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
		$excerpt = strip_tags($excerpt);

		$words = explode(' ', $excerpt, $limit + 1);
		if (count($words) > $limit) {
			array_pop($words);
			$excerpt_output = implode(" ", $words) . '...';
		} else {
			$excerpt_output = implode(" ", $words);
		}

		if ($echo) {
			echo $excerpt_output;
		} else {
			return $excerpt_output;
		}
	}


	/* Dynamic Content Limit */
	public static function royalpostcontent($limit = 100, $echo = false) {
		$content = get_the_content();
		$content = is_string($content) ? $content : '';
		$excerpt = (string) $excerpt;
		$content = apply_filters('the_content', $content);
		$content = strip_tags($content);
		$content = preg_replace('/\[.+\]/', '', $content);
		$content = str_replace(']]>', ']]&gt;', $content);

		$words = explode(' ', $content, $limit + 1);
		if (count($words) > $limit) {
			array_pop($words);
			$final_content = implode(" ", $words) . '...';
		} else {
			$final_content = implode(" ", $words);
		}

		if ($echo) {
			echo $final_content;
		} else {
			return $final_content;
		}
	}



	public static function royal_users() {
		$users = [];		
		foreach ( get_users() as $key => $user ) {
			$users[$user->data->ID] = $user->data->user_nicename;
		}		
		wp_reset_postdata();
		return $users;
	}

	public static function royal_get_user_roles() {
		global $wp_roles;
		$all = $wp_roles->roles;
		$all_roles = [];

		if (!empty($all)) {
			foreach ($all as $key => $value) {
				$all_roles[$key] = $all[$key]['name'];
			}
		}
		return $all_roles;
	}


	function royal_elementor_templates(){
		$page_templates = get_posts( [
			'post_type'         => 'elementor_library',
			'posts_per_page'    => -1
		] );
	
		$options = [];
	
		if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ){
			foreach ( $page_templates as $template ) {
				$options[ $template->ID ] = $template->post_title;
			}
		}
		return $options;
	}



	function royalallpost(){
		$page_templates = get_posts( [
			'post_type'         => 'post',
			'posts_per_page'    => -1
		] );
	
		$options = [];
	
		if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ){
			foreach ( $page_templates as $template ) {
				$options[ $template->ID ] = $template->post_title;
			}
		}
		return $options;
	}

	


	function royalanypost($posttype){
		$page_templates = get_posts( [
			'post_type'         => $posttype,
			'posts_per_page'    => -1
		] );
	
		$options = [];
	
		if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ){
			foreach ( $page_templates as $template ) {
				$options[ $template->ID ] = $template->post_title;
			}
		}
		return $options;
	}
	
	
	public static function royalallpage(){
		$page_templates = get_posts( [
			'post_type'         => 'page',
			'posts_per_page'    => -1
		] );
	
		$options = [];
	
		if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ){
			foreach ( $page_templates as $template ) {
				$options[ $template->ID ] = $template->post_title;
			}
		}
		return $options;
	}


	public static function royalwpcf7(){
		$page_templates = get_posts( [
			'post_type'         => 'wpcf7_contact_form',
			'posts_per_page'    => -1
		] );
	
		$options = [];
	
		if ( ! empty( $page_templates ) && ! is_wp_error( $page_templates ) ){
			foreach ( $page_templates as $template ) {
				$options[ $template->ID ] = $template->post_title;
			}
		}
		return $options;
	}

	 public static function royal_animation_in() {
        return [

            'none' => 'None',

            // Fading Entrances
            'fadeIn'        => 'Fade In',
            'fadeInDown'    => 'Fade In Down',
            'fadeInDownBig' => 'Fade In Down Big', // Added
            'fadeInLeft'    => 'Fade In Left',
            'fadeInLeftBig' => 'Fade In Left Big', // Added
            'fadeInRight'   => 'Fade In Right',
            'fadeInRightBig' => 'Fade In Right Big', // Added
            'fadeInUp'      => 'Fade In Up',
            'fadeInUpBig'   => 'Fade In Up Big', // Added
            'fadeInTopLeft' => 'Fade In Top Left', // Added
            'fadeInTopRight' => 'Fade In Top Right', // Added
            'fadeInBottomLeft' => 'Fade In Bottom Left', // Added
            'fadeInBottomRight' => 'Fade In Bottom Right', // Added

            // Bouncing Entrances
            'bounceIn'     => 'Bounce In',
            'bounceInDown' => 'Bounce In Down',
            'bounceInLeft' => 'Bounce In Left',
            'bounceInRight' => 'Bounce In Right',
            'bounceInUp'   => 'Bounce In Up',

            // Flippers
            'flipInX' => 'Flip In X',
            'flipInY' => 'Flip In Y',

            // Lightspeed Entrances
            'lightSpeedIn' => 'Light Speed In', // This is technically lightSpeedInRight in Animate.css
            'lightSpeedInLeft' => 'Light Speed In Left', // Added

            // Rotators
            'rotateIn'        => 'Rotate In',
            'rotateInDownLeft' => 'Rotate In Down Left',
            'rotateInDownRight' => 'Rotate In Down Right',
            'rotateInUpLeft' => 'Rotate In Up Left',
            'rotateInUpRight' => 'Rotate In Up Right',

            // Sliders
            'slideInDown' => 'Slide In Down',
            'slideInLeft' => 'Slide In Left',
            'slideInRight' => 'Slide In Right',
            'slideInUp'   => 'Slide In Up',

            // Zoom Entrances
            'zoomIn'     => 'Zoom In',
            'zoomInDown' => 'Zoom In Down',
            'zoomInLeft' => 'Zoom In Left',
            'zoomInRight' => 'Zoom In Right',
            'zoomInUp'   => 'Zoom In Up',

            // Back Entrances
            'backInDown' => 'Back In Down', // Added
            'backInLeft' => 'Back In Left', // Added
            'backInRight' => 'Back In Right', // Added
            'backInUp'   => 'Back In Up', // Added

            // Attention Seekers (often used as single animations, not strictly "In" but included in Animate.css)
            'bounce'     => 'Bounce',
            'flash'      => 'Flash',
            'pulse'      => 'Pulse',
            'rubberBand' => 'Rubber Band',
            'shakeX'     => 'Shake X', // Added
            'shakeY'     => 'Shake Y', // Added
            'headShake'  => 'Head Shake',
            'swing'      => 'Swing',
            'tada'       => 'Tada',
            'wobble'     => 'Wobble',
            'jello'      => 'Jello',
            'heartBeat'  => 'Heart Beat', // Added

            // Special Entrances
            'jackInTheBox' => 'Jack In The Box', // Added
            'rollIn'       => 'Roll In',
        ];
    }

	
	public static function royal_animation_out() {
        return [
            'none' => 'None',

            // Back Exits
            'backOutDown' => 'Back Out Down', // Added
            'backOutLeft' => 'Back Out Left', // Added
            'backOutRight' => 'Back Out Right', // Added
            'backOutUp'   => 'Back Out Up', // Added

            // Bouncing Exits
            'bounceOut'     => 'Bounce Out',
            'bounceOutDown' => 'Bounce Out Down',
            'bounceOutLeft' => 'Bounce Out Left',
            'bounceOutRight' => 'Bounce Out Right',
            'bounceOutUp'   => 'Bounce Out Up',

            // Fading Exits
            'fadeOut'        => 'Fade Out',
            'fadeOutDown'    => 'Fade Out Down',
            'fadeOutDownBig' => 'Fade Out Down Big', // Added
            'fadeOutLeft'    => 'Fade Out Left',
            'fadeOutLeftBig' => 'Fade Out Left Big', // Added
            'fadeOutRight'   => 'Fade Out Right',
            'fadeOutRightBig' => 'Fade Out Right Big', // Added
            'fadeOutUp'      => 'Fade Out Up',
            'fadeOutUpBig'   => 'Fade Out Up Big', // Added
            'fadeOutTopLeft' => 'Fade Out Top Left', // Added
            'fadeOutTopRight' => 'Fade Out Top Right', // Added
            'fadeOutBottomLeft' => 'Fade Out Bottom Left', // Added
            'fadeOutBottomRight' => 'Fade Out Bottom Right', // Added

            // Flippers
            'flipOutX' => 'Flip Out X',
            'flipOutY' => 'Flip Out Y',

            // Lightspeed Exits
            'lightSpeedOut' => 'Light Speed Out', // This is technically lightSpeedOutRight in Animate.css
            'lightSpeedOutLeft' => 'Light Speed Out Left', // Added

            // Rotators
            'rotateOut'        => 'Rotate Out',
            'rotateOutDownLeft' => 'Rotate Out Down Left',
            'rotateOutDownRight' => 'Rotate Out Down Right',
            'rotateOutUpLeft' => 'Rotate Out Up Left',
            'rotateOutUpRight' => 'Rotate Out Up Right',

            // Rollers
            'rollOut'      => 'Roll Out',

            // Sliders
            'slideOutDown' => 'Slide Out Down',
            'slideOutLeft' => 'Slide Out Left',
            'slideOutRight' => 'Slide Out Right',
            'slideOutUp'   => 'Slide Out Up',

            // Zoom Exits
            'zoomOut'     => 'Zoom Out',
            'zoomOutDown' => 'Zoom Out Down',
            'zoomOutLeft' => 'Zoom Out Left',
            'zoomOutRight' => 'Zoom Out Right',
            'zoomOutUp'   => 'Zoom Out Up',

            // Special Exits (if any others were there besides hinge, which is usually just an exit)
            // 'hinge' is often treated as an exit effect, but it's typically just a standalone.
            // If you include it here, make sure its label reflects it's unique.
            // 'hinge' => 'Hinge', // Uncomment if you want to include Hinge as an 'Out' animation
        ];
    }



	public static function carousel_pagination( $echo = true ) {
		$pagination = '<div class="konte-carousel__pagination swiper-pagination"></div>';

		if ( $echo ) {
			echo $pagination;
		} else {
			return $pagination;
		}
	}


	public static function carousel_navigation( $type = 'angle', $echo = true ) {
		switch ( $type ) {
			case 'arrow':
				$left  = 'arrow-left';
				$right = 'arrow-left';
				break;

			default:
				$left  = 'left';
				$right = 'right';
				break;
		}

		$arrows = [
			'left' => '<div class="konte-carousel__arrow konte-carousel-navigation--' . esc_attr( $type ) . ' konte-carousel-navigation--prev">
						<span class="svg-icon icon-' . esc_attr( $left ) . '"><svg><use xlink:href="#' . esc_attr( $left ) . '"></use></svg></span>
					</div>',
			'right' => '<div class="konte-carousel__arrow konte-carousel-navigation--' . esc_attr( $type ) . ' konte-carousel-navigation--next">
						<span class="svg-icon icon-' . esc_attr( $right ) . '"><svg><use xlink:href="#' . esc_attr( $right ) . '"></use></svg></span>
					</div>',
		];

		if ( $echo ) {
			echo implode( '', $arrows );
		} else {
			return $arrows;
		}
	}




	
}

