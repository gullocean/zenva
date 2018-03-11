<?php
    global $post;
    $featured_img_url = get_the_post_thumbnail_url($post->ID, 'medium');
?>
<div id="modal-<?php echo $post->ID; ?>" class="zva-ef-modal modal">
    <form onsubmit="return false;">
        <h2 class="zva_ef_heading">File Download Link</h2>
        <img src="<?php echo $featured_img_url; ?>" alt="<?php echo $post->post_title; ?>" width="100%" />
        <p style="font-size:80%;">Send me a download link for the files of <em><?php echo $post->post_title; ?></em>.</p>
        <input type="email" value="" name="zva_ef_email" class="email" placeholder="email address" required />
        <input type="hidden" name="zva_ef_file_id" />
        <div class="actions">
            <input type="submit" class="zva-ef-submit" value="Send Files" />
            <input type="button" class="zva-ef-close" value="Close" />
        </div>
    </form>
</div>

<div id="zva_ef_confirm_dialog" class="zva-ef-modal modal">
    <div class="content"></div>
    <div class="actions">
        <input type="button" class="zva-ef-close" value="Close" />
    </div>
</div>

