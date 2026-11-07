<?php
namespace RoyalAddons\Modules\Forms\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Field_Registrar {

	private $fields = [];

	public function __construct() {
		$this->register_default_fields();
	}

	private function register_default_fields() {
		$default_fields = [
			'text' => \RoyalAddons\Modules\Forms\Fields\Text::class,
			'email' => \RoyalAddons\Modules\Forms\Fields\Email::class,
			'textarea' => \RoyalAddons\Modules\Forms\Fields\Textarea::class,
			'url' => \RoyalAddons\Modules\Forms\Fields\Url::class,
			'tel' => \RoyalAddons\Modules\Forms\Fields\Tel::class,
			'number' => \RoyalAddons\Modules\Forms\Fields\Number::class,
			'date' => \RoyalAddons\Modules\Forms\Fields\Date::class,
			'time' => \RoyalAddons\Modules\Forms\Fields\Time::class,
			'select' => \RoyalAddons\Modules\Forms\Fields\Select::class,
			'checkbox' => \RoyalAddons\Modules\Forms\Fields\Checkbox::class,
			'radio' => \RoyalAddons\Modules\Forms\Fields\Radio::class,
			'acceptance' => \RoyalAddons\Modules\Forms\Fields\Acceptance::class,
			'file' => \RoyalAddons\Modules\Forms\Fields\File_Upload::class,
			'hidden' => \RoyalAddons\Modules\Forms\Fields\Hidden::class,
			'html' => \RoyalAddons\Modules\Forms\Fields\Html::class,
			'step' => \RoyalAddons\Modules\Forms\Fields\Step::class,
			'recaptcha' => \RoyalAddons\Modules\Forms\Fields\Recaptcha::class,
			'honeypot' => \RoyalAddons\Modules\Forms\Fields\Honeypot::class,
		];

		foreach ( $default_fields as $type => $class ) {
			$this->register( new $class() );
		}
	}

	public function register( $field ) {
		$this->fields[ $field->get_type() ] = $field;
	}

	public function unregister( $type ) {
		unset( $this->fields[ $type ] );
	}

	public function get( $type ) {
		return isset( $this->fields[ $type ] ) ? $this->fields[ $type ] : null;
	}

	public function get_all() {
		return $this->fields;
	}

	public function get_field_types_options() {
		$options = [];
		foreach ( $this->fields as $type => $field ) {
			$options[ $type ] = $field->get_name();
		}
		return $options;
	}

	public function get_field_controls() {
		$controls = [];
		foreach ( $this->fields as $type => $field ) {
			$field_controls = $field->get_field_controls();
			if ( ! empty( $field_controls ) ) {
				$controls = array_merge( $controls, $field_controls );
			}
		}
		return $controls;
	}
}
