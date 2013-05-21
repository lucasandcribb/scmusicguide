<figure class="entry-thumbnail">
    <?php
    printf( '<a href="%1$s" title="%2$s" rel="post-%3$d">%4$s</a>',
        esc_url( get_permalink() ),
        sprintf( esc_attr__( '%1$s', 'soundcheck' ), the_title_attribute( array( 'echo' => 0 ) ) ),
        absint( get_the_ID() ),
        get_the_post_thumbnail( get_the_ID(), soundcheck_thumbnail_size() )
    );
    ?>
</figure>
