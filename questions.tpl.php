<?php foreach ($result as $row): ?>
<div class="questions">
	<div class="question">
		<?php if (user_access('administer questions')): ?><div class="question-actions">
			<?php if (!$row->published): ?><button data-action="activate" data-qid="<?php echo $row->qid; ?>"><?php echo t("Publish content"); ?></button><?php endif; ?> <button data-action="reply" data-qid="<?php echo $row->qid; ?>"><?php echo t("Reply to"); ?></button> <button data-action="remove" data-qid="<?php echo $row->qid; ?>"><?php echo t("Remove"); ?></button></div><?php endif; ?>
		<div class="question-row-name"><?php echo t("Submitted by !username on !datetime", array("!username" => "<b>" . $row->name . "</b>", "!datetime" => "<b>" . format_date($row->created, "short") . "</b>")); ?></div>
		<div class="clearfix"></div>
		<div class="question-row-body"><?php echo $row->body; ?></div>
	</div>
	<?php if ($row->a_qid): ?>
	<div class="answer">
		<?php if (user_access('administer questions')): ?><div class="question-actions">
			<button data-action="remove" data-qid="<?php echo $row->a_qid; ?>"><?php echo t("Remove"); ?></button></div><?php endif; ?>
		<div class="answer-row-name"><?php echo t("Submitted by !username on !datetime", array("!username" => "<b>" . $row->a_name . "</b>", "!datetime" => "<b>" . format_date($row->a_created, "short") . "</b>")); ?></div>
		<div class="clearfix"></div>
		<div class="answer-row-body"><?php echo nl2br($row->a_body); ?></div>
	</div>
	<?php endif; ?>
</div>
<?php endforeach; ?>
<div class="pager">
<?php echo $pager; ?>
</div>
<div class="questions-form">
	<?php echo render($questions_form); ?>
</div>
<?php if (user_access('administer questions')): ?>
<script>
(function($){
$("body").on("click", ".question-actions button", function(){
switch ($(this).attr("data-action")) {
	case "activate":
		$.get("/admin/config/content/questions/question?action=activate&qid=" + $(this).attr("data-qid"));
		$(this).fadeOut();
	break;
	case "remove":
		if ($(this).parent().parent().hasClass("question")) $(this).parent().parent().parent().slideUp();
		else $(this).parent().parent().slideUp();
		$.get("/admin/config/content/questions/question?action=remove&qid=" + $(this).attr("data-qid"));
	break;
	case "reply":
		$("#question-user-form input[name=name]").val("<?php echo variable_get('site_name'); ?>");
		$('#question-user-form textarea[name=body]').val("Здравствуйте, " + $(this).parent().parent().find(".question-row-name b:last").text() + "\r\n");
		$("#question-user-form input[name=parent]").val($(this).attr("data-qid"));
		$("#question-user-form input[name=op]").val("<?php echo t("Reply to"); ?>" + ": #" + $(this).attr("data-qid"));
		$("html, body").animate({ scrollTop: $("#question-user-form").offset().top }, 500);
	break;
}
});
})(jQuery);
</script>
<?php endif; ?>