<?php get_header(); ?>
<div class="span-24" id="contentwrap">
	<div class="span-13">
		<div id="content">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Resultados da Pesquisa</h2>

		<?php while (have_posts()) : the_post(); ?>
						<div class="postwrap">
						<div <?php post_class('post') ?> id="post-<?php the_ID(); ?>">
							<h2 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Link permanente para <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
							<div class="postdate">Postado por <strong><?php the_author() ?></strong> em  <?php the_time('j \d\e F \d\e Y') ?> <?php if (current_user_can('edit_post', $post->ID)) { ?> | <?php edit_post_link('Editar', '', ''); } ?></div>
							<div class="entry">
                                <?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { the_post_thumbnail(array(200,160), array('class' => 'alignleft post_thumbnail')); } ?>
								<?php the_excerpt(); ?>
								<div class="readmorecontent">
									<a class="readmore" href="<?php the_permalink() ?>" rel="bookmark" title="Link permanente para <?php the_title_attribute(); ?>">Leia Mais &raquo;</a>
								</div>
							</div>
							
						</div><!--/post-<?php the_ID(); ?>-->
						</div>
				<?php endwhile; ?>

		<div class="navigation">
			<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
			<div class="alignleft"><?php next_posts_link('&laquo; Posts Antigos') ?></div>
			<div class="alignright"><?php previous_posts_link('Posts Recentes &raquo;') ?></div>
			<?php } ?>
		</div>

	<?php else : ?>

		<h2 class="pagetitle">Nenhum post encontrado. Tente uma pesquisa diferente!</h2>
		<?php get_search_form(); ?>

	<?php endif; ?>

		</div>
	</div>

<?php get_sidebars(); ?>
</div>
<?php get_footer(); ?>