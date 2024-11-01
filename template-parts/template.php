<?php
/*
    Template used to display
    
    Available params:
    ---------------------
    $args['heading'] - Top Heading
    $args['style'] - Style
    $args['rows'] - The number of headings to display the items in
*/

$heading    = $args['heading'];
$style      = $args['style'];
$rows       = $args['rows'];
if ($style) {
    load_template( ULTIMATE_TOC_PATH . '/template-parts/'.$style.'.php', true, [
        'heading'   => $heading,
        'rows'      => $rows
    ]);
}else{
    load_template( ULTIMATE_TOC_PATH . '/template-parts/default.php', true, [
        'heading'   => $heading,
        'rows'      => $rows
    ]);
} 
?>