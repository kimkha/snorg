
<script type="text/javascript" src="<?= $vars['url'] ?>vendors/taguser/jquery.quicksearch.js"></script>
 
<script type="text/javascript">

	
	var user_id = 0;


	// add to DOM as soon as ready
	$(document).ready(function () {
			$('ul#tidypics_phototag_list li').quicksearch({
				position: 'before',
				attached: 'ul#tidypics_phototag_list',
				loaderText: '',
				inputClass: 'input-filter',
				labelText: "<p><?php echo elgg_echo('tidypics:tagthisphoto'); ?></p>",
				delay: 100
			});

			$('#quicksearch').submit( function () { addTag() } );
		}
	);



	// get tags over image ready for mouseover
	// based on code by Tarique Sani <tarique@sanisoft.com> - MIT and GPL licenses


	function selectUser(id, name) 
	{
		user_id = id;
		$("input.input-filter").val(name);
	}

	function addTag()
	{
		// do I need a catch for no tag?

		$("input#user_id").val(user_id);
			$("input#coordinates").val(coord_string);

		//Show loading
		//$("#tag_menu").replaceWith('<div align="center" class="ajax_loader"></div>');
	}


</script>