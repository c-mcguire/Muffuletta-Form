<?php
/*
Plugin Name: Muffuletta Form
Plugin URI: http://new-volume.com
Description: A contact form for the Muffuletta theme
Author: chris@new-volume.com
Version: 1.0
*/
// Block direct requests
// This prevents somebody from opening the URL directly to the widget itself
if ( !defined('ABSPATH') )
	die('-1');

// Register the widget
// See Codex https://codex.wordpress.org/Function_Reference/register_widget
// Takes a class as a parameter
add_action( 'widgets_init', function(){
     register_widget( 'Muffuletta_Form' );
});
/**
 * Adds My_Widget widget.
 */
	// Codex: https://developer.wordpress.org/reference/classes/wp_widget/
class Muffuletta_Form extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	// Class constructor
	function __construct() {
		parent::__construct(
			'Muffuletta_Form', // Base ID
			__('Muffuletta Form', 'text_domain'), // Name
			array( 'description' => __( 'A contact form for the Muffuletta theme', 'text_domain' ), ) // Args
		);
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		// add style
		wp_enqueue_style('style', '/wp-content/plugins/muffuletta-form/css/style.css');
		// Codex: https://codex.wordpress.org/Widgets_API#Example
     	echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		// Display the form based on which form is selected
		if( $instance['form-type'] == "contact-form") {
			echo "<form class='muffuletta-form' action=''>
			<label for='firstNameInput'>First Name</label>
			<input class='text-input' type='text' name='firstNameInput' max-length='50'/>
			<label for='lastNameInput'>Last Name</label>
			<input class='text-input' type='text' name='lastNameInput' max-length='50'/>
			<label for='emailInput'>Email</label>
			<input class='text-input' type='text' name='emailInput' max-length='50'/>
			<label for='messageInput'>Message</label>
			<textarea class='textarea-input' name='messageInput' rows='4' cols='50'></textarea>
			<input id='submit-input' type='submit' name='send' value='Send' />
			</form>";
		}elseif ($instance['form-type'] == "reservation-form")  {
			echo "<form class='muffuletta-form' action=''>
			<label for='firstNameInput'>First Name</label>
			<input class='text-input' type='text' name='firstNameInput' max-length='50'/>
			<label for='lastNameInput'>Last Name</label>
			<input class='text-input' type='text' name='lastNameInput' max-length='50'/>
			<label for='emailInput'>Email</label>
			<input class='text-input' type='text' name='emailInput' max-length='50'/>
			<label for='phoneInput'>Phone Number</label>
			<input class='text-input' type='text' name='phoneInput' max-length='50'/>
			<label for='dateInput'>Reservation Date</label>
			<input class='text-input' type='text' name='dateInput' max-length='50'/>
			<label for='timeInput'>Reservation Time</label>
			<input class='text-input' type='text' name='timeInput' max-length='50'/>
			<label for='partyNumberInput'>How many people?</label>
			<select name='partyNumberInput'>
				<option value='2'>
				2
				</option>
				<option value='3'>
				3
				</option>
				<option value='4'>
				4
				</option>
				<option value='5'>
				5
				</option>
			</select>
			<input id='submit-input' type='submit' name='send' value='Make Reservation' />
			</form>";
		}elseif ($instance['form-type'] == "booking-form")  {
			echo "<form class='muffuletta-form' action=''>
			<label for='bandNameInput'>Band Name</label>
			<input class='text-input' type='text' name='bandNameInput' max-length='50'/>
			<label for='emailInput'>Email</label>
			<input class='text-input' type='text' name='emailInput' max-length='50'/>
			<label for='phoneInput'>Phone Number</label>
			<input class='text-input' type='text' name='phoneInput' max-length='50'/>
			<label for='dateInput'>Dates Available</label>
			<input class='text-input' type='text' name='dateInput' max-length='50'/>
			<input id='submit-input' type='submit' name='send' value='Request Booking' />
			</form>";
		}
		echo $args['after_widget'];

		//admin
		// function muffuletta_admin_init() {
		// 	echo 'hello';
		// 	wp_register_style('admin-style', '/wp-content/plugins/muffuletta-form/css/admin.css');
		// 	add_action('admin_print_styles', 'muffuletta_admin_style');
		// 	function muffuletta_admin_style(){
		// 		wp_enqueue_style('admin-style');
		// 	}
		// }
		// add_action('admin_init', 'muffuletta_admin_init');
		//
		}
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<?php
		if ( isset( $instance[ 'form-type' ] ) ) {
		    $type = $instance[ 'form-type' ];
		}
		else {
		    $type = __( 'Form Type', 'text_domain' );
		}
		?>
		<p>
		    <label for="<?php echo $this->get_field_id( 'form-type' ); ?>"><?php _e( 'Choose a form:' ); ?></label>
		    <select class="widefat" id="<?php echo $this->get_field_id( 'form-type' ); ?>" name="<?php echo $this->get_field_name( 'form-type' ); ?>">
		        <option value="<?php echo esc_attr('contact-form'); ?>">
		            Contact Form
		        </option>
		        <option value="<?php echo esc_attr('reservation-form'); ?>">
		            Reservation Form
		        </option>
		        <option value="<?php echo esc_attr('booking-form'); ?>">
		            Booking Form
		        </option>
		    </select>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance[ 'form-type' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'form-type' ); ?>" name="<?php echo $this->get_field_name( 'form-type' ); ?>" />
	        <label for="<?php echo $this->get_field_id( 'form-type' ); ?>">Contact Form</label>
		</p>

		<?php
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance[ 'form-type' ] = strip_tags( $new_instance[ 'form-type' ] );
		return $instance;
	}
} // class My_Widget
