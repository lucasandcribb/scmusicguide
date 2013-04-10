<?php

	function hello_admin_menu() 
	{
		add_theme_page("Hello tabs", "Hello tabs", 'edit_themes', basename(__FILE__), 'hello_tabs_options_page');
	}

	add_action('admin_menu', 'hello_admin_menu');

	function hello_tabs_options_page(){

		if ( $_POST['hello_tabs_options_page_update'] == 'true' ) { hello_tabs_options_update(); }
		
		?>
		<div class="wrap">
			<div id="icon-themes" class="icon32"><br /></div>
			<h2>Hello tabs options</h2>
		
			<form method="POST" action="">
				<input type="hidden" name="hello_tabs_options_page_update" value="true" />
				
				<h4>Additional sidebars (each on new line)</h4>
				<textarea name="hello_additional_sidebars" cols="50" rows="10"><?php echo esc_textarea( get_option('hello_additional_sidebars'));?></textarea>
				
				<p><input type="submit" name="search" value="Update Options" class="button" /></p>
			</form>
		
		</div>
		<?php
	}

	function hello_tabs_options_update()
	{
		update_option('hello_additional_sidebars', 	$_POST['hello_additional_sidebars']);
		
	}

	$hello_additional_widgets=explode("\n",get_option('hello_additional_sidebars'));
	foreach($hello_additional_widgets  as  $value)
	{
		$value=trim($value);
		if  (!empty($value))
		{
			register_sidebar(array(
								'id' => $value,
								'name' => $value,
								'before_widget' => '<div class="">',
								'after_widget' => '</div>',
								'before_title' => '<h2>',
								'after_title' => '</h2>',
							));
		}
	}


?>