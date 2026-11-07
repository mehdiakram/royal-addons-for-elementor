<?php
namespace RoyalAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

defined('ABSPATH') || die();

class RoyalSourceCode extends Widget_Base {
	public function get_name() {
		return 'royalsourcecode';
	}

	public function get_title() {
		return __('Source Code', 'royal-addons-for-elementor');
	}


	public function get_icon() { return 'eicon-code-highlight rtbranding'; }


	public function get_keywords() {
		return ['source code', 'source', 'code', 'highlight', 'tech', 'technologies', 'royal',  'mehdi',  'akram'];
	}

	
	public function get_style_depends() {
		$styles = [ 'prism', 'royalsourcecode'];
		return $styles;
	}

	public function get_script_depends() {
		$scripts = ['prism', 'royalsourcecode'];
		return $scripts;
	}


	public function lng_type() {
		return [
			'markup' => __('HTML Markup', 'royal-addons-for-elementor'),
			'css' => __('CSS', 'royal-addons-for-elementor'),
			'clike' => __('Clike', 'royal-addons-for-elementor'),
			'javascript' => __('JavaScript', 'royal-addons-for-elementor'),
			'abap' => __('ABAP', 'royal-addons-for-elementor'),
			'abnf' => __('Augmented Backus–Naur form', 'royal-addons-for-elementor'),
			'actionscript' => __('ActionScript', 'royal-addons-for-elementor'),
			'ada' => __('Ada', 'royal-addons-for-elementor'),
			'apacheconf' => __('Apache Configuration', 'royal-addons-for-elementor'),
			'apl' => __('APL', 'royal-addons-for-elementor'),
			'applescript' => __('AppleScript', 'royal-addons-for-elementor'),
			'arduino' => __('Arduino', 'royal-addons-for-elementor'),
			'arff' => __('ARFF', 'royal-addons-for-elementor'),
			'asciidoc' => __('AsciiDoc', 'royal-addons-for-elementor'),
			'asm6502' => __('6502 Assembly', 'royal-addons-for-elementor'),
			'aspnet' => __('ASP.NET (C#)', 'royal-addons-for-elementor'),
			'autohotkey' => __('AutoHotkey', 'royal-addons-for-elementor'),
			'autoit' => __('Autoit', 'royal-addons-for-elementor'),
			'bash' => __('Bash', 'royal-addons-for-elementor'),
			'basic' => __('BASIC', 'royal-addons-for-elementor'),
			'batch' => __('Batch', 'royal-addons-for-elementor'),
			'bison' => __('Bison', 'royal-addons-for-elementor'),
			'bnf' => __('Bnf', 'royal-addons-for-elementor'),
			'brainfuck' => __('Brainfuck', 'royal-addons-for-elementor'),
			'bro' => __('Bro', 'royal-addons-for-elementor'),
			'c' => __('C', 'royal-addons-for-elementor'),
			'csharp' => __('Csharp', 'royal-addons-for-elementor'),
			'cpp' => __('Cpp', 'royal-addons-for-elementor'),
			'cil' => __('Cil', 'royal-addons-for-elementor'),
			'coffeescript' => __('Coffeescript', 'royal-addons-for-elementor'),
			'cmake' => __('Cmake', 'royal-addons-for-elementor'),
			'clojure' => __('Clojure', 'royal-addons-for-elementor'),
			'crystal' => __('Crystal', 'royal-addons-for-elementor'),
			'csp' => __('Csp', 'royal-addons-for-elementor'),
			'css-extras' => __('Css-extras', 'royal-addons-for-elementor'),
			'd' => __('D', 'royal-addons-for-elementor'),
			'dart' => __('Dart', 'royal-addons-for-elementor'),
			'diff' => __('Diff', 'royal-addons-for-elementor'),
			'django' => __('Django', 'royal-addons-for-elementor'),
			'dns-zone-file' => __('Dns-zone-file', 'royal-addons-for-elementor'),
			'docker' => __('Docker', 'royal-addons-for-elementor'),
			'ebnf' => __('Ebnf', 'royal-addons-for-elementor'),
			'eiffel' => __('Eiffel', 'royal-addons-for-elementor'),
			'ejs' => __('Ejs', 'royal-addons-for-elementor'),
			'elixir' => __('Elixir', 'royal-addons-for-elementor'),
			'elm' => __('Elm', 'royal-addons-for-elementor'),
			'erb' => __('Erb', 'royal-addons-for-elementor'),
			'erlang' => __('Erlang', 'royal-addons-for-elementor'),
			'fsharp' => __('Fsharp', 'royal-addons-for-elementor'),
			'firestore-security-rules' => __('Firestore-security-rules', 'royal-addons-for-elementor'),
			'flow' => __('Flow', 'royal-addons-for-elementor'),
			'fortran' => __('Fortran', 'royal-addons-for-elementor'),
			'gcode' => __('Gcode', 'royal-addons-for-elementor'),
			'gdscript' => __('Gdscript', 'royal-addons-for-elementor'),
			'gedcom' => __('Gedcom', 'royal-addons-for-elementor'),
			'gherkin' => __('Gherkin', 'royal-addons-for-elementor'),
			'git' => __('Git', 'royal-addons-for-elementor'),
			'glsl' => __('Glsl', 'royal-addons-for-elementor'),
			'gml' => __('Gml', 'royal-addons-for-elementor'),
			'go' => __('Go', 'royal-addons-for-elementor'),
			'graphql' => __('Graphql', 'royal-addons-for-elementor'),
			'groovy' => __('Groovy', 'royal-addons-for-elementor'),
			'haml' => __('Haml', 'royal-addons-for-elementor'),
			'handlebars' => __('Handlebars', 'royal-addons-for-elementor'),
			'haskell' => __('Haskell', 'royal-addons-for-elementor'),
			'haxe' => __('Haxe', 'royal-addons-for-elementor'),
			'hcl' => __('Hcl', 'royal-addons-for-elementor'),
			'http' => __('Http', 'royal-addons-for-elementor'),
			'hpkp' => __('Hpkp', 'royal-addons-for-elementor'),
			'hsts' => __('Hsts', 'royal-addons-for-elementor'),
			'ichigojam' => __('Ichigojam', 'royal-addons-for-elementor'),
			'icon' => __('Icon', 'royal-addons-for-elementor'),
			'inform7' => __('Inform7', 'royal-addons-for-elementor'),
			'ini' => __('Ini', 'royal-addons-for-elementor'),
			'io' => __('Io', 'royal-addons-for-elementor'),
			'j' => __('J', 'royal-addons-for-elementor'),
			'java' => __('Java', 'royal-addons-for-elementor'),
			'javadoc' => __('Javadoc', 'royal-addons-for-elementor'),
			'javadoclike' => __('Javadoclike', 'royal-addons-for-elementor'),
			'javastacktrace' => __('Javastacktrace', 'royal-addons-for-elementor'),
			'jolie' => __('Jolie', 'royal-addons-for-elementor'),
			'jq' => __('Jq', 'royal-addons-for-elementor'),
			'jsdoc' => __('Jsdoc', 'royal-addons-for-elementor'),
			'js-extras' => __('Js-extras', 'royal-addons-for-elementor'),
			'js-templates' => __('Js-templates', 'royal-addons-for-elementor'),
			'json' => __('Json', 'royal-addons-for-elementor'),
			'jsonp' => __('Jsonp', 'royal-addons-for-elementor'),
			'json5' => __('Json5', 'royal-addons-for-elementor'),
			'julia' => __('Julia', 'royal-addons-for-elementor'),
			'keyman' => __('Keyman', 'royal-addons-for-elementor'),
			'kotlin' => __('Kotlin', 'royal-addons-for-elementor'),
			'latex' => __('Latex', 'royal-addons-for-elementor'),
			'less' => __('Less', 'royal-addons-for-elementor'),
			'lilypond' => __('Lilypond', 'royal-addons-for-elementor'),
			'liquid' => __('Liquid', 'royal-addons-for-elementor'),
			'lisp' => __('Lisp', 'royal-addons-for-elementor'),
			'livescript' => __('Livescript', 'royal-addons-for-elementor'),
			'lolcode' => __('Lolcode', 'royal-addons-for-elementor'),
			'lua' => __('Lua', 'royal-addons-for-elementor'),
			'makefile' => __('Makefile', 'royal-addons-for-elementor'),
			'markdown' => __('Markdown', 'royal-addons-for-elementor'),
			'markup-templating' => __('Markup-templating', 'royal-addons-for-elementor'),
			'matlab' => __('Matlab', 'royal-addons-for-elementor'),
			'mel' => __('Mel', 'royal-addons-for-elementor'),
			'mizar' => __('Mizar', 'royal-addons-for-elementor'),
			'monkey' => __('Monkey', 'royal-addons-for-elementor'),
			'n1ql' => __('N1ql', 'royal-addons-for-elementor'),
			'n4js' => __('N4js', 'royal-addons-for-elementor'),
			'nand2tetris-hdl' => __('Nand2tetris-hdl', 'royal-addons-for-elementor'),
			'nasm' => __('Nasm', 'royal-addons-for-elementor'),
			'nginx' => __('Nginx', 'royal-addons-for-elementor'),
			'nim' => __('Nim', 'royal-addons-for-elementor'),
			'nix' => __('Nix', 'royal-addons-for-elementor'),
			'nsis' => __('Nsis', 'royal-addons-for-elementor'),
			'objectivec' => __('Objectivec', 'royal-addons-for-elementor'),
			'ocaml' => __('Ocaml', 'royal-addons-for-elementor'),
			'opencl' => __('Opencl', 'royal-addons-for-elementor'),
			'oz' => __('Oz', 'royal-addons-for-elementor'),
			'parigp' => __('Parigp', 'royal-addons-for-elementor'),
			'parser' => __('Parser', 'royal-addons-for-elementor'),
			'pascal' => __('Pascal', 'royal-addons-for-elementor'),
			'pascaligo' => __('Pascaligo', 'royal-addons-for-elementor'),
			'pcaxis' => __('Pcaxis', 'royal-addons-for-elementor'),
			'perl' => __('Perl', 'royal-addons-for-elementor'),
			'php' => __('Php', 'royal-addons-for-elementor'),
			'phpdoc' => __('Phpdoc', 'royal-addons-for-elementor'),
			'php-extras' => __('Php-extras', 'royal-addons-for-elementor'),
			'plsql' => __('Plsql', 'royal-addons-for-elementor'),
			'powershell' => __('Powershell', 'royal-addons-for-elementor'),
			'processing' => __('Processing', 'royal-addons-for-elementor'),
			'prolog' => __('Prolog', 'royal-addons-for-elementor'),
			'properties' => __('Properties', 'royal-addons-for-elementor'),
			'protobuf' => __('Protobuf', 'royal-addons-for-elementor'),
			'pug' => __('Pug', 'royal-addons-for-elementor'),
			'puppet' => __('Puppet', 'royal-addons-for-elementor'),
			'pure' => __('Pure', 'royal-addons-for-elementor'),
			'python' => __('Python', 'royal-addons-for-elementor'),
			'q' => __('Q', 'royal-addons-for-elementor'),
			'qore' => __('Qore', 'royal-addons-for-elementor'),
			'r' => __('R', 'royal-addons-for-elementor'),
			'jsx' => __('Jsx', 'royal-addons-for-elementor'),
			'tsx' => __('Tsx', 'royal-addons-for-elementor'),
			'renpy' => __('Renpy', 'royal-addons-for-elementor'),
			'reason' => __('Reason', 'royal-addons-for-elementor'),
			'regex' => __('Regex', 'royal-addons-for-elementor'),
			'rest' => __('Rest', 'royal-addons-for-elementor'),
			'rip' => __('Rip', 'royal-addons-for-elementor'),
			'roboconf' => __('Roboconf', 'royal-addons-for-elementor'),
			'ruby' => __('Ruby', 'royal-addons-for-elementor'),
			'rust' => __('Rust', 'royal-addons-for-elementor'),
			'sas' => __('Sas', 'royal-addons-for-elementor'),
			'sass' => __('Sass', 'royal-addons-for-elementor'),
			'scss' => __('Scss', 'royal-addons-for-elementor'),
			'scala' => __('Scala', 'royal-addons-for-elementor'),
			'scheme' => __('Scheme', 'royal-addons-for-elementor'),
			'shell-session' => __('Shell-session', 'royal-addons-for-elementor'),
			'smalltalk' => __('Smalltalk', 'royal-addons-for-elementor'),
			'smarty' => __('Smarty', 'royal-addons-for-elementor'),
			'soy' => __('Soy', 'royal-addons-for-elementor'),
			'splunk-spl' => __('Splunk-spl', 'royal-addons-for-elementor'),
			'sql' => __('Sql', 'royal-addons-for-elementor'),
			'stylus' => __('Stylus', 'royal-addons-for-elementor'),
			'swift' => __('Swift', 'royal-addons-for-elementor'),
			'tap' => __('Tap', 'royal-addons-for-elementor'),
			'tcl' => __('Tcl', 'royal-addons-for-elementor'),
			'textile' => __('Textile', 'royal-addons-for-elementor'),
			'toml' => __('Toml', 'royal-addons-for-elementor'),
			'tt2' => __('Tt2', 'royal-addons-for-elementor'),
			'turtle' => __('Turtle', 'royal-addons-for-elementor'),
			'twig' => __('Twig', 'royal-addons-for-elementor'),
			'typescript' => __('Typescript', 'royal-addons-for-elementor'),
			't4-cs' => __('T4-cs', 'royal-addons-for-elementor'),
			't4-vb' => __('T4-vb', 'royal-addons-for-elementor'),
			't4-templating' => __('T4-templating', 'royal-addons-for-elementor'),
			'vala' => __('Vala', 'royal-addons-for-elementor'),
			'vbnet' => __('Vbnet', 'royal-addons-for-elementor'),
			'velocity' => __('Velocity', 'royal-addons-for-elementor'),
			'verilog' => __('Verilog', 'royal-addons-for-elementor'),
			'vhdl' => __('Vhdl', 'royal-addons-for-elementor'),
			'vim' => __('Vim', 'royal-addons-for-elementor'),
			'visual-basic' => __('Visual-basic', 'royal-addons-for-elementor'),
			'wasm' => __('Wasm', 'royal-addons-for-elementor'),
			'wiki' => __('Wiki', 'royal-addons-for-elementor'),
			'xeora' => __('Xeora', 'royal-addons-for-elementor'),
			'xojo' => __('Xojo', 'royal-addons-for-elementor'),
			'xquery' => __('Xquery', 'royal-addons-for-elementor'),
			'yaml' => __('Yaml', 'royal-addons-for-elementor'),
		];
	}

