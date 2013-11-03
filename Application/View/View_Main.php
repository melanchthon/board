<?php $comsLimit = Config::getCommentsOnMainPage(); //количестов комментариев к каждому посту, которые выводятся на главной странце?><div class="l-header">    <div class="wrap">        <h1>Программирование // доска обсуждений</h1>    </div>    <div class="overlay"></div></div><div class="page-threads-list">    <div class="b-top-actions clearfix">		<a href="post/create" class="button button-action">добавить тред</a>	</div>	 	<div class="b-threads-list">		<?php foreach($posts as $post): ?>		<div class="b-thread">			<div class="b-post first-post">				<div class="post-number"><?=$this->h($post->id); ?></div>				<h2 class="thread-topic"><?=$this->h($post->title); ?></a></h2>				<p><?=$this->h($post->content); ?></p>			</div> 						<div class="b-post-info-line">				<?php 					/*узнаю личество пропущеных комментариев*/					$total = $this->h($post->c_number);					$omitted = $total - $comsLimit;					$omitted = ($omitted>0) ? $omitted : 0; 				?>              <?php if($omitted>0):?>			  Пропущено <?=$omitted; ?> комментариев			  <?php endif; ?>            </div>			<?php $comsCount = 0; //текущее количество выведеных к даному посту комментариев?>			<div class="b-post-last-comments">			<?php foreach ($comments as $comment):				if ($comment->post_id == $post->id && $comsCount<$comsLimit):?>					<div class="b-comment">					<div class="post-number"><?=$this->h($comment->id);?>|						<?php						if (!empty($comment->name)){							echo $this->h($comment->name);						} else {						echo Config::getDefaultName();						}						?>					</div>					<p><?=$this->h($comment->content); ?></p>					</div>					<?php $comsCount++;?>				<?php endif;?>			<?php endforeach; ?>			</div>			<div class="b-post-actions clearfix">					<a href="comment/create?thread=<?=$this->h($post->id);?>" class="button-action button-reply">Добавить комментарий</a>					<a href="thread/index?thread=<?=$this->h($post->id);?>" class="button-action button-show-thread">Перейти в тред</a>            </div>		</div>		<?php endforeach; ?>	</div>	 		<div class="b-pager"> 		<?php 			$pagination = new Core_Pagination($currentPage,$pagesCount);			$pagination->generate();		?>	</div>	</div> 