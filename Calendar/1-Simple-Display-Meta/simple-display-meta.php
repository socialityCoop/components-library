//A. Show data as a box inside the post. Put in the relevant single template
<?php
$date = get_field('action_date');
if(!empty($date)):
	$unixtimestamp = strtotime( str_replace('/', '-',$date ));
	$day = date_i18n("l", $unixtimestamp);
	$day = substr($day,0,8);
	$sh ='<div class="action-item single-item"><label>'.__('Event Info').'</label><div class="date">';
	$sh .='<span class="day">'.$day.'.</span><span class="number">'.date_i18n( "d/m", $unixtimestamp ).'</span>'; 
	$sh .='</div><div class="info">';
	$sh .='<h4>'.get_field('action_title').'</h4>';
	if( have_rows('action_info') ):
		while( have_rows('action_info') ): the_row(); 
			$place = get_sub_field('place');
			$sh .= $place;
			$time = get_sub_field('time');
			if(!empty($time)){
				$sh .= ', <strong>'.$time.'</strong>';
			}
			$sh .='<br>';
		endwhile;
	endif;
	$sh .='</div></div>';
	echo $sh;
?>

//B. Display all upcoming events
<?php 
	function upcoming_events_function(){
		$today = date("Ymd");  
		$args  = array(
			'post_type'=>'post',
			'meta_query' => array(
				array(
					'key' => 'action_date',
					'value' => $today,
					'compare' => '>='
				),
			),	
			'orderby'=>'meta_value',
			'meta_key' => 'action_date',
			'order'=> 'ASC'
		);
		$actions = new WP_Query($args);
		if($actions->have_posts()): 
			$sh = '<div class="block"><h3>'.__('Next Events').'</h3></div>';
			while($actions->have_posts()) : $actions->the_post(); 
				$unixtimestamp = strtotime( str_replace('/', '-', get_field('action_date')));
				$day = date_i18n("l", $unixtimestamp);
				$day = substr($day,0,8);
				$sh .='<div class="action-item"><div class="date">';
				$sh .='<span class="day">'.$day.'.</span><span class="number">'.date_i18n( "d/m", $unixtimestamp ).'</span>'; 
				$sh .='</div><div class="info">';
				$sh .='<h4>'.get_field('action_title').'</h4>';
				if( have_rows('action_info') ):
					while( have_rows('action_info') ): the_row(); 
						$place = get_sub_field('place');
						$sh .= $place;
						$time = get_sub_field('time');
						if(!empty($time)){
							$sh .= ', <strong>'.$time.'</strong>';
						}
						$sh .='<br>';
					endwhile;
				endif;
				$sh .='<a href="'.get_the_permalink().'">'.__('More').'</a><br><br>';
				$sh .='</div></div>';
			endwhile ;
			return $sh;
			wp_reset_postdata();
		endif;
	}
add_shortcode( 'upcoming_events', 'upcoming_events_function' ); 
?>

//Relevant CSS
<style type="text/css">
		.action-item{
			font-size: 14px;
		}

		.action-item::after {
			content: "";
			clear: both;
			display: table;
		}

		.action-item .date{
			background: #ecebeb;
			padding: 10px;
			float: left;
			width: 20%;
			margin-right: 2%;
		}

		.action-item .info{
			float: left;
			width: 78%;
		}

		.action-item .date .day{
			width: 100%;
			display: block;
			text-align: center;
		} 

		.action-item .date .number{
			display: block;
			width: 100%;
			text-align: center;
			font-size: 19px;
			margin-top: 5px;x;
		}

		.action-item h4{
			font-size: 16px;
			float: left;
			width: 100%;
			margin-top: 0px;
			font-weight: bold;
			margin-bottom: 2px;
		}

		.action-item.single-item{
			max-width: 500px;
			background: #ecebeb;
			padding-top: 8px;
			padding-bottom: 8px;
			padding-right: 8px;
			margin-bottom: 15px;
		}
</style>