    public function get_categories() {
        return [ 'royaltech' ];
    }

	protected function register_controls() {
		$this->source_code_content_controls();
		$this->custom_color_content_controls();
		$this->register_style_controls();
	}

	protected function source_code_content_controls() {

		$this->start_controls_section(
			'_section_source_code',
			[
				'label' => __('Source Code', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'lng_type',
			[
				'label' => __('Language Type', 'royal-addons-for-elementor'),
				'label_block' => true,
				'type' => Controls_Manager::SELECT,
				'default' => 'markup',
				'options' => $this->lng_type(),
			]
		);

		$this->add_control(
			'theme',
			[
				'label' => __('Theme', 'royal-addons-for-elementor'),
				'label_block' => true,
				'type' => Controls_Manager::SELECT,
				'default' => 'prism',
				'options' => [
					'prism' => __('Default', 'royal-addons-for-elementor'),
					'prism-coy' => __('Coy', 'royal-addons-for-elementor'),
					'prism-dark' => __('Dark', 'royal-addons-for-elementor'),
					'prism-funky' => __('Funky', 'royal-addons-for-elementor'),
					'prism-okaidia' => __('Okaidia', 'royal-addons-for-elementor'),
					'prism-solarizedlight' => __('Solarized light', 'royal-addons-for-elementor'),
					'prism-tomorrow' => __('Tomorrow', 'royal-addons-for-elementor'),
					'prism-twilight' => __('Twilight', 'royal-addons-for-elementor'),
					'custom' => __('Custom Color', 'royal-addons-for-elementor'),
				],
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'source_code',
			[
				'label' => __('Source Code', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::CODE,
				'rows' => 20,
				'default' => '<p class="random-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>',
				'placeholder' => __('Source Code....', 'royal-addons-for-elementor'),
				'condition' => [
					'lng_type!' => '',
				],
			]
		);
		$this->add_control(
			'copy_btn_text_show',
			[
				'label' => __('Copy Button Text Show?', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
                'style_transfer' => true,
			]
		);
		$this->add_control(
			'copy_btn_text',
			[
				'label' => __('Copy Button Text', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'rows' => 10,
				'default' => __('Copy to clipboard', 'royal-addons-for-elementor'),
				'placeholder' => __('Copy Button Text', 'royal-addons-for-elementor'),
				'condition' => [
					'copy_btn_text_show' => 'yes',
				],
			]
		);
		$this->add_control(
			'after_copy_btn_text',
			[
				'label' => __('After Copy Button Text', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'rows' => 10,
				'default' => __('Copied', 'royal-addons-for-elementor'),
				'placeholder' => __('Copied', 'royal-addons-for-elementor'),
				'condition' => [
					'copy_btn_text_show' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function custom_color_content_controls() {

		$this->start_controls_section(
			'_section_source_code_custom_color',
			[
				'label' => __('Custom Color', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'theme' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_background',
			[
				'label' => __( 'Background Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom :not(pre) > code[class*="language-"],{{WRAPPER}} .custom pre[class*="language-"]' => 'background: {{VALUE}}',
				],
				'condition' => [
					'theme' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_text_color',
			[
				'label' => __( 'Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom code[class*="language-"],{{WRAPPER}} .custom pre[class*="language-"]' => 'color: {{VALUE}}',
				],
				'condition' => [
					'theme' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_text_shadow_color',
			[
				'label' => __( 'Text shadow Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom code[class*="language-"],{{WRAPPER}} .custom pre[class*="language-"]' => 'text-shadow: 0 1px {{VALUE}}',
				],
				'condition' => [
					'theme' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_slate_gray',
			[
				'label' => __( 'Slate Gray Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom .token.comment,{{WRAPPER}} .custom .token.prolog,{{WRAPPER}} .custom .token.doctype,{{WRAPPER}} .custom .token.cdata' => 'color: {{VALUE}}',
				],
				'condition' => [
					'theme' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_dusty_gray',
			[
				'label' => __( 'Dusty Gray Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom .token.punctuation' => 'color: {{VALUE}}',
				],
				'condition' => [
					'theme' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_fresh_eggplant',
			[
				'label' => __( 'Fresh Eggplant Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom .token.property,{{WRAPPER}} .custom .token.tag,{{WRAPPER}} .custom .token.boolean,{{WRAPPER}} .custom .token.number,{{WRAPPER}} .custom .token.constant,{{WRAPPER}} .custom .token.symbol,{{WRAPPER}} .custom .token.deleted' => 'color: {{VALUE}}',
				],
				'condition' => [
					'theme' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_limeade',
			[
				'label' => __( 'Limeade Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom .token.selector,{{WRAPPER}} .custom .token.attr-name,{{WRAPPER}} .custom .token.string,{{WRAPPER}} .custom .token.char,{{WRAPPER}} .custom .token.builtin,{{WRAPPER}} .custom .token.inserted' => 'color: {{VALUE}}',
				],
				'condition' => [
					'theme' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_sepia_skin',
			[
				'label' => __( 'Sepia Skin Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom .token.operator,{{WRAPPER}} .custom .token.entity,{{WRAPPER}} .custom .token.url,{{WRAPPER}} .custom .language-css .token.string,{{WRAPPER}} .custom .style .token.string' => 'color: {{VALUE}}',
				],
				'condition' => [
					'theme' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_xanadu',
			[
				'label' => __( 'Xanadu Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom .token.operator,{{WRAPPER}} .custom .token.entity,{{WRAPPER}} .custom .token.url,{{WRAPPER}} .custom .language-css .token.string,{{WRAPPER}} .custom .style .token.string' => 'background: {{VALUE}}',
				],
				'condition' => [
					'theme' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_deep_cerulean',
			[
				'label' => __( 'Deep Cerulean Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom .token.atrule,{{WRAPPER}} .custom .token.attr-value,{{WRAPPER}} .custom .token.keyword' => 'color: {{VALUE}}',
				],
				'condition' => [
					'theme' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_cabaret',
			[
				'label' => __( 'Cabaret Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom .token.function,{{WRAPPER}} .custom .token.class-name' => 'color: {{VALUE}}',
				],
				'condition' => [
					'theme' => 'custom',
				],
			]
		);
		$this->add_control(
			'custom_tangerine',
			[
				'label' => __( 'Tangerine Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .custom .token.regex,{{WRAPPER}} .custom .token.important,{{WRAPPER}} .custom .token.variable' => 'color: {{VALUE}}',
				],
				'condition' => [
					'theme' => 'custom',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
     * Register widget style controls
     */
	protected function register_style_controls() {

		$this->start_controls_section(
			'_section_source_code_style',
			[
				'label' => __('Style', 'royal-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'source_code_box_height',
			[
				'label' => __('Height', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .royal-source-code pre' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'label' => __('Box Border', 'royal-addons-for-elementor'),
				'selector' => '{{WRAPPER}}  .royal-source-code pre[class*="language-"]',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'box_border_radius',
			[
				'label' => __('Border Radius', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-source-code pre[class*="language-"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'source_code_box_padding',
			[
				'label' => __('Padding', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-source-code pre' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'source_code_box_margin',
			[
				'label' => __('Margin', 'royal-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .royal-source-code pre' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'copy_btn_color',
			[
				'label' => __( 'Copy Button Text Color', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-copy-code-button' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
				'condition' => [
					'copy_btn_text_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'copy_btn_bg',
			[
				'label' => __( 'Copy Button Background', 'royal-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .royal-copy-code-button' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'copy_btn_text_show' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$source_code = $settings['source_code'];
		$theme = !empty($settings['theme']) ? $settings['theme'] : 'prism';
		$this->add_render_attribute('ha-code-wrap', 'class', 'royal-source-code');
		$this->add_render_attribute('ha-code-wrap', 'class', $theme);
		$this->add_render_attribute('ha-code-wrap', 'data-lng-type', $settings['lng_type']);
		if ('yes' == $settings['copy_btn_text_show'] && $settings['after_copy_btn_text']) {
			$this->add_render_attribute('ha-code-wrap', 'data-after-copy', $settings['after_copy_btn_text']);
		}
		$this->add_render_attribute('ha-code', 'class', 'language-' . $settings['lng_type']);
		?>
		<?php if (!empty($source_code)): ?>
			<div <?php $this->print_render_attribute_string('ha-code-wrap'); ?>>
			<pre>
			<?php if ('yes' == $settings['copy_btn_text_show'] && $settings['copy_btn_text']): ?>
				<button class="royal-copy-code-button"><?php echo esc_html($settings['copy_btn_text']) ?></button>
			<?php endif; ?>
				<code <?php $this->print_render_attribute_string('ha-code'); ?>>
					<?php echo esc_html($source_code); ?>
				</code>
			</pre>
			</div>
		<?php endif; ?>
		<?php

	}

	public function content_template() {
		?>
		<#
		var source_code = settings.source_code;
		view.addRenderAttribute( 'ha-code-wrap', 'class', 'royal-source-code');
		view.addRenderAttribute( 'ha-code-wrap', 'class', settings.theme);
		view.addRenderAttribute( 'ha-code-wrap', 'data-lng-type', settings.lng_type);
		if('yes' == settings.copy_btn_text_show && settings.after_copy_btn_text){
		view.addRenderAttribute( 'ha-code-wrap', 'data-after-copy', settings.after_copy_btn_text);
		}
		view.addRenderAttribute( 'ha-code', 'class', 'language-'+settings.lng_type);

		#>
		<# if( source_code ){ #>
		<div {{{ view.getRenderAttributeString( 'ha-code-wrap' ) }}}>
		<pre>
			<# if( 'yes' == settings.copy_btn_text_show && settings.copy_btn_text ){ #>
				<button class="royal-copy-code-button">{{{settings.copy_btn_text}}}</button>
			<# } #>
				<code {{{ view.getRenderAttributeString( 'ha-code' ) }}}>{{ source_code }}</code>
			</pre>
		</div>
		<# } #>

		<?php
	}

}
