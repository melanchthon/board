<div class="l-header">    <div class="wrap">        <h1>Программирование</h1>    </div>    <div class="overlay"></div></div><div class="page-threads-list">    <div class="b-top-actions clearfix">		<a href="post/create" class="button button-action">добавить тред</a>	</div>	 	<div class="b-threads-list">		<?php foreach($posts as $post): ?>		<div class="b-thread">			<div class="b-post first-post">				<div class="post-number"><?=$this->h($post->id); ?></div>				<h2 class="thread-topic"><?=$this->h($post->title); ?></a></h2>				<p><?=$this->h($post->content); ?></p>			</div> 						<div class="b-post-info-line">                Пропущено 13 комментариев            </div>						<div class="b-post-last-comments">			<?php foreach ($comments as $comment):				if ($comment->post_id == $post->id):?>					<div class="b-comment">					<div class="post-number"><?=$this->h($comment->id);?></div>					<p><?=$this->h($comment->content); ?></p>					</div>				<?php endif;?>			<?php endforeach; ?>			</div>			<div class="b-post-actions clearfix">				<form method="get">					<button class="button-action button-reply" formaction="comment/create" name="thread" value="<?=$this->h($post->id);?>">Добавить комментарий</button>                </form>				<form method="get" action="thread/create?thread=<?=$post->id?>">					<button class="button-action button-show-thread" formaction="thread/index" name="thread" value="<?=$this->h($post->id);?>">Перейти в тред</button>				</form>            </div>		</div>		<?php endforeach; ?>	</div>	 	 	<div class="b-pager"> 		<?php 			$pagination = new Core_Pagination($currentPage,$pagesCount);			$pagination->generate();		?>	</div></div> 