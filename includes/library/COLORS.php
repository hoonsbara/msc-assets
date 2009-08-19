<?php
/**
 * includes/library/COLORS.php
 * 
 * Contains a variety of functions used to calculate, validate, or adjust
 * hex color values.
 * 
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @package MSC Assets
 * @todo clean this up into a class
 * 
 */
defined('_MSC') or die('Unauthorized');
$debug->log("Color library initiating...");

/**
 * take a color as close to white as possible while maintaining hue (reasonably)
 * @return string containing the whitened hex color
 * @param object $hex
 * @param object $min[optional]
 * @param object $max[optional]
 */
function color_whiten($hex, $min = 220, $max = 255)
{
	$hex = ltrim($hex, '#');
 // step 1... break it up into decimal rgb
	$rgb = array();
	$rgb['r'] = hexdec(substr($hex, 0, 2));
	$rgb['g'] = hexdec(substr($hex, 2, 2));
	$rgb['b'] = hexdec(substr($hex, 4, 2));

 // step 2... find the highest component
	$highest = array('component' => '', 'decimal' => 0);
	foreach ($rgb as $comp => $dec)
	{
		if ($dec > $highest['decimal'])
			$highest = array('component' => $comp, 'decimal' => $dec);
	}
 // send 'em white if we have black
	if ($highest['decimal'] == 0)
		return 'FFFFFF';

 // step 3...	find the others' proportions to the highest
	$props = array();
	foreach ($rgb as $comp => $dec)
	{
		if ($comp != $highest['component'])
			$props[$comp] = number_cleanup(percent($dec, $highest['decimal'], 0), '%');
	}

 // step 4... raise highest to max
	$rgb[$highest['component']] = $max;

 // step 5... calculate new proportional values for others
	$minbreak = false;
	foreach ($props as $comp => $prop)
	{
		$new = ceil(($max / 100) * $prop);
		$rgb[$comp] = $new;
		if ($new < $min)
			$minbreak = true;
	}
 // step 6, bump values to above minimum
	if ($minbreak)
	{
	 // find lowest
		$lowest = array('component' => '', 'decimal' => $max);
		foreach ($rgb as $comp => $dec)
		{
			if ($dec < $lowest['decimal'])
				$lowest = array('component'=>$comp, 'decimal' => $dec);
		}
	 // find the middle
		$middle = array('component' => '', 'decimal' => '');
		foreach ($rgb as $comp => $dec)
		{
			if ($comp != $highest['component'] && $comp != $lowest['component'])
			{
				$middle = array('component'=>$comp, 'decimal' => $dec);
			}
		}

	 // find proportion of middle to lowest
		if ($lowest['decimal'] == 0)
			$lowest['decimal'] = 1;
		$prop = number_cleanup(percent($middle['decimal'], $lowest['decimal'], 0), '%');

	 // set lowest to minimum
		$rgb[$lowest['component']] = $min;

	 // set middle proportional to lowest
		$rgb[$middle['component']] = max(min( ceil($middle['decimal'] * ($prop / 100)), $max), $min);
	}
//print_r($rgb);

 // rebuild hex value
	$hex = '';
	foreach ($rgb as $dec)
		$hex .= sprintf('%02s', dechex($dec));

	return strtoupper($hex);
}


/**
 * take a color as close to black as possible while maintaining hue (reasonably)
 * @return string containing blackened hex color
 * @param object $hex
 * @param object $min[optional]
 * @param object $max[optional]
 */
function color_blacken($hex, $min = 0, $max = 40)
{
	$hex = ltrim($hex, '#');
 // step 1... break it up into decimal rgb
	$rgb = array();
	$rgb['r'] = hexdec(substr($hex, 0, 2));
	$rgb['g'] = hexdec(substr($hex, 2, 2));
	$rgb['b'] = hexdec(substr($hex, 4, 2));

 // step 2... find the lowest component
	$lowest = array('component' => '', 'decimal' => 255);
	foreach ($rgb as $comp => $dec)
	{
		if ($dec < $lowest['decimal'])
			$lowest = array('component' => $comp, 'decimal' => $dec);
	}
 // send 'em black if we have white
	if ($lowest['decimal'] == 255)
		return '000000';

 // step 3...	find the others' proportions to the lowest
	$props = array();
	foreach ($rgb as $comp => $dec)
	{
		if ($comp != $lowest['component'])
			$props[$comp] = number_cleanup(percent($dec, $lowest['decimal'], 0), '%');
	}

 // step 4... lower lowest to min
	$rgb[$lowest['component']] = $min;


 // step 5... calculate new proportional values for others
	$minbreak = false;
	foreach ($props as $comp => $prop)
	{
		$new = ceil(($max / 100) * $prop);
		$rgb[$comp] = $new;
		if ($new > $max)
			$maxbreak = true;
	}
 // step 6, bump values to below maximum
	if ($maxbreak)
	{
	 // find highest
		$highest = array('component' => '', 'decimal' => $min);
		foreach ($rgb as $comp => $dec)
		{
			if ($dec > $lowest['decimal'])
				$highest = array('component'=>$comp, 'decimal' => $dec);
		}
	 // find the middle
		$middle = array('component' => '', 'decimal' => '');
		foreach ($rgb as $comp => $dec)
		{
			if ($comp != $highest['component'] && $comp != $lowest['component'])
			{
				$middle = array('component'=>$comp, 'decimal' => $dec);
			}
		}

	 // find proportion of middle to highest
		if ($highest['decimal'] == 0)
			$highest['decimal'] = 1;
		$prop = number_cleanup(percent($middle['decimal'], $highest['decimal'], 0), '%');

	 // set highest to maximum
		$rgb[$highest['component']] = $max;

	 // set middle proportional to highest
		$rgb[$middle['component']] = min(max( ceil($middle['decimal'] * ($prop / 100)), $min), $max);
	}
//print_r($rgb);

 // rebuild hex value
	$hex = '';
	foreach ($rgb as $dec)
		$hex .= sprintf('%02s', dechex($dec));

	return strtoupper($hex);
}


