// JavaScript dans votre fichier admin.js
jQuery(document).ready(function($) {
    $('.edit-image-button').on('click', function(e) {
        e.preventDefault();

        var postId = $(this).data('post-id');
        var imageUrl = $(this).siblings('.product-image').attr('src');

        $('#modalImage').attr('src', imageUrl);
        $('#imageModal').removeClass('hidden').addClass('flex');
    });

    $('#closeModal').on('click', function() {
        $('#imageModal').removeClass('flex').addClass('hidden');
    });
});
