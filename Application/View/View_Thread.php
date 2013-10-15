<div class="l-header">
    <div class="wrap">
        <h1><?=$this->h($post->title); ?></h1>
    </div>
    <div class="overlay"></div>
</div>

<div class="page-thread">

    <div class="b-threads-list">
        <div class="b-thread">
            <div class="b-post first-post">            
                <div class="post-number"><?=$this->h($post->id);?></div>
                
                <p><?=$this->h($post->content); ?></p>
            </div>
			
			<?php foreach ($comments as $comment):?>
            <div class="b-post">            
                <div class="post-number"><?=$this->h($comment->id); ?></div>
                
                <p><?=$this->h($comment->content); ?></p>        
            </div>
			<?php endforeach; ?>
            <div class="b-post-actions clearfix">
                <form method="get">
					<button class="button-action button-reply" formaction="../comment/create" name="thread" value="<?=$this->h($post->id);?>">Добавить комментарий</button>
                </form>
                <a href="../" class="button-left back-link">← вернуться на главную</a>
            </div>
        </div>
    </div>
</div>