<?php
$workout = App\Workout::find($id);
$display_time = "";
$workout_type_image = "";

$workout_type = $workout->workout_type;
if( isset( $workout->duration_goal ) )
{
	$display_time = $workout->duration_goal;
}
if( isset( $workout->duration_actual ) )
{
	$display_time = $workout->duration_actual;
}
$scheduled = "";
if( !isset( $workout->recorded ) )
{
	$scheduled = " scheduled";
}
if( isset( $workout_type) )
{
	$workout_type_image = $workout_type->image;
}

?>
<div class="workout_container <?php echo $workout_type->color . " " . $scheduled; ?>">
	<div class="workout_image"><img src="<?php echo $workout_type_image; ?>" class="<?php echo $workout_type->color; ?>"></img></div>
	<div class="workout_content">
		<div class="workout_title"><?php echo $workout->title; ?></div>
		<div class="workout_duration"><?php echo "(" . $display_time . ")"; ?></div>
	</div>
	<div style="clear:both"></div>
</div>