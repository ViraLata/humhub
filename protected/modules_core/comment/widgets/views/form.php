<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<?php /* BEGIN: Comment Create Form */ ?>
<div id="comment_create_form_<?php echo $id; ?>">

    <?php echo CHtml::form("#"); ?>
    <?php echo CHtml::hiddenField('model', $modelName); ?>
    <?php echo CHtml::hiddenField('id', $modelId); ?>

    <?php echo CHtml::textArea("message", "", array('id' => 'newCommentForm_' . $id, 'rows' => '1', 'class' => 'form-control autosize commentForm', 'placeholder' => 'Write a new comment...')); ?>

    <?php
    /* Modify textarea for mention input */
    $this->widget('application.widgets.MentionWidget', array(
        'element' => '#newCommentForm_' . $id,
    ));
    ?>

    <?php
    echo HHtml::ajaxSubmitButton(Yii::t('CommentModule.widgets_views_form', 'Post'), CHtml::normalizeUrl(array('/comment/comment/post')), array(
        'beforeSend' => "function() {
                $('#newCommentForm_" . $id . "').blur();
                }",
        'success' => "function(html) {
            
            $('#comments_area_" . $id . "').html(html);
            $('#newCommentForm_" . $id . "').val('').trigger('autosize.resize');
            $.fn.mention.reset('#newCommentForm_" . $id . "');

        }",
            ), array(
        'id' => "comment_create_post_" . $id,
        'class' => 'btn btn-small btn-primary',
        'style' => 'position: absolute; top: -3000px; left: -3000px;',
            )
    );
    ?>

    <?php echo Chtml::endForm(); ?>

</div>

<script>
    // Fire click event for comment button by typing enter
    $('#newCommentForm_<?php echo $id; ?>').keydown(function(event) {

        if (event.keyCode == 13) {

            if ($.fn.mention.defaults.stateUserList == false) {

                event.cancelBubble = true;
                event.returnValue = false;

                $('#comment_create_post_<?php echo $id; ?>').focus();
                $('#comment_create_post_<?php echo $id; ?>').click();

                // empty input
                //$(this).val('');

            }

        }

        return event.returnValue;

    });

    // set the size for one row (Firefox)
    $('#newCommentForm_<?php echo $id; ?>').css({height: '36px'});

    // add autosize function to input
    $('.autosize').autosize();

</script>