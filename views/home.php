<!-- home.php -->

<!-- En-tête avec Tailwind CSS -->
<div class="p-6">
    <h1 class="text-3xl mb-4">Liste des Produits</h1>

    <?php
    // Arguments pour récupérer les produits
    $args = array(
        'post_type' => 'produit',
        'posts_per_page' => -1
    );

    // Nouvelle requête
    $loop = new WP_Query($args);

    // Vérifier s'il y a des produits
    if ($loop->have_posts()) :
    ?>
        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
            <ul>
                <?php while ($loop->have_posts()) : $loop->the_post();
                    $image = get_field('field_image_produit');
                ?>
                    <li class="py-4 px-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <?php if ($image) : ?>
                                <div class="flex-shrink-0 h-12 w-12">
                                    <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="rounded-full h-12 w-12 object-cover">
                                </div>
                            <?php else : ?>
                                <div class="flex-shrink-0 h-12 w-12 bg-gray-200 rounded-full"></div>
                            <?php endif; ?>
                            <div class="ml-4">
                                <h2 class="text-lg font-medium text-gray-900"><?php the_title(); ?></h2>
                            </div>
                        </div>
                        <button class="ml-4 px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 focus:outline-none edit-image-button" data-post-id="<?php echo get_the_ID(); ?>">Modifier</button>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php
    else :
        echo '<p class="mt-4">Aucun produit trouvé</p>';
    endif;

    // Réinitialiser les données post
    wp_reset_postdata();
    ?>
</div>

<!-- Modal améliorée avec Tailwind CSS -->
<div id="imageModal" class="fixed top-0 left-0 right-0 bottom-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
    <div class="bg-white p-4 rounded-lg shadow-lg overflow-hidden max-w-3xl max-h-screen relative">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="flex">
            <img src="" alt="Image produit" id="modalImage" class="w-full h-auto">
            <div class="bg-white w-16 p-4 flex flex-col items-center justify-center">
                <!-- Ici vous pouvez ajouter vos icônes pour les outils -->
                <button class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 mb-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
                <button class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 mb-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </button>
                <button class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 mb-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script JavaScript pour gérer la modal -->
<script>
    // JavaScript dans votre fichier admin.js ou directement ici
    jQuery(document).ready(function($) {
        $('.edit-image-button').on('click', function(e) {
            e.preventDefault();

            var postId = $(this).data('post-id');
            var imageUrl = $(this).siblings('.flex').find('img').attr('src');

            $('#modalImage').attr('src', imageUrl);
            $('#imageModal').removeClass('hidden').addClass('flex');
        });

        $('#closeModal').on('click', function() {
            $('#imageModal').removeClass('flex').addClass('hidden');
        });
    });
</script>
