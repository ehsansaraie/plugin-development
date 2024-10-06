<?php

namespace FalconBaseServices\Services;

use FalconBaseServices\Model\Book;

class CustomMetaBox
{
    public function register()
    {
        add_action('add_meta_boxes', function () {
            add_meta_box(
                'book_isbn_meta_box',
                __('Book ISBN', 'textdomain'),
                [$this, 'render'],
                'book',
                'side'
            );
        });

        // ثبت اکشن برای AJAX
        add_action('wp_ajax_save_book_isbn', [$this, 'save']);
    }

    public function render($post)
    {
        $isbn = Book::where('post_id', $post->ID)->first()->isbn ?? '';
        echo '<label for="book_isbn">ISBN:</label>';
        echo '<input type="text" name="book_isbn" id="book_isbn" value="' . esc_attr($isbn) . '" />';
        echo '<button type="button" class="button" id="save_isbn_button">' . __('Save ISBN', 'textdomain') . '</button>';
        
        // کد JavaScript برای ارسال اطلاعات به صورت AJAX
        ?>
        <script>
            jQuery(document).ready(function($) {
                $('#save_isbn_button').on('click', function() {
                    var isbn = $('#book_isbn').val();
                    var postId = <?= json_encode($post->ID); ?>;

                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'save_book_isbn',
                            book_isbn: isbn,
                            post_id: postId
                        },
                        success: function(response) {
                            if (response.success) {
                                alert('ISBN saved successfully.');
                            } else {
                                alert('Error saving ISBN: ' + response.data);
                            }
                        },
                        error: function() {
                            alert('Error with AJAX request.');
                        }
                    });
                });
            });
        </script>
        <?php
    }

    public function save()
    {
        if (!isset($_POST['book_isbn']) || !isset($_POST['post_id'])) {
            wp_send_json_error('Invalid request.');
        }

        $postId = intval($_POST['post_id']);
        $isbn = sanitize_text_field($_POST['book_isbn']);

        Book::updateOrCreate(
            ['post_id' => $postId],
            ['isbn' => $isbn]
        );

        wp_send_json_success();
    }
}
