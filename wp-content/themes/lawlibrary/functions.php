<?php

if (function_exists('register_sidebars')) {
	register_sidebars(1, array(
		'before_widget' => '<!--- BEGIN Widget --->',
		'before_title' => '<!--- BEGIN WidgetTitle --->',
		'after_title' => '<!--- END WidgetTitle --->',
		'after_widget' => '<!--- END Widget --->'
	));
}

function art_normalize_widget_style_tokens($content) {
	$bw = '<!--- BEGIN Widget --->';
	$bwt = '<!--- BEGIN WidgetTitle --->';
	$ewt = '<!--- END WidgetTitle --->';
	$bwc = '<!--- BEGIN WidgetContent --->';
	$ewc = '<!--- END WidgetContent --->';
	$ew = '<!--- END Widget --->';
	$result = '';
	$startBlock = 0;
	$endBlock = 0;
	while (true) {
		$startBlock = strpos($content, $bw, $endBlock);
		if (false === $startBlock) {
			$result .= substr($content, $endBlock);
			break;
		}
		$result .= substr($content, $endBlock, $startBlock - $endBlock);
		$endBlock = strpos($content, $ew, $startBlock);
		if (false === $endBlock) {
			$result .= substr($content, $endBlock);
			break;
		}
		$endBlock += strlen($ew);
		$widgetContent = substr($content, $startBlock, $endBlock - $startBlock);
		$beginTitlePos = strpos($widgetContent, $bwt);
		$endTitlePos = strpos($widgetContent, $ewt);
		if ((false == $beginTitlePos) xor (false == $endTitlePos)) {
			$widgetContent = str_replace($bwt, '', $widgetContent);
			$widgetContent = str_replace($ewt, '', $widgetContent);
		} else {
			$beginTitleText = $beginTitlePos + strlen($bwt);
			$titleContent = substr($widgetContent, $beginTitleText, $endTitlePos - $beginTitleText);
			if ('&nbsp;' == $titleContent) {
				$widgetContent = substr($widgetContent, 0, $beginTitlePos)
					. substr($widgetContent, $endTitlePos + strlen($ewt));
			}
		}
		if (false === strpos($widgetContent, $bwt)) {
			$widgetContent = str_replace($bw, $bw . $bwc, $widgetContent);
		} else {
			$widgetContent = str_replace($ewt, $ewt . $bwc, $widgetContent);
		}
		$result .= str_replace($ew, $ewc . $ew, $widgetContent);
	}
	return $result;
}

function art_sidebar($index = 1)
{
	if (!function_exists('dynamic_sidebar')) return false;
	ob_start();
	$success = dynamic_sidebar($index);
	$content = ob_get_clean();
	if (!$success) return false;
	$content = art_normalize_widget_style_tokens($content);
	$replaces = array(
		'<!--- BEGIN Widget --->' => "\r\n<div class=\"Block\">\r\n  <div class=\"Block-body\">\r\n",
		'<!--- BEGIN WidgetTitle --->' => "<div class=\"BlockHeader\">\r\n",
		'<!--- END WidgetTitle --->' => "\r\n  <div class=\"l\"></div>\r\n  <div class=\"r\"><div></div></div>\r\n</div>\r\n",
		'<!--- BEGIN WidgetContent --->' => "\r\n<div class=\"BlockContent\">\r\n  <div class=\"BlockContent-body\">\r\n",
		'<!--- END WidgetContent --->' => "\r\n  </div>\r\n</div>\r\n",
		'<!--- END Widget --->' => "\r\n  </div>\r\n</div>\r\n"
	);
	$bwt = '<!--- BEGIN WidgetTitle --->';
	$ewt = '<!--- END WidgetTitle --->';
	if ('' == $replaces[bwt] && '' == $replaces[$ewt]) {
		$startTitle = 0;
		$endTitle = 0;
		$result = '';
		while (true) {
			$startTitle = strpos($content, $bwt, $endTitle);
			if (false == $startTitle) {
				$result .= substr($content, $endTitle);
				break;
			}
			$result .= substr($content, $endTitle, $startTitle - $endTitle);
			$endTitle = strpos($content, $ewt, $startTitle);
			if (false == $endTitle) {
				$result .= substr($content, $startTitle);
				break;
			}
			$endTitle += strlen($ewt);
		}
		$content = $result;
	}
	$content = str_replace(array_keys($replaces), array_values($replaces), $content);
	echo $content;
	return true;
}

function art_list_pages_filter($output)
{
	$output = preg_replace('~<li([^>]*)><a([^>]*)>([^<]*)</a>~',
		'<li$1><a$2><span><span>$3</span></span></a>',
		$output);
	$re = '~<li class="([^"]*)(?: current_page_(?:ancestor|item|parent))+([^"]*)"><a ~';
	$output = preg_replace($re, '<li class="$1$2"><a class="active" ', $output, 1);
	$output = preg_replace($re, '<li class="$1$2"><a ', $output);
	return $output;
}

function art_header_page_list_filter($pages)
{
	$result = array();
	if ($GLOBALS['menu_showSubmenus']) {
		foreach ($pages as $page)
			$result[] = $page;
	} else {
		foreach ($pages as $page)
			if (0 == $page->post_parent)
				$result[] = $page;
	}
	if ('page' == get_option('show_on_front')) {
		$pageOnFront = get_option('page_on_front');
		$pageForPosts = get_option('page_for_posts');
		if ($pageOnFront) {
			foreach ($result as $key => $page) {
				if (0 == $page->post_parent && $pageOnFront == $page->ID) {
					unset($result[$key]);
					break;
				}
			}
		}
		if (!$pageOnFront && $pageForPosts) {
			foreach ($result as $key => $page) {
				if (0 == $page->post_parent && $pageForPosts == $page->ID) {
					unset($result[$key]);
					break;
				}
			}
		}
	}
	return $result;
}

function art_menu_items($showSubmenus)
{
	$GLOBALS['menu_showSubmenus'] = $showSubmenus;
	$homeMenuItemCaption = 'Home';
	$isHomeSelected = null;
	if ('page' == get_option('show_on_front')) {
		$pageOnFront = get_option('page_on_front');
		$pageForPosts = get_option('page_for_posts');
		if ($pageOnFront) {
			$page = & get_post($pageOnFront);
			if (null != $page)
				$homeMenuItemCaption = $page->post_title;
			$isHomeSelected = is_page($page->ID);
		} elseif (!$pageOnFront && $pageForPosts) {
			$page = & get_post($pageForPosts);
			if (null != $page)
				$homeMenuItemCaption = $page->post_title;
		}
	}
	if (null === $isHomeSelected)
		$isHomeSelected = is_home();

	echo '<li><a' . ($isHomeSelected ? ' class="active"' : '') . ' href="' . get_option('home') . '"><span><span>'
		. $homeMenuItemCaption . '</span></span></a></li>';
	add_action('get_pages', 'art_header_page_list_filter');
	add_action('wp_list_pages', 'art_list_pages_filter');
	wp_list_pages('title_li=');
	remove_action('wp_list_pages', 'art_list_pages_filter');
	remove_action('get_pages', 'art_header_page_list_filter');
}
