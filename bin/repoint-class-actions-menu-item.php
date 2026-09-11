<?php
/**
 * Repoints the "Class Actions" main-menu item at the live pillar.
 *
 * The site-health crawl of production on 2026-09-10 reported
 * /class-action-lawyers/ and all 14 of its children as having no click path
 * from / -- 15 unreachable URLs -- and, separately, a sitewide internal link
 * taking a redirect hop:
 *
 *   internal link: 1-hop redirect  /class-actions/ -> /class-action-lawyers/
 *
 * Those are the same defect. Main Menu item 2327 ("Class Actions") is a
 * post_type item bound to page 2324 ("Mass Torts & Class Actions", slug
 * class-actions). Page 2324 is still published, so the menu renders its
 * permalink /class-actions/ -- which roden_old_page_redirects() 301s to
 * /class-action-lawyers/. A crawler does not count a redirect as a click path,
 * so the section looked unreachable even though every page linked to it.
 *
 * The report named only two blog posts as the source because crawl.mjs
 * truncates its "linked from" list to the first two entries; the link is in the
 * header nav and therefore on all 1230 crawled pages. There is no stale href in
 * post_content, post_excerpt, _roden_key_takeaways or _roden_faqs -- a
 * read-only sweep of all four surfaces across 1259 published items found zero.
 *
 * roden_fix_dead_nav_links() already rewrites the rendered URL, so the site is
 * correct as soon as the theme deploys and this script is NOT required. It
 * fixes the underlying menu item so that filter branch can be deleted.
 *
 * This rebinds the menu item rather than editing a URL: the item stays a
 * post_type item, so WordPress keeps generating the permalink and the link
 * cannot go stale again if the pillar's slug changes.
 *
 * Page 2324 is deliberately left published and redirecting. Unpublishing it
 * would turn /class-actions/ into a 404 for every external inbound link.
 *
 * Run:  ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file -" \
 *         < bin/repoint-class-actions-menu-item.php
 *       (append ` apply` to write; default is a dry run that changes nothing)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

$ITEM     = 2327;                     // Main Menu -> "Class Actions"
$OLD_PAGE = 2324;                     // Mass Torts & Class Actions (/class-actions/)
$NEW_SLUG = 'class-action-lawyers';   // the live pillar

/* ---------- verify everything before touching anything ---------- */

$item = get_post( $ITEM );
if ( ! $item || 'nav_menu_item' !== $item->post_type ) {
	echo "ABORTING — menu item $ITEM is missing or not a nav_menu_item\n";
	return;
}

$bound = (int) get_post_meta( $ITEM, '_menu_item_object_id', true );
$type  = get_post_meta( $ITEM, '_menu_item_type', true );

if ( 'post_type' !== $type ) {
	echo "ABORTING — menu item $ITEM is a '$type' item, not 'post_type'; repoint it in Appearance → Menus\n";
	return;
}

if ( $bound !== $OLD_PAGE ) {
	echo "NOTHING TO DO — menu item $ITEM is bound to $bound, not $OLD_PAGE (already repointed?)\n";
	return;
}

$target = get_page_by_path( $NEW_SLUG );
if ( ! $target || 'publish' !== $target->post_status ) {
	echo "ABORTING — /$NEW_SLUG/ is missing or not published\n";
	return;
}

$dest = wp_make_link_relative( get_permalink( $target->ID ) );
if ( '/' . $NEW_SLUG . '/' !== $dest ) {
	echo "ABORTING — expected /$NEW_SLUG/ but the pillar resolves to $dest\n";
	return;
}

printf( "menu item %d (%s)\n", $ITEM, $item->post_title );
printf( "  from: page %d  %s\n", $OLD_PAGE, wp_make_link_relative( get_permalink( $OLD_PAGE ) ) );
printf( "  to:   page %d  %s\n", $target->ID, $dest );

if ( ! $APPLY ) {
	echo "\n--- dry run (nothing written) ---\n";
	echo "to apply, re-run with: ... eval-file - apply\n";
	echo "\n--- backup ---\n";
	echo wp_json_encode(
		array( 'menu_item' => $ITEM, 'meta_key' => '_menu_item_object_id', 'before' => $bound ),
		JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
	) . "\n";
	return;
}

/*
 * An integer id, so there is no backslash to lose here -- but update_post_meta()
 * does call wp_unslash() on what it is given, and every write in bin/ goes
 * through wp_slash() so that the habit never has an exception to hide in.
 */
update_post_meta( $ITEM, '_menu_item_object_id', wp_slash( (string) $target->ID ) );

wp_cache_flush();

$now = (int) get_post_meta( $ITEM, '_menu_item_object_id', true );
printf( "\n--- applied ---\nmenu item %d now bound to page %d (%s)\n", $ITEM, $now, $now === $target->ID ? 'OK' : 'MISMATCH' );
echo "\nNow flush the page cache:  wp cache flush && wp page-cache flush\n";
echo "Then the /class-actions/ branch of roden_fix_dead_nav_links() can be removed.\n";
