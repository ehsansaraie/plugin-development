<?php

namespace FalconBaseServices\Services;

use FalconBaseServices\Model\Book;

class AdminDisplay
{
    public function register()
    {
        add_action('admin_menu', [$this, 'addAdminPage']);
    }

    public function addAdminPage()
    {
        add_menu_page(
            __('Book Infos', 'textdomain'),
            __('Book Infos', 'textdomain'),
            'manage_options',
            'book-infos',
            [$this, 'displayPage'],
            'dashicons-book',
            6
        );
    }

    public function displayPage()
    {
        $books = Book::with('post')->get();

        echo '<div class="wrap">';
        echo '<h1>' . __('Book Infos', 'textdomain') . '</h1>';
        echo '<table class="wp-list-table striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>' . __('ID', 'textdomain') . '</th>';
        echo '<th>' . __('Post ID', 'textdomain') . '</th>';
        echo '<th>' . __('Post Title', 'textdomain') . '</th>';
        echo '<th>' . __('ISBN', 'textdomain') . '</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        if ($books->isEmpty()) {
            echo '<tr><td colspan="4">' . __('No books found', 'textdomain') . '</td></tr>';
        } else {
            foreach ($books as $book) {
                echo '<tr>';
                echo '<td>' . esc_html($book->ID) . '</td>';
                echo '<td>' . esc_html($book->post_id) . '</td>';
                echo '<td>' . esc_html($book->post->post_title ?? 'N/A') . '</td>';
                echo '<td>' . esc_html($book->isbn) . '</td>';
                echo '</tr>';
            }
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }
}
