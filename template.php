<?php
/*
Plugin Name: My Character
Plugin URI:  
Description: A Wordpress plug-in assignment for Plexchat
Version:     1
Author:      Cooltey.org
Author URI:  https://cooltey.org
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

My Character is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
My Character is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// get wordpress header
get_header();

if(have_posts()) : 
?>

<link rel='stylesheet' href='<?php echo $getCharacter->character_css() ?>' type='text/css'/>

<div class="my-character-block">
	<div class="my-character-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="my-character-header">
				<h1><?php the_field('name'); ?></h1>
				<small><i> the <?php echo ucwords(get_field('class'));; ?></i></small>
				<img src="<?php the_field('avatar'); ?>" class="my-character-avatar">
			</div>
			<p><?php the_field('intro'); ?></p>
			<!-- Display Stats -->
			<fieldset><legend>Stats</legend>
				<div class="my-character-table">
					<table border="0">
						<tr>
							<td class="my-character-td-title">Level</td>
							<td class="my-character-td-value"><?php the_field('level'); ?></td>
							<td class="my-character-td-title">Class</td>
							<td class="my-character-td-value"><?php echo ucwords(get_field('class')); ?></td>
						</tr>
						<tr>
							<td class="my-character-td-title">HP</td>
							<td class="my-character-td-value"><?php echo $getCharacter->getHP(get_field('class'), get_field('level')); ?></td>
							<td class="my-character-td-title">MP</td>
							<td class="my-character-td-value"><?php echo $getCharacter->getMP(get_field('class'), get_field('level')); ?></td>
						</tr>
						<tr>
							<td class="my-character-td-title">Speed</td>
							<td class="my-character-td-value"><?php echo $getCharacter->getSpeed(get_field('class'), get_field('level')); ?></td>
							<td class="my-character-td-title">Luck</td>
							<td class="my-character-td-value"><?php echo $getCharacter->getLuck(get_field('class'), get_field('level')); ?></td>
						</tr>
					</table>
				</div>
			</fieldset>
			
		<?php endwhile; // end of the loop. ?>
	</div>
</div>


<?php
endif;
// get wordpress footer
get_footer();

?>