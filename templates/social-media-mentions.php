<div class="wp-block-wceu2018-mentions">
	<ol>
		<?php foreach( $this->feed_entries as $entry ) { ?>
			<li><?= $entry->get_content() ?></li>
		<?php } ?>
	</ol>
</div>
