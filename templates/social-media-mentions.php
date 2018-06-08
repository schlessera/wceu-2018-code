<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop;

/*
 * View template that lets us render our custom Gutenberg block HTML.
 */

?><div class="wp-block-wceu2018-mentions">
	<?php foreach( $this->feed_entries as /** @var SocialNetwork\FeedEntry $entry */ $entry ) { ?>
		<div class="media">
			<img src="<?= $entry->get_avatar_image_url() ?>" class="media--img">
			<div class="media--bd">
				<p class="media--header"><span class="author-name"><?= $entry->get_author_name() ?></span> <span class="author-slug"><?= $entry->get_author_slug() ?></span> &middot; <span class="time"><?= $this->date_formatter->format( $entry->get_posted_time() ) ?></span></p>
				<p class="media--content"><?= $entry->get_content() ?></p>
			</div>
		</div>
	<?php } ?>
</div>
