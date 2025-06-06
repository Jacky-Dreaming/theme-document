<?php
/*
 * 友情链接页面模板
 * @author 友人a丶
 * @date 2024-01-18
 */

get_header();

/* 获取友情链接数据 */
$bookmarks = get_bookmarks( array(
	'orderby' => 'name',
	'order'   => 'ASC'
) );

/* 转换为JavaScript可用的数据格式 */
$friend_links = array_map( function ( $link ) {
	return array(
		'name'        => $link->link_name,
		'image'       => $link->link_image ?: '',
		'description' => $link->link_description ?: '',
		'url'         => $link->link_url ?: ''
	);
}, $bookmarks );
?>

<?php if ( ! empty( $friend_links ) ): ?>
    <div id="friend-graph" class="friend-graph">
        <ul class="friend-links" style="display: none;">
            <li class="current-site"
                data-name="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
                data-image="<?php echo esc_attr( get_site_icon_url() ); ?>"
                data-description="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>">
            </li>
			<?php foreach ( $friend_links as $link ): ?>
                <li class="friend-link"
                    data-name="<?php echo esc_attr( $link['name'] ); ?>"
                    data-image="<?php
				    if ( empty( $link['image'] ) ) {
					    $url = parse_url( $link['url'] );
					    echo esc_attr( "{$url['scheme']}://{$url['host']}/favicon.ico" );
				    } else {
					    echo esc_attr( $link['image'] );
				    }
				    ?>"
                    data-description="<?php echo esc_attr( $link['description'] ); ?>"
                    data-url="<?php echo esc_attr( $link['url'] ); ?>">
                    <a title="<?php echo esc_attr( $link['name']  ); ?>" href="<?php echo esc_attr( $link['url'] ); ?>"><?php echo esc_attr( $link['name'] ); ?></a>
                </li>
			<?php endforeach; ?>
        </ul>
    </div>
<?php else: ?>
    <p class="text-center">暂无友情链接</p>
<?php endif; ?>

<?php get_footer(); ?>
