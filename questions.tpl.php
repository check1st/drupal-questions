<h1><?php echo variable_get("questions_title", t("Отзывы")); ?></h1>
<?php foreach ($result as $row): ?>
<div class="questions">
	<div class="question">
		<?php if (user_access('administer questions')): ?><div class="question-actions"><button data-action="activate" data-qid="<?php echo $row->qid; ?>"><i class="fa fa-eye"></i></button> <button data-action="remove" data-qid="<?php echo $row->qid; ?>"><i class="fa fa-remove"></i></button></div><?php endif; ?>
		<div class="question-row-name">Написал: <b><?php echo $row->qname; ?></b> в <?php echo format_date($row->qcreated, "short"); ?></div>
		<div class="question-row-body"><?php echo $row->qbody; ?></div>
	</div>
	<?php if ($row->aid): ?>
	<div class="answer">
		<div class="answer-row-name">Ответил: <b><?php echo $row->aname; ?></b> в <?php echo format_date($row->acreated, "short"); ?></div>
		<div class="answer-row-body"><?php echo $row->abody; ?></div>
	</div>
	<?php endif; ?>
</div>
<?php endforeach; ?>
<div class="questions-form">
	<?php echo render(drupal_get_form("question_user_form")); ?>
</div>
<script>
(function($){
$("body").on("click", ".question-actions button", function(){
switch ($(this).attr("data-action")) {
	case "activate":
	break;
	case "remove":
		if ($(this).parent().parent().hasClass("question")) $(this).parent().parent().parent().slideUp();
		else $(this).parent().parent().slideUp();
		$.get("/admin/config/content/questions/question?action=remove&qid=" + $(this).attr("data-qid"));
	break;
}
});
})(jQuery);
</script>