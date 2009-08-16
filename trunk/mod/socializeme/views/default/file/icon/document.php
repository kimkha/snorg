<?php

	if ($vars['size'] == 'large') {
		$ext = '_lrg';
	} else {
		$ext = '';
	}
	echo "<img src=\"{$CONFIG->wwwroot}mod/socializeme/graphics/file_icons/text{$ext}.gif\" border=\"0\" />";

?>