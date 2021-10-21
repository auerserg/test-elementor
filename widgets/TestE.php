<?php

namespace ElementorTestE\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TestE extends Widget_Base {
    public function __construct( $data = array(), $args = null ) {
        parent::__construct( $data, $args );

        wp_register_style( 'test-e', TEST_E_URL . '/assets/main.css', array(), '1.1.1' );
        wp_register_script( 'test-e-js', TEST_E_URL . '/assets/main.js', array(), '1.1.1' );
    }

    public function get_name() {
        return 'teste';
    }

    public function get_title() {
        return __( 'TestE', 'elementor-awesomesauce' );
    }

    public function get_icon() {
        return 'fa fa-pencil';
    }

    public function get_categories() {
        return array( 'general' );
    }

    public function get_style_depends() {
        return array( 'test-e' );
    }

    public function get_script_depends() {
        return array( 'test-e-js' );
    }


    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            array(
                'label' => __( 'Content', 'elementor-awesomesauce' ),
            )
        );

        $this->add_control(
            'title',
            array(
                'label'   => __( 'Title', 'elementor-awesomesauce' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Title', 'elementor-awesomesauce' ),
            )
        );

        $this->add_control(
            'description',
            array(
                'type'    => Controls_Manager::TEXTAREA,
                'label'   => __( 'Description', 'elementor-awesomesauce' ),
                'default' => __( 'Description', 'elementor-awesomesauce' ),
            )
        );

        $this->add_control(
            'content',
            array(
                'type'    => Controls_Manager::WYSIWYG,
                'label'   => __( 'Content', 'elementor-awesomesauce' ),
                'default' => __( 'Content', 'elementor-awesomesauce' ),
            )
        );
        $this->add_control(
            'text_align',
            array(
                'type'    => Controls_Manager::CHOOSE,
                'label'   => __( 'Alignment', 'elementor-awesomesauce' ),
                'options' => [
                    'left'   => [
                        'title' => __( 'Left', 'elementor-awesomesauce' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'elementor-awesomesauce' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'elementor-awesomesauce' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle'  => true,
			)
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes( 'title', 'none' );
        $this->add_inline_editing_attributes( 'description', 'basic' );
        $this->add_inline_editing_attributes( 'content', 'advanced' );
        ?>
		<h2 <?php echo $this->get_render_attribute_string( 'title' ); ?><?php echo wp_kses( $settings['title'], array() ); ?></h2>
		<div <?php echo $this->get_render_attribute_string( 'description' ); ?><?php echo wp_kses( $settings['description'], array() ); ?></div>
		<div <?php echo $this->get_render_attribute_string( 'content' ); ?><?php echo wp_kses( $settings['content'], array() ); ?></div>
        <?php
    }

    protected function _content_template() {
        ?>
		<#
		view.addInlineEditingAttributes( 'title', 'none' );
		view.addInlineEditingAttributes( 'description', 'basic' );
		view.addInlineEditingAttributes( 'content', 'advanced' );
		#>
		<h2 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h2>
		<div {{{ view.getRenderAttributeString( 'description' ) }}}>{{{ settings.description }}}</div>
		<div {{{ view.getRenderAttributeString( 'content' ) }}}>{{{ settings.content }}}</div>
        <?php
    }
}