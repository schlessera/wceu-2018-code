<?php declare( strict_types=1 );

namespace WordCampEurope\Workshop\View;

/**
 * Context in which to escape the rendered view content.
 */
interface EscapeContext {
	const POST = PostEscapedView::class;
}
