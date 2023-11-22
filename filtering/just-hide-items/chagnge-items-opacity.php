/* This is some JS and CSS to filter already displayed items.
The idea is that we print all items and use JS to change their opacity when filtering. No ajax is used. Good if you don't have a lot of items
The items need to have a class that shows their category (in the example it is category-[TERMID]). This is usually aready there in WP.
Printed items is not part of the example. Just print them as you like but remember to put the class as mentioned. You can also use readymade theme elements.
*/


//Print the filter buttons
<div class="concepts-filter button-filters-container">
	<div class="button-filter f-all" data-term="all">All</div>
	<?php
	$terms = get_terms( array(
		'taxonomy'   => /* [Taxonomy Term Slug] */
		'hide_empty' => true,
	) );
	foreach ($terms as $term) : ?>
		<div class="button-filter f-<?php echo $term->term_id ?>" data-term="<?php echo $term->term_id ?>">
			<?php echo $term->name ; ?>
		</div>
	<?php endforeach; ?>
</div>

//Javascript. Can go into a seperate file
<script type="text/javascript">
	(function($) {

		//On click button filter
		$('.button-filter').click(function(){
			if(!$(this).hasClass('active-filter')){
				var term_id = $(this).data("term");
				$(this).siblings().removeClass('active-filter');
				$(this).addClass('active-filter');
				iif(dataterm == 'all'){
					$('.item').css({
						"opacity": "1",
						"-webkit-transition": "opacity 0.5s ease-in-out",
						"-moz-transition": "opacity 0.5s ease-in-out",
						"-ms-transition": "opacity 0.5s ease-in-out",
						"-o-transition": "opacity 0.5s ease-in-out",
						"transition": "opacity 0.5s ease-in-out",
					});
				} else {
					$('.item').css({
						"opacity": "0.3",
						"-webkit-transition": "opacity 0.5s ease-in-out",
						"-moz-transition": "opacity 0.5s ease-in-out",
						"-ms-transition": "opacity 0.5s ease-in-out",
						"-o-transition": "opacity 0.5s ease-in-out",
						"transition": "opacity 0.5s ease-in-out",
					});

					$('.item.category-'+term_id).css({
						"opacity": "1",
						"-webkit-transition": "opacity 0.5s ease-in-out",
						"-moz-transition": "opacity 0.5s ease-in-out",
						"-ms-transition": "opacity 0.5s ease-in-out",
						"-o-transition": "opacity 0.5s ease-in-out",
						"transition": "opacity 0.5s ease-in-out",
					});
				}
			} else {
				// If already an active filter, do nothing.
			}

		});

	})(jQuery);
</script>

//CSS should go to the relevant stylesheet
<style>
	.button-filter {
		margin-bottom: 10px;
		margin-top: 5px;
		background-color: #F5F5F5;
		color: #000;
		font-weight: bold;
		font-size: 16px;
		padding: 5px;
		cursor: pointer;
		margin-right: 25px;
		display: inline-block;
		padding-right: 30px;
		padding-left: 26px;
		border-radius: 60px;
	}
	.active-filter, .button-filter:hover {
		background-color: #000 !important;
		color: #fff !important;
	}
</style>