/**
 * formats a color string into standard hex format (CCFF00)
 * @return string in standard hex format
 * @param object $color
 */
function color_prepare($color)
{
	global $config;

 // put it in a standard format
	$color = strtoupper(trim($color));
	$color = ltrim($color, '#');

 // if it's a threefer
	if (preg_match('/^([0-9]|[A-F]){3}$/', $color))
	{
		$color = substr($color, 0, 1) . substr($color, 0, 1) .
						 substr($color, 1, 1) . substr($color, 1, 1) .
						 substr($color, 2, 1) . substr($color, 2, 1);
	}

 // ensure it's a real color
	if (!preg_match('/^([0-9]|[A-F]){6}$/', $color))
	{
		debug("Invalid color entered: ". $color);
		$color = 'CCCCCC';
	}

 // enforce websafe coloring
	if (!empty($config['enforce_websafe']))
	{
		$decs = array
		(
			'r' => hexdec( substr($color, 0, 2) ),
			'g' => hexdec( substr($color, 2, 2) ),
			'b' => hexdec( substr($color, 4, 2) )
		);

		$color = '';
		foreach ($decs as $dec)
		{
			$dec = (round($dec/51) * 51);
			$color .= str_pad(dechex($dec), 2, '0', STR_PAD_LEFT);
		}
	}

	return strtoupper($color);
}


/**
 * determines if a color is bright and should be treated with dark
 * @return bool
 * @param object $color
 * @param object $threshold[optional]
 */
function is_bright($color, $threshold = 128)
{
	$r = hexdec(substr($color,0,2));
	$g = hexdec(substr($color,2,2));
	$b = hexdec(substr($color,4,2));
	$brightness = ($r * 299 + $g * 587 + $b * 114) / 1000; // per # http://www.w3.org/TR/AERT#color-contrast
	if ($brightness > $threshold)
		return true;
	else
		return false;
}


/**
 * returns a visible color for printing on top of the specified background (inverse or b/w)
 * @return string containing hex color for the
 * @param object $bg
 * @param object $bwonly[optional]
 */
function font_color($bg, $bwonly = false)
{
	global $config;

	if ($bwonly)
	{
		if (is_bright($bg))
			return '000000';
		else
			return 'FFFFFF';
	}
	else
	{
		$r = dechex(255 - hexdec(substr($bg,0,2)));
		$r = (strlen($r) > 1) ? $r : '0'.$r;
		$g = dechex(255 - hexdec(substr($bg,2,2)));
		$g = (strlen($g) > 1) ? $g : '0'.$g;
		$b = dechex(255 - hexdec(substr($bg,4,2)));
		$b = (strlen($b) > 1) ? $b : '0'.$b;
		return strtoupper($r.$g.$b);
	}
}


/**
 * generate a box filled with the given color
 * @return string containing html of preview box
 * @param object $hex
 * @param object $content[optional]
 * @param object $width[optional]
 */
function color_preview($hex, $content = '', $width='90')
{
	if (empty($content))
		$content = '#' . $hex;
	$font = font_color($hex);
	return "<div style='width: $width%; height: 90%; text-align: center; border: 1px inset; background: #$hex; color: #$font;'>$content</div>\n";
}

/**
 * brightens up the given color by the given degree
 * @return string containing hex color
 * @param object $color
 * @param object $dif[optional]
 */
function color_lighten($color, $dif=20)
{
	$color = str_replace('#', '', $color);
	$rgb = '';
	for ($x = 0; $x < 3; $x++)
	{
		$c = hexdec(substr($color,(2*$x),2)) + $dif;
		$c = ($c > 255) ? 'FF' : dechex($c);
		$rgb .= $c;
	}
	return '#' . $rgb;
}

/**
 * darkens the given color by the given degree
 * @return string containing darkened color
 * @param object $color
 * @param object $dif[optional]
 */
function color_darken($color, $dif=20)
{
	$color = str_replace('#', '', $color);
	$rgb = '';
	for ($x = 0; $x < 3; $x++)
	{
		$c = hexdec(substr($color,(2*$x),2)) - $dif;
		$c = ($c < 0) ? '00' : dechex($c);
		$rgb .= sprintf('%02s', $c);
	}
	return '#' . $rgb;
}

?>
