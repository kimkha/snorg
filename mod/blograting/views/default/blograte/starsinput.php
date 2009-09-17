<?php
?>


<script type="text/javascript">
$(document).ready(function() {
	<?php
		$needle = '-'.get_loggedin_userid().'-';
		$tmp = strpos($vars['entity']->rateusers,$needle);
		$rateaverage;
		print_r($vars['entity']->rateusers);
		if ($tmp === false){
			$disable = 'false';
		} else {
			$disable = 'true';
		}
		
		if (!$vars['entity']->rateaverage){
			$rateaverage = 0;
		} else {
			$rateaverage = $vars['entity']->rateaverage;
		}
	?>                                                                                                          
	$('#starsinput<?php echo $vars['entity']->guid?>').rating('<?php echo $vars['url'] ?>action/blograting/rate', {maxvalue:5,increment:.5,curvalue: <?php echo $rateaverage ?>, disable: <?php echo $disable ?>, user: <?php echo $vars['user']->guid ?>, entity: <?php echo $vars['entity']->guid?>});

	
});

</script>


<div id="starsinput<?php echo $vars['entity']->guid?>" class="rating">&nbsp; </div>
<div id="ratepoint<?php echo $vars['entity']->guid?>"> +  
<?php
	if (!$vars['entity']->ratetotal)
		echo ' 0';
	else  
		echo ' '.$vars['entity']->ratetotal . ' ' . substr($vars['entity']->rateaverage,0,3) ;
?> 

</div>


 